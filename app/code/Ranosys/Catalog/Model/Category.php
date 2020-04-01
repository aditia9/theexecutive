<?php

namespace Ranosys\Catalog\Model;

class Category extends \Magento\Catalog\Model\Category implements \Ranosys\Catalog\Api\Data\CategoryTreeInterface {
    
    const KEY_IMAGE = 'image';
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\CategoryAttributeRepositoryInterface $metadataService,
        \Magento\Catalog\Model\ResourceModel\Category\Tree $categoryTreeResource,
        \Magento\Catalog\Model\ResourceModel\Category\TreeFactory $categoryTreeFactory,
        \Magento\Store\Model\ResourceModel\Store\CollectionFactory $storeCollectionFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Config $catalogConfig,
        \Magento\Framework\Filter\FilterManager $filter,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $flatState,
        \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $categoryUrlPathGenerator,
        \Magento\UrlRewrite\Model\UrlFinderInterface $urlFinder,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = array()
    ) {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $storeManager, $metadataService, $categoryTreeResource, $categoryTreeFactory, $storeCollectionFactory, $url, $productCollectionFactory, $catalogConfig, $filter, $flatState, $categoryUrlPathGenerator, $urlFinder, $indexerRegistry, $categoryRepository, $resource, $resourceCollection, $data);
    }
    
    /**
     * Get category image
     * 
     * @return string
     */
    public function getImage(){
        return $this->_getData(self::KEY_IMAGE);
    }
    
    /**
     * Set category image
     * @param string $image
     * @return $this
     */
    public function setImage($image) {
        return $this->setData(self::KEY_IMAGE, $image);
    }
    
    /**
     * @return \Ranosys\Catalog\Api\Data\CategoryTreeInterface[]|null
     */
    public function getChildrenData()
    {
        return $this->getData(self::KEY_CHILDREN_DATA);
    }
    
    /**
     * @param \Ranosys\Catalog\Api\Data\CategoryTreeInterface[] $childrenData
     * @return $this
     */
    public function setChildrenData(array $childrenData = null)
    {
        return $this->setData(self::KEY_CHILDREN_DATA, $childrenData);
    }
    
}