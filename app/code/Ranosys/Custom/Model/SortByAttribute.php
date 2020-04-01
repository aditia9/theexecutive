<?php

namespace Ranosys\Custom\Model;

use Ranosys\Custom\Api\SortByAttributeInterface;

/**
 * Implementation class of contract.
 */
class SortByAttribute implements SortByAttributeInterface {

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $storeManager;
    protected $productRepository;
    protected $dataFactory;
    protected $catalogConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Ranosys\Custom\Api\Data\SortByAttributedataInterfaceFactory $dataFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Config $catalogConfig
    ) {
        $this->dataFactory = $dataFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->catalogConfig = $catalogConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortableAttributeList($type = 'catalog') {
        $sortableAttributes = [];

        $availableOrders = $this->catalogConfig->getAttributeUsedForSortByArray();
        
        foreach ($availableOrders as $code => $label) {
            $dataModel = $this->dataFactory->create();
            $dataModel->setAttributeCode($code);
            $dataModel->setAttributeName($label);
            $sortableAttributes[] = $dataModel;
        }
        return $sortableAttributes;
    }

}
