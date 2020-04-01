<?php

namespace Ranosys\Catalog\Model;

class ProductList implements \Ranosys\Catalog\Api\ProductListInterface {
    
    protected $productDataFactory;
    
    protected $registry;
    
    protected $request;
    
    protected $filterList;
    
    protected $layerResolver;
    
    protected $categoryRepository;
    
    protected $catalogLayer;
    
    protected $storeManager;
    
    protected $productRepository;
    
    protected $productListToolbar;
    
    public function __construct(
        \Ranosys\Catalog\Model\Data\ProductDataFactory $productDataFactory,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\Layer\FilterList $filterList,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Block\Product\ProductList\Toolbar $productListToolbar,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver
    ) {
        $this->productDataFactory = $productDataFactory;
        $this->registry = $registry;
        $this->request = $request;
        $this->filterList = $filterList;
        $this->layerResolver = $layerResolver;
        $this->categoryRepository = $categoryRepository;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->productListToolbar = $productListToolbar;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getList($id, $product_list_limit = null, $p = 1, $product_list_order = null, $product_list_dir = 'asc')
    {       
        $category = $this->categoryRepository->get($id, $this->storeManager->getStore()->getId());
        $this->registry->register('current_category', $category);
        
        $this->catalogLayer = $this->layerResolver->get();
        
        $filters = $this->filterList->getFilters($this->catalogLayer);
        foreach ($filters as $filter) {
            $filter->apply($this->request);
        }
        $this->catalogLayer->apply();

        $collection = $this->catalogLayer->getProductCollection();
        
        $toolbar = $this->productListToolbar->setCollection($collection);
        
        $collection = $toolbar->getCollection();        
                   
        $collection->load();
                
        $productDataModel = $this->productDataFactory->create();
        
        $productDataModel->setTotalCount($collection->getSize());
        
        $productsArray = [];
        
        //temporary workaround to load full product, as getlist method does not extension attributes in api
        //created a plugin after get function to set regular and final price in extension attributes
        foreach($collection->getItems() as $product){
            $loadedProduct = $this->productRepository->get($product->getSku());
            $productsArray[] = $loadedProduct;
        }
        $productDataModel->setItems($productsArray);

        return $productDataModel;
    }
}