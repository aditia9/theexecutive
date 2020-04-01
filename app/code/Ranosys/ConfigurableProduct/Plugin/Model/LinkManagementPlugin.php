<?php

namespace Ranosys\ConfigurableProduct\Plugin\Model;

class LinkManagementPlugin {
    
    protected $productRepository;
    
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }
    
    public function afterGetChildren(\Magento\ConfigurableProduct\Api\LinkManagementInterface $linkManagementInterface, $result){
        $childrenList = [];
        
        foreach($result as $child){
            $product = $this->productRepository->get($child->getSku());
            $childrenList[] = $product;
        }
        
        return $childrenList;
    }
    
}