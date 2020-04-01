<?php

namespace Ranosys\Catalog\Api;

interface CategoryManagementInterface extends \Magento\Catalog\Api\CategoryManagementInterface {
    
    /**
     * Retrieve list of categories
     *
     * @param int $rootCategoryId
     * @param int $depth
     * @throws \Magento\Framework\Exception\NoSuchEntityException If ID is not found
     * @return \Ranosys\Catalog\Api\Data\CategoryTreeInterface containing Tree objects
     */
    public function getTree($rootCategoryId = null, $depth = null);
}