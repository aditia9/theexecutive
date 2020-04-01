<?php
namespace Ematicsolutions\Ematicjs\Helper;


//This has to be named like this
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    //Configuration constants

    const XML_API_KEY        = 'ematicjs_options/ematicsolutions_group/ematicsolutions_api_key';
    const XML_USE_LONG_DESC  = 'ematicjs_options/ematicsolutions_group/ematicsolutions_longdesc';
    const XML_CART_MATCH     = 'ematicjs_options/ematicsolutions_group_adv/ematicsolutions_search';
    const XML_CHECKOUT_MATCH = 'ematicjs_options/ematicsolutions_group_adv/ematicsolutions_checkout';

    const CART_KEY          = 'ematic_cart_updated';
    const CART_KEY_PRODUCTS = 'ematic_cart_products';
    const LOG_MODE          = 'ematic_log_mode';
    const PRODUCT_KEY       = 'ematic_product';

    const TRANSACTION_KEY   = 'ematic_transaction_id';

    const MOD_CHECKOUT      = 'checkout';
    const MOD_CONVERT       = 'convert';
    const MOD_CART          = 'cart';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $catalogProductFactory;

    /**
     * @var \Magento\Catalog\Helper\Product\Configuration
     */
    protected $catalogProductConfigurationHelper;

    /**
     * @var \Magento\Checkout\Model\CartFactory
     */
    protected $checkoutCartFactory;

    protected $priceHelper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    protected $localeResolver;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        //\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $catalogProductFactory,
        \Magento\Catalog\Helper\Product\Configuration $catalogProductConfigurationHelper,
        \Magento\Checkout\Model\CartFactory $checkoutCartFactory,
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Locale\Resolver $localeResolver
    ) {
        $this->scopeConfig = $context;
        $this->storeManager = $storeManager;
        $this->catalogProductFactory = $catalogProductFactory;
        $this->catalogProductConfigurationHelper = $catalogProductConfigurationHelper;
        $this->checkoutCartFactory = $checkoutCartFactory;
        $this->priceHelper = $priceHelper;
        $this->customerSession = $customerSession;
        $this->localeResolver = $localeResolver;

        parent::__construct(
            $context
        );
    }


    /**
    * Get API key from settings
    */
    public function getEmaticApiKey($store = null)
    {
        return trim($this->scopeConfig->getValue(self::XML_API_KEY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store));
    }

    /**
     * Get search string for cart url triggers. Defaults to 'cart'.
     */
    public function getCartMatch($store = null)
    {
        $str = $this->scopeConfig->getValue(self::XML_CART_MATCH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        
        return preg_split("/\R/", $str);
    }

    /**
     * Get search string for checkout url triggers. Defaults to 'checkout/onepage'.
     */
    public function getCheckoutMatch($store = null)
    {
        $str = $this->scopeConfig->getValue(self::XML_CHECKOUT_MATCH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);

        return preg_split("/\R/", $str);
    }

    /**
    * Get "Use long description" setting
    */
    public function getUseLongDesc($store = null)
    {
        return $this->scopeConfig->getValue(self::XML_USE_LONG_DESC, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }

    /**
     * Get product details for product browse log. 
     * @param $product 
     * @return array 
     */
    public function getProduct($product) {

        $useLongDesc = $this->getUseLongDesc();
        $categories = $product->getCategoryIds();
        $reloadedProduct = $this->catalogProductFactory->create()->load($product->getId());
        $brand_name = $reloadedProduct->getAttributeText('manufacturer');

        return array(
            'id'            => $product->getId(),
            'categoryId'    => empty($categories)?"":$categories[0],
            'transactionId' => '',
            'price'         => $this->priceHelper->currency($product->getPrice(),true,false),
            'quantity'      => 1,
            'name'          => html_entity_decode(strip_tags($product->getName())),
            'brandName'     => $brand_name?$brand_name:'',
            'desc'          => html_entity_decode(strip_tags($useLongDesc?$reloadedProduct->getDescription():$reloadedProduct->getShortDescription())), 
            'imageUrl'      => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA). 'catalog/product'.$product->getImage(),
            'link'          => $product->getProductUrl(),
        );

    }

    /**
     * Get mapped product array from product array
     * @param array $list Array of items
     * @param string $type Type of product options
     * @return array
     */
    private function _getProductsIn($list, $type='cart') {
        $useLongDesc = $this->getUseLongDesc();

        //Map cart products into required format
        return array_map(function ($item) use ($useLongDesc, $type) {
            
            $product = $item->getProduct();
            $reloadedProduct = $this->catalogProductFactory->create()->load($product->getId());
            $options =  $product->getTypeInstance(true)->getOrderOptions($item->getProduct());
            
            $brand_name = $reloadedProduct->getAttributeText('manufacturer');
            $categories = $product->getCategoryIds();

            $data = array(
                'id'            => $item->getProductId(),
                'categoryId'    => empty($categories)?"":$categories[0],
                'transactionId' => '',
                'price'         => $this->priceHelper->currency($item->getPrice(),true,false),
                'quantity'      => $item->getQty()?$item->getQty():$item->getQtyOrdered(),
                'name'          => html_entity_decode(strip_tags($item->getName())),
                'brandName'     => $brand_name?$brand_name:'',
                'desc'          => html_entity_decode(strip_tags($useLongDesc?$reloadedProduct->getDescription():$reloadedProduct->getShortDescription())), 
                'imageUrl'      => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA). 'catalog/product'.$reloadedProduct->getImage(),
                'link'          => $product->getProductUrl(),
            );

            //Get misc attributes

            $misc_counter = 1;
            $helper = $this->catalogProductConfigurationHelper; 

            try {
                //Custom options
                if ($type == 'cart') {
                    $confops = $helper->getOptions($item);
                    if ($confops) {
                        foreach ($confops as $o) {
                            
                            //Limit to 3 misc items
                            if ($misc_counter > 3) {
                                break;
                            }

                            $data['misc'.$misc_counter] = $o['value'];
                            $misc_counter++;
                        }
                    }
                } else {
                    
                    if ($ops = $item->getProductOptions()) {
                        $confops = array();

                        if (isset($ops['options'])) {
                            $confops = array_merge($confops, $ops['options']);
                        }
                        if (isset($ops['additional_options'])) {
                            $confops = array_merge($confops, $ops['additional_options']);
                        }
                        if (!empty($ops['attributes_info'])) {
                            $confops = array_merge($ops['attributes_info'], $confops);
                        }

                        foreach ($confops as $o) {
                            
                            //Limit to 3 misc items
                            if ($misc_counter > 3) {
                                break;
                            }

                            $data['misc'.$misc_counter] = $o['value'];
                            $misc_counter++;
                        }

                    }
                }

                
            } catch (Exception $e) {
                //useless, ignore
            }
            
            return $data;      

        }, $list);
    }

    /**
     * Get products in shopping cart.
     * @return array  Products array
     */
    public function getProductsInCart() {
        return $this->_getProductsIn($this->checkoutCartFactory->create()->getQuote()->getAllVisibleItems());
    }

    /**
     * Get products from order 
     * @param Order $order
     * @return array Products array
     */
    public function getProductsInOrder($order) {
        return $this->_getProductsIn($order->getAllVisibleItems(), 'order');
    }

    /**
     * Get options for Ematic.js initialization.
     * @return array Array with keys: email, country_iso, currency_iso, language_iso
     */
    public function getScriptOptions() {

        $email = ($this->customerSession->isLoggedIn())?$this->customerSession->getCustomer()->getEmail():'';

        return array(
            'email'         => $email,
            'country_iso'   => $this->scopeConfig->getValue('general/country/default', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'currency_iso'  => $this->storeManager->getStore()->getCurrentCurrencyCode(),
            'language_iso'  => substr($this->localeResolver->getLocale(), 0, 2)
        );

    }

      /**
     * Check if cart is updated.
     * @return boolean
     */
    public static function cartIsUpdated() {
        return isset($_SESSION[self::CART_KEY])?$_SESSION[self::CART_KEY]:false;
    }

    /**
     * Set cart-is-updated flag. 
     * @param boolean $updated The flag. Defaults to true.
     */
    public static function setCartUpdated($updated=true) {
        $_SESSION[self::CART_KEY] = $updated;
    }

    /**
     * Get log mode from session. Defaults to MOD_CART.
     * @return string
     */
    public static function getLogMode() {
        return isset($_SESSION[self::LOG_MODE])?$_SESSION[self::LOG_MODE]:self::MOD_CART;
    }

}