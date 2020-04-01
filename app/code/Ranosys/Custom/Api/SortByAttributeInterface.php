<?php

namespace Ranosys\Custom\Api;

/**
 * Get all sortable attributes
 */
interface SortByAttributeInterface {

    /**
     * Get sortable attributes
     *
     * @param string $type
     * @return \Ranosys\Custom\Api\Data\SortByAttributedataInterface[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getSortableAttributeList($type = 'catalog');
}
