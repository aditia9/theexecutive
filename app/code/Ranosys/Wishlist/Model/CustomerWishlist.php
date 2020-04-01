<?php

namespace Ranosys\Wishlist\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Catalog\Model\Product\Exception as ProductException;

class CustomerWishlist implements \Ranosys\Wishlist\Api\CustomerWishlistInterface {

    /*
     * @var productFactory
     */
    protected $productRepository;
    
    /*
     * @var wishlistFactory
     */
    protected $wishlistFactory;
    /**
     *
     * @var  \Magento\Framework\Event\Manager
     */
    protected $eventManager;
    
    /**
     *
     * @var \Ranosys\Wishlist\Model\Data\WishlistInformationFactory 
     */
    protected $wishlistInformationFactory;
    
    /**
     *
     * @var \Ranosys\Wishlist\Model\Data\WishlistItemFactory
     */
    protected $wishlistItemFactory;
    
    /**
     *
     * @var \Magento\Wishlist\Block\Customer\Wishlist\Item\Options
     */
    protected $optionsBlock;
    
    /**
     *
     * @var \Ranosys\Wishlist\Model\Data\WishlistItemOptionsFactory
     */
    protected $wishlistItemOptionsFactory;
    
    /**
     *
     * @var \Magento\Wishlist\Model\ItemFactory
     */
    protected $itemFactory;
    
    /**
     *
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;
    
    /**
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    
    /**
     *
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    
    /**
     *
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
    
    /**
     *
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $stockRegistryInterface;
    

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Ranosys\Wishlist\Model\Data\WishlistInformationFactory $wishlistInformationFactory,
        \Ranosys\Wishlist\Model\Data\WishlistItemFactory $wishlistItemFactory,
        \Ranosys\Wishlist\Model\Data\WishlistItemOptionsFactory $wishlistItemOptionsFactory,
        \Magento\Wishlist\Block\Customer\Wishlist\Item\Options $optionsBlock,
        \Magento\Wishlist\Model\ItemFactory $itemFactory,
        \Magento\Framework\Event\Manager $eventManager,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Wishlist\Model\LocaleQuantityProcessor $quantityProcessor,
        \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider,
        \Magento\Wishlist\Model\Item\OptionFactory $optionFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface
    ) {
        $this->productRepository = $productRepository;
        $this->wishlistFactory = $wishlistFactory;
        $this->wishlistInformationFactory = $wishlistInformationFactory;
        $this->wishlistItemFactory = $wishlistItemFactory;
        $this->wishlistItemOptionsFactory = $wishlistItemOptionsFactory;
        $this->optionsBlock = $optionsBlock;
        $this->eventManager = $eventManager;
        $this->itemFactory = $itemFactory;
        $this->cart = $cart;
        $this->productHelper = $productHelper;
        $this->quantityProcessor = $quantityProcessor;
        $this->wishlistProvider = $wishlistProvider;
        $this->optionFactory = $optionFactory;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->stockRegistryInterface = $stockRegistryInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function addToWishlist($customerId, $productSku, $options = null) {
        
        try {
            $product = $this->productRepository->get($productSku);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }
        
        if (!$product || !$product->isVisibleInCatalog()) {
            throw new LocalizedException(__('We can\'t specify a product.'));
        }
               
        if($options){
            $buyRequest = $this->prepareBuyRequest($product->getId(), $options);
        } else {
            $buyRequest = null;
        }

        $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
        $result = $wishlist->addNewItem($product, $buyRequest);

        if (is_string($result)) {
            throw new LocalizedException(__($result));
        }

        $wishlist->save();

        $this->eventManager->dispatch(
            'wishlist_add_product',
            ['wishlist' => $wishlist, 'product' => $product, 'item' => $result]
        );     
        
        return sprintf('%s', __('Product added to Wishlist.'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getInformation($customerId){
        $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
        
        if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The requested Wish List doesn\'t exist.')
            );
        }
        
        $ItemsCollection = $wishlist->getItemCollection();
        $ItemsCollection->getSelect()->order('added_at DESC');
        
        $wishlistInformation = $this->wishlistInformationFactory->create();
        $wishlistInformation->setId($wishlist->getId());
        $wishlistInformation->setName($wishlist->getName());
        $wishlistInformation->setItemsCount($wishlist->getItemsCount());
        
        $wishlistItems = [];
        foreach($ItemsCollection as $item){
            $wishlistItem = $this->wishlistItemFactory->create();
            $product = $item->getProduct();
            $itemoptions = $this->optionsBlock->setItem($item)->getConfiguredOptions();
            $wishlistItem->setId($item->getId());
            $wishlistItem->setProductId($product->getId());
            $wishlistItem->setTypeId($product->getTypeId());
            $wishlistItem->setQty($item->getQty());
            $wishlistItem->setSku($product->getData('sku'));
            $wishlistItem->setName($product->getName());
            $wishlistItem->setImage($product->getSmallImage());
            
            if($itemoptions){
                $wishlistItem->setRegularPrice($product->getPrice());
            } else{
                $wishlistItem->setRegularPrice($product->getMaxPrice());      
            }
            
            $wishlistItem->setFinalPrice($product->getPriceInfo()->getPrice('wishlist_configured_price')->getValue());
            
            $stockItem = $this->stockRegistryInterface->getStockItemBySku($product->getSku());
            
            $wishlistItem->setStockItem($stockItem);
            
            $wishlistItemOptions = [];
            foreach($itemoptions as $option){
                $wishlistItemOption = $this->wishlistItemOptionsFactory->create();
                $wishlistItemOption->setLabel($option['label']);
                $wishlistItemOption->setValue($option['value']);
                $wishlistItemOption->setOptionId($option['option_id']);
                $wishlistItemOption->setOptionValue($option['option_value']);
                
                $wishlistItemOptions[] = $wishlistItemOption;
            }
            
            $wishlistItem->setOptions($wishlistItemOptions);
            
            $wishlistItems[] = $wishlistItem;
        }
        
        $wishlistInformation->setItems($wishlistItems);
        
        return $wishlistInformation;
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteItem($customerId, $id) {
        $item = $this->itemFactory->create()->load($id);
        if (!$item->getId()) {
            throw new NotFoundException(__('Wishlist Item doesn\'t exist.'));
        }
        
        $wishlist = $this->wishlistFactory->create()->load($item->getWishlistId());
        if (!$wishlist) {
            throw new NotFoundException(__('Wishlist doesn\'t exist.'));
        }
        
        try{
            $item->delete();
            $wishlist->save();
            
            return sprintf('%s', __('Wishlist item deleted successfully.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return sprintf('%s', __('We can\'t delete the item from Wish List right now because of an error: %1.', $e->getMessage()));
        } catch (\Exception $e) {
            return sprintf('%s', __('We can\'t delete the item from the Wish List right now.'));
        }
    }
    
    protected function prepareBuyRequest($productId, $options){
        $requestParams = array(
            'product' => $productId,
            'qty' => 1
        );
        
        foreach($options as $attributeCode => $attributeValue){
            $requestParams['super_attribute'][$attributeCode] = $attributeValue;
        }
        
        $buyRequest = new \Magento\Framework\DataObject($requestParams);
        
        return $buyRequest;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addToCart($customerId, $cartId, $id, $qty=1) {
        
        $item = $this->itemFactory->create()->load($id);
        if (!$item->getId()) {
            throw new NotFoundException(__('Wishlist Item doesn\'t exist.')); 
        }
        
        try {
            $customer = $this->customerFactory->create()->load($customerId);
            $this->customerSession->setCustomer($customer);

            $this->checkoutSession->setQuoteId($cartId);
            
            $wishlist = $this->wishlistProvider->getWishlist($item->getWishlistId());
            
            if(!$wishlist){
                throw new LocalizedException(__('Wishlist doesn\'t exist.'));
            }
            
            /** @var \Magento\Wishlist\Model\ResourceModel\Item\Option\Collection $options */
            $options = $this->optionFactory->create()->getCollection()->addItemFilter([$id]);

