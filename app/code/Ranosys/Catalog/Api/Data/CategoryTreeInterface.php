<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ranosys\Catalog\Api\Data;

/**
 * @api
 * @since 100.0.2
 */
interface CategoryTreeInterface extends \Magento\Catalog\Api\Data\CategoryTreeInterface
{
    /**
     * Get category image
     * 
     * @return string
     */
    public function getImage();
    
    /**
     * Set category image
     * @param string $image
     * @return $this
     */
    public function setImage($image);
    
    
    /**
     * @return \Ranosys\Catalog\Api\Data\CategoryTreeInterface[]
     */
    public function getChildrenData();

    /**
     * @param \Ranosys\Catalog\Api\Data\CategoryTreeInterface[] $childrenData
     * @return $this
     */
    public function setChildrenData(array $childrenData = null);
    
}
