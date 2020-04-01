<?php

namespace Ranosys\Catalog\Api;

interface ProductListInterface{
    /**
     * Get product list
     *
     * @param string $id
     * @param int $pagesize
     * @param int $curpage
     * @param string $order
     * @param string $dir
     * @return \Ranosys\Catalog\Api\Data\ProductDataInterface
     */
    public function getList($id);
}