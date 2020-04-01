<?php
 
namespace Ranosys\SalesRule\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Index  extends \Magento\Framework\App\Action\Action
{
     
    public function __construct(Context $context,
        \Ranosys\SalesRule\Model\SalesRuleFactory $salesruleFactory
            ){
        $this->_salesruleFactory = $salesruleFactory;
    parent::__construct($context);
    }

    public function execute()
        
    {   
        $salesruleData = $this->_salesruleFactory->create()->getCollection()->getData();
        echo"<pre>";        print_r($salesruleData);die;
        
        
    }
}