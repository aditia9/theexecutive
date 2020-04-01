<?php

namespace Ranosys\CatalogSearch\Model;

use \Magento\Catalog\Model\Layer\Resolver;
use \Magento\Framework\Exception\InputException;

class Result implements \Ranosys\CatalogSearch\Api\ResultInterface {
    
    protected $resultDataFactory;
    
    protected $layerResolver;
    
    protected $catalogLayer;
    
    protected $productListToolbar;
    
    protected $filterList;
    
    protected $request;
    
    protected $productRepository;
    
    public function __construct(
        \Ranosys\CatalogSearch\Model\Data\ResultDataFactory $resultDataFactory,
        \Magento\Catalog\Block\Product\ProductList\Toolbar $productListToolbar,
        \Magento\Catalog\Model\Layer\FilterList $filterList,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        Resolver $layerResolver
    ) {
        $this->resultDataFactory = $resultDataFactory;
        $this->layerResolver = $layerResolver;
        $this->productListToolbar = $productListToolbar;
        $this->filterList = $filterList;
        $this->request = $request;
        $this->productRepository = $productRepository;
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($q){
        
        if($q == ''){
            throw new InputException(__('No search term provided'));
        }
        
        $this->layerResolver->create(Resolver::CATALOG_LAYER_SEARCH);
        $this->catalogLayer = $this->layerResolver->get();
        
        $category = $this->catalogLayer->getCurrentCategory();
        /* @var $category \Magento\Catalog\Model\Category */
        $availableOrders = $category->getAvailableSortByOptions();
        
        unset($availableOrders['position']);
        $availableOrders['relevance'] = __('Relevance');
        
        $this->productListToolbar->setAvailableOrders($availableOrders)->setDefaultDirection('desc')->setDefaultOrder('relevance');
        
        $filters = $this->filterList->getFilters($this->catalogLayer);
        foreach ($filters as $filter) {
            $filter->apply($this->request);
        }
        $this->catalogLayer->apply();
        
        $collection = $this->catalogLayer->getProductCollection();
        
        $toolbar = $this->productListToolbar->setCollection($collection);
        
        $collection = $toolbar->getCollection();
        
        $collection->load();
        
        $resultDataModel = $this->resultDataFactory->create();
        
        $resultDataModel->setTotalCount($collection->getSize());
        
        $productsArray = [];
        
        foreach($collection->getItems() as $product){
            $loadedProduct = $this->productRepository->get($product->getSku());
            $productsArray[] = $loadedProduct;
        }
        $resultDataModel->setItems($productsArray);

        return $resultDataModel;
    }
    
}