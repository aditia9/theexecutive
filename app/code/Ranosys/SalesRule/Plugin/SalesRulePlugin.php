<?php

namespace Ranosys\SalesRule\Plugin;

class SalesRulePlugin
{
    
     public function __construct(
             \Ranosys\SalesRule\Model\SalesRuleFactory $salesruleFactory
            ) {
         $this->_salesruleFactory = $salesruleFactory;
    }
    
    public function afterSave(\Magento\SalesRule\Model\Rule $subject, $results)
    {
        
       $ruleId = $results->getId();
       $RuleAreaId = $results->getAreaCode();
        
       $model = $this->_salesruleFactory->create();
       $modelUpdate = $model->getCollection()->addFieldToFilter('rule_id',$ruleId);
       if(!empty($modelUpdate->getData())){
           foreach($modelUpdate as $item){
           $item->setData('area_code',$RuleAreaId)->save();
           }
       }
       else{
          
       $model->addData(array(
                   'rule_id' => $ruleId,
                   'area_code' => $RuleAreaId
               ));
       $model->save();
       } 
       return $results;
    }

}