<?php

namespace Ranosys\Catalog\Helper;

class Catalog extends \Magento\Framework\App\Helper\AbstractHelper {
    
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        parent::__construct($context);
        $this->productCollectionFactory = $productCollectionFactory;
    }
    
    public function getProductMaxPrice($product){
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addStoreFilter();
        $productCollection->addPriceData();
        $productCollection->addIdFilter($product->getId());

        $collectionItem = $productCollection->load()->getFirstItem();
        
        $regularPrice = $collectionItem->getMaxPrice();
        
        return $regularPrice;
    }
    
}