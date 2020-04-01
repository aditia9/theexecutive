<?php

namespace Hypework\Shipping\Controller\Adminhtml\City;

class Import extends \Magento\Backend\App\Action 
{
    protected $_resultJsonFactory;
    protected $_directoryList;
    protected $_csvProcessor;
    protected $_file;
    protected $_scopeConfig;

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_directoryList = $directoryList;
        $this->_csvProcessor = $csvProcessor;
        $this->_file = $file;
        parent::__construct($context);
    }

	public function execute()
	{
        if ($this->getRequest()->isAjax())
        {
            try
            {
                $result = $this->_resultJsonFactory->create();
                $params = $this->getRequest()->getParams();

                $mediaDir = $this->_directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $filePath = $mediaDir.'/upload/'.$params['file_path'];

                if($this->_file->isExists($filePath)) {

                    $importData = $this->_csvProcessor->getData($filePath);
                    $headers = array_shift($importData);

                    /*file format city.csv*/
                    //region_code, name
                    /**********************/

                    if(!in_array('region_code', $headers) || !in_array('name', $headers)) {
                        return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid CSV required columns: region_code, name'),
                            ]);
                    }

                    $arrayData = [];
                    foreach($importData as $row) {
                        $tempArray = [];
                        foreach($row as $idx => $r) {
                            $tempArray[$headers[$idx]] = $r;
                        }
                        $arrayData[] = $tempArray;
                    }

                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object objectManager
                    $magentoDateObject = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');

                    foreach($arrayData as $idx => $row) {                        
                        $now = $magentoDateObject->gmtDate();                        

                        $regionCollection = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\Region\CollectionFactory')->create();
                        $regionModel = $regionCollection->addFieldToFilter('code', $row['region_code'])
                                                        ->getFirstItem();

                        $cityCollection = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\City\CollectionFactory')->create();
                        $cityModel = $cityCollection->addFieldToFilter('region_id', $regionModel->getRegionId())
                                                    ->addFieldToFilter('name', $row['name'])
                                                    ->getFirstItem();

                        if(!$regionModel) {
                            return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid Region Code: ' . $row['region_code']),
                            ]);
                        }

                        if (!$cityModel->getEntityId()) { //insert new
                            $cityModel = $this->_objectManager->create('Hypework\Shipping\Model\City');
                            $cityModel->setData([
                                'region_id' => $regionModel->getRegionId(),
                                'name' => $row['name'],
                                'created_at' => $now,
                                'updated_at' => $now
                            ]);

                        } else { //update existing
                            $cityModel->setRegionId($regionModel->getRegionId());
                            $cityModel->setName($row['name']);
                            $cityModel->setUpdatedAt($now);
                        }

                        $cityModel->save();

                    }

                    //Delete File in pub/media
                    $this->_file->deleteFile($filePath);

                    return $result->setData([
                        'status' => __('Success'),
                        'message' => __('Import City has been completed'),
                    ]);
                
                } else {

                    return $result->setData([
                        'status' => __('Error'),
                        'message' => __('File does not exist'),
                    ]);

                }
            }
            catch (Exception $ex)
            {
                return $result->setData([
                    'status' => __('Error'),
                    'message' => $ex->getMessage(),
                ]);
            }
        }
	}

}