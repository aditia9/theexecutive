<?php

namespace Ranosys\Catalog\Model;

class CategoryManagement extends \Magento\Catalog\Model\CategoryManagement implements \Ranosys\Catalog\Api\CategoryManagementInterface {
    
    public function __construct(
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Catalog\Model\Category\Tree $categoryTree,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesFactory
    ) {
        parent::__construct($categoryRepository, $categoryTree, $categoriesFactory);
    }
        
}