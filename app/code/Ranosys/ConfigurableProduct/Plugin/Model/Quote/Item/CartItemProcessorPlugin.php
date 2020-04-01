<?php

namespace Ranosys\ConfigurableProduct\Plugin\Model\Quote\Item;

use Magento\Quote\Model\Quote\Item\CartItemProcessorInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Catalog\Helper\Product\ConfigurationPool;

class CartItemProcessorPlugin {
    
    /**
     * @var ConfigurationPool
     */
    private $configurationPool;
    
    /**
     * @var \Magento\ConfigurableProduct\Api\Data\ConfigurableItemOptionValueExtensionFactory
     */
    protected $extensionFactory;
    
    public function __construct(
        ConfigurationPool $configurationPool,
        \Magento\ConfigurableProduct\Api\Data\ConfigurableItemOptionValueExtensionFactory $extensionFactory
    ) {
        $this->configurationPool = $configurationPool;
        $this->extensionFactory = $extensionFactory;
    }
    
    public function afterProcessOptions(CartItemProcessorInterface $cartItemProcessorInterface, CartItemInterface $result, CartItemInterface $subject){
        $productOption = $result->getProductOption();
        
        if(!$productOption) {
            return $result;
        }
        
        $extensibleAttribute = $productOption->getExtensionAttributes();
        if(!$extensibleAttribute){
            return $result;
        }
        
        /* @var $helper \Magento\Catalog\Helper\Product\Configuration */
        $helper = $this->configurationPool->getByProductType('default');

        $options = $this->configurationPool->getByProductType($result->getProductType())->getOptions($result);
        
        $configurableItemOptions = $extensibleAttribute->getConfigurableItemOptions();
        foreach($configurableItemOptions as $configurableItemOption){
            $itemOptionValueExtensibleAttribute = $configurableItemOption->getExtensionAttributes();
            if(!$itemOptionValueExtensibleAttribute){
                $itemOptionValueExtensibleAttribute = $this->extensionFactory->create();
            }
            
            $item_attribute_label = '';
            $item_option_label = '';
            
            foreach($options as $option){
                if($configurableItemOption->getOptionId() == $option['option_id'] && ($configurableItemOption->getOptionValue() == $option['option_value'])){
                    $item_attribute_label = $option['label'];
                    $item_option_label = $option['value'];
                    break;
                }
                
            }
            
            $itemOptionValueExtensibleAttribute->setAttributeLabel($item_attribute_label);
            $itemOptionValueExtensibleAttribute->setOptionLabel($item_option_label);
            
            $configurableItemOption->setExtensionAttributes($itemOptionValueExtensibleAttribute);
        }
        
        $extensibleAttribute->setConfigurableItemOptions($configurableItemOptions);
        $productOption->setExtensionAttributes($extensibleAttribute);
        $result->setProductOption($productOption);
        
        return $result;
    }
    
}