            $item->setOptions($options->getOptionsByItem($id));

//            $qty = $item->getQty();
            $quantity = $this->quantityProcessor->process($qty);
            if ($quantity) {
                $item->setQty($qty);
            }
            $getparams = [
                "item" => $id,
                "qty" => $qty
            ];
            $buyRequest = $this->productHelper->addParamsToBuyRequest(
                $getparams,
                ['current_config' => $item->getBuyRequest()]
            );

            $item->mergeBuyRequest($buyRequest);
            $item->addToCart($this->cart, true);
            $this->cart->save()->getQuote()->collectTotals();
            $wishlist->save();
            return sprintf('%s', __('Product added to cart successfully.'));
        } catch (ProductException $e) {
            throw new LocalizedException(__('This product(s) is out of stock.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new LocalizedException(__('We can\'t add the item to the cart right now.'));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function moveToWishlistFromCart($customerId, $cartId, $id) {          
        $wishlist = $this->wishlistFactory->create()->loadByCustomerId($customerId, true);
        if (!$wishlist) {
            throw new NotFoundException(__('Wishlist doesn\'t exist.'));
        }

        try {
            $customer = $this->customerFactory->create()->load($customerId);
            $this->customerSession->setCustomer($customer);

            $this->checkoutSession->setQuoteId($cartId);
                   
            $item = $this->cart->getQuote()->getItemById($id);
            if (!$item) {
                throw new LocalizedException(
                    __('The requested cart item doesn\'t exist.')
                );
            }

            $productId = $item->getProductId();
            $product = $this->productRepository->getById($productId);
            $buyRequest = $item->getBuyRequest();
            $wishlist->addNewItem($productId, $buyRequest);

            //$this->cart->getQuote()->removeItem($id);
            //$this->cart->save();

            $wishlist->save();

            return sprintf('%s', __('%1 added to wishlist successfully.', $product->getName()));
            
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new LocalizedException(__('We can\'t move the item to the wish list.'));
        }
    }

}
