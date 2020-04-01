<?php
namespace Ematicsolutions\Ematicjs\Controller\Cart;

use \Ematicsolutions\Ematicjs\Helper\Data;

/**
 * Simple controller for retrieving cart products via ajax
 */
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Data $helper
    ) {
        
        $this->_helper = $helper;
        
        parent::__construct(
            $context
        );
    }

    /**
     * Default action
     */
    public function execute()
    {
       Data::setCartUpdated(false);
       header('Content-Type: application/json');
       echo json_encode($this->_helper->getProductsInCart(), JSON_UNESCAPED_SLASHES);
    }

}