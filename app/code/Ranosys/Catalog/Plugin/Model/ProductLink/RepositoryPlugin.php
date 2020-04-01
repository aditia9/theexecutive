<?php

namespace Ranosys\Catalog\Plugin\Model\ProductLink;

use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class RepositoryPlugin {
    
    protected $productLinkExtensionFactory;
    
    protected $productRepository;
    
    public function __construct(
        \Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->productLinkExtensionFactory = $productLinkExtensionFactory;
        $this->productRepository = $productRepository;
    }
    
    public function afterGetList(\Magento\Catalog\Api\ProductLinkRepositoryInterface $productLink,
        $result, \Magento\Catalog\Api\Data\ProductInterface $product
        ){
        
        foreach($result as $link){
            $loadedProduct = $this->productRepository->get($link->getLinkedProductSku());
            $productExtension = $loadedProduct->getExtensionAttributes();
            $productLinkExtension = $link->getExtensionAttributes();
            if ($productLinkExtension === null) {
                $productLinkExtension = $this->productLinkExtensionFactory->create();
            }
            
            $productLinkExtension->setLinkedProductName($loadedProduct->getName());
            $productLinkExtension->setLinkedProductImage($loadedProduct->getImage());
            if($loadedProduct->getTypeId() == Configurable::TYPE_CODE && $productExtension){
                if($productExtension->getRegularPrice()){
                    $productLinkExtension->setLinkedProductRegularprice($productExtension->getRegularPrice());
                }
                if($productExtension->getFinalPrice()) {
                    $productLinkExtension->setLinkedProductFinalprice($productExtension->getFinalPrice());
                }
            } else {
                $productLinkExtension->setLinkedProductRegularprice($loadedProduct->getPriceInfo()->getPrice('regular_price')->getValue());
                $productLinkExtension->setLinkedProductFinalprice($loadedProduct->getPriceInfo()->getPrice('final_price')->getValue());
            }
            
            $link->setExtensionAttributes($productLinkExtension);
        }
        
        return $result;
    }
    
}