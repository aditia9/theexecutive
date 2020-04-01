<?php

namespace Ranosys\Catalog\Plugin;

use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class ProductRepositoryPlugin {
    
    /**
     * @var \Ranosys\Catalog\Helper\Catalog
     */
    protected $catalogHelper;
    
    protected $productCollectionFactory;
    
    public function __construct(
        \Ranosys\Catalog\Helper\Catalog $catalogHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->catalogHelper = $catalogHelper;
    }
    
    public function afterGet(\Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface, \Magento\Catalog\Model\Product $product, $result){
        
        $extensionAttributes = $product->getExtensionAttributes();
        
        if($product->getTag()){
            $extensionAttributes->setTagText($product->getAttributeText('tag'));
        }
        
        if($product->getTypeId() != Configurable::TYPE_CODE){
            $regularPrice = $product->getPriceInfo()->getPrice('regular_price')->getAmount()->getValue();            
        } else {
            $regularPrice = $this->catalogHelper->getProductMaxPrice($product);
        }
        
        //load product collection by id for specific product as we need to get max price for the configurable product 
        //to be in synch with frontend listing logic            
        //$regularPrice = $this->catalogHelper->getProductMaxPrice($product);
        
        $finalPrice = $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
        $extensionAttributes->setRegularPrice($regularPrice);
        $extensionAttributes->setFinalPrice($finalPrice);
        
        return $product;
    }
    
}