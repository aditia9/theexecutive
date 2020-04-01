<?php

namespace Ranosys\Quote\Plugin;

use Magento\Framework\App\ObjectManager;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class CartItemRepositoryPlugin {
    
    /**
     * @var CartItemOptionsProcessor
     */
    private $cartItemOptionsProcessor;
    
    /**
     * @var \Magento\Quote\Api\Data\CartItemExtensionInterfaceFactory 
     */
    protected $cartItemExtensionFactory;
    
    /**
     * @var \Ranosys\Catalog\Helper\Catalog
     */
    protected $catalogHelper;
    
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface 
     */
    protected $productRepositoryInterface;
    
    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $stockRegistryInterface;
    
    public function __construct(
        \Magento\Quote\Api\Data\CartItemExtensionInterfaceFactory $cartItemExtensionFactory,
        \Ranosys\Catalog\Helper\Catalog $catalogHelper,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface
    ) {
        $this->cartItemExtensionFactory = $cartItemExtensionFactory;
        $this->catalogHelper = $catalogHelper;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->stockRegistryInterface = $stockRegistryInterface;
    }
    
    public function afterGetList(\Magento\Quote\Api\CartItemRepositoryInterface $cartItemRepository, $result, $cartId) {
        
        $output = [];
        /** @var  \Magento\Quote\Model\Quote\Item  $item */
        foreach ($result as $item) {
            
            $extensibleAttribute = $item->getExtensionAttributes();
            if(!$extensibleAttribute){
                $extensibleAttribute = $this->cartItemExtensionFactory->create();
            }
            
            $product = $item->getProduct();
            if($product->getTypeId() == Configurable::TYPE_CODE){
                $configurable_sku = $product->getData('sku');
                $simpleProduct = $this->productRepositoryInterface->get($item->getSku());
                $image = $simpleProduct->getImage();
                if(!$image){
                    $image = $product->getSmallImage();
                }
                $extensibleAttribute->setConfigurableSku($configurable_sku);
            } else {
                $image = $product->getImage();
                if(!$image){
                    $image = $product->getSmallImage();
                }
            }
            
            $stockItem = $this->stockRegistryInterface->getStockItemBySku($item->getSku());
            
            //load product collection by id for specific product as we need to get max price for the configurable product 
            //to be in synch with frontend listing logic
            $regularPrice = $this->catalogHelper->getProductMaxPrice($product);
            
            $extensibleAttribute->setRegularPrice($regularPrice);
            $extensibleAttribute->setImage($image);
            $extensibleAttribute->setStockItem($stockItem);
            $item->setExtensionAttributes($extensibleAttribute);
            
            $output[] = $item;
        }
        
        
        return $output;
    }
    
    
    
}