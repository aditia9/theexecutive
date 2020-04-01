<?php

namespace Ranosys\Quote\Plugin\Model\Cart;

class TotalsPlugin {
    
    public function __construct(
        \Magento\Quote\Model\Quote\Item $cartItem,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->cartItem = $cartItem;
        $this->productRepository = $productRepository;
    }
    
    public function afterGet(\Magento\Quote\Model\Cart\CartTotalRepository $totalSegment, $results){       
        $total = $results->getTotalSegments();          
    
        $totals = array();
        foreach ($total as $result){
            
           $segmentArray = $result->getData();
           if(!($segmentArray['code'] == 'tax' && $segmentArray['value'] == 0))
           { 
                $segmentArray['value'] = (float)$segmentArray['value'];
                 $totals[] = $segmentArray;
           }
        }
           
        $results->setTotalSegments($totals);
        
        return $results;
    }
    
}

