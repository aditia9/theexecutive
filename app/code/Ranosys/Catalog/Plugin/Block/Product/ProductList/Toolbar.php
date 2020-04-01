<?php

namespace Ranosys\Catalog\Plugin\Block\Product\ProductList;

use Magento\Catalog\Model\Product\ProductList\Toolbar as ToolbarModel;

class Toolbar {
    
    protected $request;
    
    public function __construct(
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->request = $request;
    }
    
    public function afterGetAvailableLimit(\Magento\Catalog\Block\Product\ProductList\Toolbar $toolbar, $limits) {
        $pageLimit = $this->request->getParam(ToolbarModel::LIMIT_PARAM_NAME);
        
        if($pageLimit && !isset($limits[$pageLimit])){
            $limits[$pageLimit] = (string)$pageLimit;
        }
        
        return $limits;
    }
    
}