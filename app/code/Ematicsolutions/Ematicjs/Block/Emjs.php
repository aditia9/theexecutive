<?php

namespace Ematicsolutions\Ematicjs\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

use \Ematicsolutions\Ematicjs\Helper\Data;

/**
 * Ematic.js Page Block
 */
class Emjs extends Template {

    protected $_helper;
    protected $_registry;

    public function __construct( Context $context, Data $helper, \Magento\Framework\Registry $registry, array $data = []) {
        $this->_helper = $helper;
        $this->_registry = $registry;

        parent::__construct($context, $data);
    }

    /**
     * Get helper for use within block.
     * @return Data
     */
    public function getHelper() {
        return $this->_helper;
    }

    /**
     * Get log mode from session. Defaults to MOD_CART.
     * @return string
     */
    private function getLogMode() {
        return isset($_SESSION[Data::LOG_MODE])?$_SESSION[Data::LOG_MODE]:Data::MOD_CART;
    }

    /**
     * Get transaction ID from session if available.
     * @return string Transaction ID, defaults to empty string
     */
    private function getTransactionId() {
        return isset($_SESSION[Data::TRANSACTION_KEY])?$_SESSION[Data::TRANSACTION_KEY]:'';
    }

    /**
    * Get JSON representation of products in cart.
    * @return string JSON string
    */
    public function getProductsJSON() {

        $products = ($this->getLogMode() == Data::MOD_CONVERT)?$_SESSION[Data::CART_KEY_PRODUCTS]:$this->_helper->getProductsInCart();

        if ($this->getLogMode() ==  Data::MOD_CART) {
            //save products for conversion page
            $_SESSION[Data::CART_KEY_PRODUCTS] = $products;
        }
         
        //Add transactionId if available
        if ($transactionId = $this->getTransactionId()) {
            $products = array_map(function ($a) use ($transactionId) {
                $a['transactionId'] = $transactionId;
                return $a;
            }, $products);
        }

        return json_encode($products, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get data for ematix function. 
     * @return string
     */
    public function getEmaticData() {

        $products = $this->getProductsJSON();
        $url = str_replace('/',"'+'/'+'", $this->getUrl('ematicjs/cart'));
        $cartSearch = json_encode($this->_helper->getCartMatch(), JSON_UNESCAPED_SLASHES);
        $checkoutSearch = json_encode($this->_helper->getCheckoutMatch(), JSON_UNESCAPED_SLASHES);

        return "{'url': '$url', 'products': $products, 'cartSearch': $cartSearch, 'checkoutSearch':$checkoutSearch}";
    }

    /**
     * Get ematics function calls if any.
     * @return string
     */
    public function getEmaticsCall() {
        $output = '';

        //Product cart log
        if (Data::cartIsUpdated() || Data::getLogMode() != Data::MOD_CART) {

            $mode = Data::getLogMode();
            Data::setCartUpdated(false);
            
            //reset log mode
            $_SESSION[Data::LOG_MODE] = Data::MOD_CART;

            $output = "ematics('log', 'product', '$mode', ematicData.products);";
        }

        //Product browse log
        if ($product = $this->_registry->registry('current_product')) {
            if (!isset($_SESSION[Data::PRODUCT_KEY]) || $_SESSION[Data::PRODUCT_KEY] != $product->getId() ) {
                $product_data = json_encode(array($this->_helper->getProduct($product)), JSON_UNESCAPED_SLASHES);
                $output .= "ematics('log', 'product', 'browse', $product_data);";
                $_SESSION[Data::PRODUCT_KEY] = '';
            }            
        }

        return $output;
    }

}
