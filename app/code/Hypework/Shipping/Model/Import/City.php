<?php
namespace Hypework\Shipping\Model\Import;
use Hypework\Shipping\Model\Import\City\RowValidatorInterface as ValidatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;

class City extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    /**#@+
     * Permanent column names
     */
    const COLUMN_REGION_CODE = 'region_code';
    const COLUMN_NAME = 'name';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_UPDATED_AT = 'updated_at';

    const TABLE_Entity = 'hypework_shipping_city';
    
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = [
        ValidatorInterface::ERROR_REGION_CODE_IS_EMPTY => 'REGION_CODE is empty',
        ValidatorInterface::ERROR_NAME_IS_EMPTY => 'NAME is empty',
    ];
    protected $_permanentAttributes = [self::COLUMN_REGION_CODE, self::COLUMN_NAME,];
    
    /**
     * If we should check column names
     *
     * @var bool
     */
    protected $needColumnCheck = true;
    // protected $groupFactory;
    
    /**
     * Valid column names
     *
     * @array
     */
    protected $validColumnNames = [
        self::COLUMN_REGION_CODE,
        self::COLUMN_NAME,
        self::COLUMN_CREATED_AT,
        self::COLUMN_UPDATED_AT,
    ];

    /**
     * Need to log in import history
     *
     * @var bool
     */
    protected $logInHistory = true;
    protected $_validators = [];

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_connection;
    protected $_resource;

    /**
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        ProcessingErrorAggregatorInterface $errorAggregator
        // \Magento\Customer\Model\GroupFactory $groupFactory
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->_importExportData = $importExportData;
        $this->_resourceHelper = $resourceHelper;
        $this->_dataSourceModel = $importData;
        $this->_resource = $resource;
        $this->_connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $this->errorAggregator = $errorAggregator;
        // $this->groupFactory = $groupFactory;
    }

    public function getValidColumnNames()
    {
        return $this->validColumnNames;
    }

    /**
     * Entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'city';
    }
    
    /**
     * Row validation.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    public function validateRow(array $rowData, $rowNum)
    {
        $errorFlag = false;
        if (isset($this->_validatedRows[$rowNum])) {
            return !$this->getErrorAggregator()->isRowInvalid($rowNum);
        }

        $this->_validatedRows[$rowNum] = true;
        if (!isset($rowData[self::COLUMN_REGION_CODE]) || empty($rowData[self::COLUMN_REGION_CODE])) {
            $this->addRowError(ValidatorInterface::ERROR_REGION_CODE_IS_EMPTY, $rowNum);
            $errorFlag = true;
        }
        if (!isset($rowData[self::COLUMN_NAME]) || empty($rowData[self::COLUMN_NAME])) {
            $this->addRowError(ValidatorInterface::ERROR_NAME_IS_EMPTY, $rowNum);
            $errorFlag = true;
        }

        if(!$errorFlag) return false;

        return !$this->getErrorAggregator()->isRowInvalid($rowNum);
    }

    /**
     * Create Advanced price data from raw data.
     *
     * @throws \Exception
     * @return bool Result of operation.
     */
    protected function _importData()
    {
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            $this->deleteEntity();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $this->getBehavior()) {
            $this->replaceEntity();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $this->getBehavior()) {
            $this->saveEntity();
        }
        return true;
    }

    /**
     * Save newsletter subscriber
     *
     * @return $this
     */
    public function saveEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }

    /**
     * Replace newsletter subscriber
     *
     * @return $this
     */
    public function replaceEntity()
    {
        $this->saveAndReplaceEntity();
        return $this;
    }

    /**
     * Deletes newsletter subscriber data from raw data.
     *
     * @return $this
     */
    public function deleteEntity()
    {
        $listData = [];
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                $this->validateRow($rowData, $rowNum);
                if (!$this->getErrorAggregator()->isRowInvalid($rowNum)) {
                    $listData[] = array(
                                    self::COLUMN_REGION_CODE => $rowData[self::COLUMN_REGION_CODE],
                                    self::COLUMN_NAME => $rowData[self::COLUMN_NAME],
                                );
                }
                if ($this->getErrorAggregator()->hasToBeTerminated()) {
                    $this->getErrorAggregator()->addRowToSkip($rowNum);
                }
            }
        }
        if ($listData) {
            $this->deleteEntityFinish(array_unique($listData),self::TABLE_Entity);
        }
        return $this;
    }

    /**
     * Save and replace newsletter subscriber
     *
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function saveAndReplaceEntity()
    {
        $behavior = $this->getBehavior();
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $entityList = [];
            foreach ($bunch as $rowNum => $rowData) {
                if (!$this->validateRow($rowData, $rowNum)) {
                    continue;
                }
                if ($this->getErrorAggregator()->hasToBeTerminated()) {
                    $this->getErrorAggregator()->addRowToSkip($rowNum);
                    continue;
                }

                $entityList[] = [
                    self::COLUMN_REGION_CODE => $rowData[self::COLUMN_REGION_CODE],
                    self::COLUMN_NAME => $rowData[self::COLUMN_NAME],
                ];
            }
            if (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $behavior) {
                if ($listData) {
                    if ($this->deleteEntityFinish(array_unique($entityList), self::TABLE_Entity)) {
                        $this->saveEntityFinish($entityList, self::TABLE_Entity);
                    }
                }
            } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $behavior) {
                $this->saveEntityFinish($entityList, self::TABLE_Entity);
            }
        }
        return $this;
    }

    /**
     * Save product prices.
     *
     * @param array $priceData
     * @param string $table
     * @return $this
     */
    protected function saveEntityFinish(array $entityData, $table)
    {
        if ($entityData) {
            $tableName = $this->_connection->getTableName($table);
            $entityIn = [];
            foreach ($entityData as $id => $entityRows) {
                    foreach ($entityRows as $row) {
                        $entityIn[] = $row;
                    }
            }
            if ($entityIn) {
                $this->_connection->insertOnDuplicate($tableName, $entityIn,[
                    self::COLUMN_REGION_CODE,
                    self::COLUMN_NAME,
                ]);
            }
        }
        return $this;
    }

    protected function deleteEntityFinish(array $listData, $table)
    {
        if ($table && $listData) {
                try {
                    $this->countItemsDeleted += $this->_connection->delete(
                        $this->_connection->getTableName($table),
                        $this->_connection->quoteInto("region_id = '?'' AND name = '?'", $listData[self::COLUMN_REGION_CODE], $listData[self::COLUMN_NAME])
                    );
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
        } else {
            return false;
        }
    }

}