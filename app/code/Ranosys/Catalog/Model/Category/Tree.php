<?php

namespace Ranosys\Catalog\Model\Category;

class Tree extends \Magento\Catalog\Model\Category\Tree{
    
    protected $treeFactoryCustom;
    
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\Tree $categoryTree,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Category\Collection $categoryCollection,
        \Magento\Catalog\Api\Data\CategoryTreeInterfaceFactory $treeFactory,
        \Ranosys\Catalog\Api\Data\CategoryTreeInterfaceFactory $treeFactoryCustom
    ) {
        parent::__construct($categoryTree, $storeManager, $categoryCollection, $treeFactory);
        $this->treeFactoryCustom = $treeFactoryCustom;
    }
    
    /**
     * @return void
     */
    protected function prepareCollection()
    {
        $storeId = $this->storeManager->getStore()->getId();
        $this->categoryCollection->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'is_active'
        )->addAttributeToSelect(
            'image'
        )->addAttributeToSelect(
            'include_in_menu'
        )->setProductStoreId(
            $storeId
        )->setLoadProductCount(
            true
        )->setStoreId(
            $storeId
        );
    }
    
    /**
     * @param \Magento\Framework\Data\Tree\Node $node
     * @param int $depth
     * @param int $currentLevel
     * @return \Ranosys\Catalog\Api\Data\CategoryTreeInterface
     */
    public function getTree($node, $depth = null, $currentLevel = 0)
    {
        /** @var \Magento\Catalog\Api\Data\CategoryTreeInterface[] $children */
        $children = $this->getChildren($node, $depth, $currentLevel);
        /** @var \Magento\Catalog\Api\Data\CategoryTreeInterface $tree */
              
        $image = $node->getData('image');
        if(!$image){
            $image = '';
        }
        
        $tree = $this->treeFactoryCustom->create();
        $tree->setId($node->getId())
            ->setParentId($node->getParentId())
            ->setName($node->getName())
            ->setPosition($node->getPosition())
            ->setLevel($node->getLevel())
            ->setIsActive($node->getIsActive())
            ->setProductCount($node->getProductCount())
            ->setImage($image)
            ->setChildrenData($children);
        return $tree;
    }
    
    /**
     * @param \Magento\Framework\Data\Tree\Node $node
     * @param int $depth
     * @param int $currentLevel
     * @return \Ranosys\Catalog\Api\Data\CategoryTreeInterface[]|[]
     */
    protected function getChildren($node, $depth, $currentLevel)
    {
        if ($node->hasChildren()) {
            $children = [];
            foreach ($node->getChildren() as $child) {               
                if($child->getIncludeInMenu() != 1) {
                    continue;
                }               
                if ($depth !== null && $depth <= $currentLevel) {
                    break;
                }
                $children[] = $this->getTree($child, $depth, $currentLevel + 1);
            }
            return $children;
        }
        return [];
    }
    
}