<?php

namespace Hypework\Shipping\Model\ResourceModel\Rates\Grid;

class Collection extends \Hypework\Shipping\Model\ResourceModel\Rates\Collection implements \Magento\Framework\Api\Search\SearchResultInterface
{
    /**
     * Aggregations
     *
     * @var \Magento\Framework\Search\AggregationInterface
     */
    protected $_aggregations;
    /**
     * constructor
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param $mainTable
     * @param $eventPrefix
     * @param $eventObject
     * @param $resourceModel
     * @param $model
     * @param $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable = 'hypework_shipping_rates',
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        \Magento\Framework\DB\Adapter\AdapterInterface  $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }    

    protected function _initSelect() {
        parent::_initSelect();
        $this->getSelect()->joinLeft(
                ['region_table' => $this->getTable('directory_country_region')],
                'main_table.region_id = region_table.region_id',
                ['region_name' => 'default_name', 'country_id' => 'country_id']
            );
            $this->getSelect()->joinLeft(
                ['city_table' => $this->getTable('hypework_shipping_city')],
                'main_table.city_id = city_table.entity_id',
                ['city_id' => 'city_table.entity_id', 'city_name' => 'city_table.name']
            );
            $this->getSelect()->joinLeft(
                ['carrier_table' => $this->getTable('hypework_shipping_carrier')],
                'main_table.carrier_id = carrier_table.entity_id',
                ['carrier_id' => 'carrier_table.entity_id', 'carrier_name' => 'carrier_table.name']
            );

        $this->addFilterToMap('entity_id', 'main_table.entity_id');
        $this->addFilterToMap('created_at', 'main_table.created_at');
        $this->addFilterToMap('updated_at', 'main_table.updated_at');
        $this->addFilterToMap('region_name', 'region_table.default_name');
        $this->addFilterToMap('city_id', 'city_table.entity_id');
        $this->addFilterToMap('city_name', 'city_table.name');
        $this->addFilterToMap('carrier_name', 'carrier_table.name');
        $this->addFilterToMap('carrier_id', 'carrier_table.entity_id');

        return $this;
    }

    /**
     * @return \Magento\Framework\Search\AggregationInterface
     */
    public function getAggregations()
    {
        return $this->_aggregations;
    }
    /**
     * @param \Magento\Framework\Search\AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
    }
    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }
    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }
    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }
    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
    
    /**
     * Join faq_store relation table and faq_category relation table
     *
     * @inheritdoc
     */
    protected function _renderFiltersBefore()
    {
        // $this->getSelect()->joinLeft(
        //     ['regionTable' => $this->getTable('directory_country_region')],
        //     'main_table.region_id = regionTable.region_id',
        //     ['region' => 'default_name']
        // );
        // $this->getSelect()->joinLeft(
        //     ['cityTable' => $this->getTable('hypework_shipping_city')],
        //     'main_table.city_id = cityTable.entity_id',
        //     ['city' => 'name']
        // );
        // $this->getSelect()->joinLeft(
        //     ['carrierTable' => $this->getTable('hypework_shipping_carrier')],
        //     'main_table.carrier_id = carrierTable.entity_id',
        //     ['carrier' => 'name']
        // );
        
        parent::_renderFiltersBefore();
    }
}