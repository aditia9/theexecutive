<?php

namespace Ranosys\LayeredNavigation\Model;

use Ranosys\LayeredNavigation\Api\SearchFiltersInterface;
use \Magento\Framework\Exception\InputException;

class SearchFilters implements SearchFiltersInterface{
    
    protected $registry;
    
    protected $filtersDataFactory;
    
    protected $filterInformationFactory;
    
    protected $filterOptionsFactory;
    
    protected $storeManager;
    
    protected $request;
    
    protected $filterList;
    
    protected $layerResolver;
    
    protected $catalogLayer;
    
    protected $categoryRepository;
    
    protected $currencyFactory;
    
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Ranosys\LayeredNavigation\Model\Data\FiltersDataFactory $filtersDataFactory,
        \Ranosys\LayeredNavigation\Model\Data\FilterInformationFactory $filterInformationFactory,
        \Ranosys\LayeredNavigation\Model\Data\FilterOptionsFactory $filterOptionsFactory,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Catalog\Model\Layer\FilterList $filterList,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->filtersDataFactory = $filtersDataFactory;
        $this->filterInformationFactory = $filterInformationFactory;
        $this->filterOptionsFactory = $filterOptionsFactory;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->filterList = $filterList;
        $this->layerResolver = $layerResolver;
        $this->currencyFactory = $currencyFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($q){
        
        if($q == ''){
            throw new InputException(__('No search term provided'));
        }
        
        $this->layerResolver->create(\Magento\Catalog\Model\Layer\Resolver::CATALOG_LAYER_SEARCH);
        
        $this->catalogLayer = $this->layerResolver->get();
        
        $filterData = $this->getFilters();
        
        $activeFiltersData = $this->getActiveFilters();
        
        $filtersDataModel = $this->filtersDataFactory->create();
        
        $filtersDataModel->setTotalCount($this->getLayer()->getProductCollection()->getSize());
        
        $filtersDataModel->setFilters($filterData);
        
        $filtersDataModel->setActiveFilters($activeFiltersData);
        
        return $filtersDataModel;
    }
    
    protected function getFilters(){
        $filters = $this->filterList->getFilters($this->catalogLayer);
        foreach ($filters as $filter) {
            $filter->apply($this->request);
        }
        $this->getLayer()->apply();
        
        $filterData = array();
        foreach($filters as $filter){
            if(!$filter->getItemsCount()){
                continue;
            }
            
            $requestVar = $filter->getRequestVar();
            
            $filterInformationModel = $this->filterInformationFactory->create();
            $filterInformationModel->setName($filter->getName());
            $filterInformationModel->setCode($requestVar);
            
            $filterItems = $filter->getItems();
            
            $options = array();
            if($requestVar == 'price'){
                $maxPrice = $this->getLayer()->getProductCollection()->getMaxPrice();
                $minPrice = $this->getLayer()->getProductCollection()->getMinPrice();

                if($minPrice == '' && $maxPrice == ''){
                    $value = '';
                } else {
                    $value = $minPrice . '-' . $maxPrice;
                }
                
                $filterOptionsModel = $this->filterOptionsFactory->create();
                $filterOptionsModel->setLabel($this->getCurrencySymbol());
                $filterOptionsModel->setValue($value);
                $filterOptionsModel->setCode($requestVar);
                
                $options[] = $filterOptionsModel;
            } else {
                if($filterItems) {
                    foreach($filterItems as $filterItem){
                        $filterOptionsModel = $this->filterOptionsFactory->create();
                        $filterOptionsModel->setLabel($filterItem->getLabel());
                        $filterOptionsModel->setValue($filterItem->getValue());
                        $filterOptionsModel->setCode($requestVar);
                        $options[] = $filterOptionsModel;
                    }
                }
            }
            
            $filterInformationModel->setOptions($options);
            $filterData[] = $filterInformationModel;
        }
        
        return $filterData;
    }
    
    protected function getActiveFilters(){
        $filterData = array();
        $activeFilters = $this->getLayer()->getState()->getFilters();
        
        if(empty($activeFilters)){
            return $filterData;
        }
        
        foreach($activeFilters as $activeFilter){
            $filter = $activeFilter->getFilter();
            $requestVar = $filter->getRequestVar();
            
            $filterOptionsModel = $this->filterOptionsFactory->create();
            
            if($requestVar == 'price'){               
                $filterOptionsModel->setLabel($this->getCurrencySymbol());
                $filterOptionsModel->setValue((string)implode('-', $activeFilter->getValue()));
                $filterOptionsModel->setCode($requestVar);
            } else {
                $filterOptionsModel->setLabel($activeFilter->getLabel());
                $filterOptionsModel->setValue($activeFilter->getValue());
                $filterOptionsModel->setCode($requestVar);
            }
            
            $filterData[] = $filterOptionsModel;
        }
        return $filterData;
    }
    
    
    protected function getCurrencySymbol(){
        $currencyCode = $this->storeManager->getStore()->getCurrentCurrencyCode();
        $currency = $this->currencyFactory->create()->load($currencyCode);
        return $currency->getCurrencySymbol();
    }
    
    protected function getLayer(){
        return $this->catalogLayer;
    }
    
}