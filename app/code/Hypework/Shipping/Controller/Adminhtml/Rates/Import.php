<?php

namespace Hypework\Shipping\Controller\Adminhtml\Rates;

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
                    //carrier_name, region_code, city_name, district_name, subdistrict_name, rate
                    /**********************/

                    if(!in_array('carrier_name', $headers) || !in_array('region_code', $headers) || !in_array('city_name', $headers) || !in_array('district_name', $headers) || !in_array('subdistrict_name', $headers) || !in_array('rate', $headers)) {
                        return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid CSV required columns: carrier_name, region_code, city_name, district_name, subdistrict_name, rate'),
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

                        $carrierColletion = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\Carrier\CollectionFactory')->create();
                        $carrierModel = $carrierColletion->addFieldToFilter('name', $row['carrier_name'])
                                                        ->getFirstItem();

                        $regionCollection = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\Region\CollectionFactory')->create();
                        $regionModel = $regionCollection->addFieldToFilter('code', $row['region_code'])
                                                        ->getFirstItem();

                        $cityCollection = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\City\CollectionFactory')->create();
                        $cityModel = $cityCollection->addFieldToFilter('region_id', $regionModel->getRegionId())
                                                    ->addFieldToFilter('name', $row['city_name'])
                                                    ->getFirstItem();

                        //TODO: District
                        $districtId = '';

                        //TODO: Subdistrict
                        $subdistrictId = '';

                        if(!$carrierModel) {
                            return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid Carrier Name: ' . $row['carrier_name']),
                            ]);
                        }

                        if(!$regionModel) {
                            return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid Region Code: ' . $row['region_code']),
                            ]);
                        }

                        if(!$cityModel) {
                            return $result->setData([
                                'status' => 'Error',
                                'message' => __('Invalid City Name: ' . $row['city_name']),
                            ]);
                        }

                        $ratesCollection = $this->_objectManager->get('\Hypework\Shipping\Model\ResourceModel\Rates\CollectionFactory')->create();
                        $rateModel = $ratesCollection->addFieldToFilter('carrier_id', $carrierModel->getEntityId())
                                                    ->addFieldToFilter('region_id', $regionModel->getRegionId())
                                                    ->addFieldToFilter('city_id', $cityModel->getEntityId())
                                                    ->addFieldToFilter('district_id', $districtId)
                                                    ->addFieldToFilter('subdistrict_id', $subdistrictId)
                                                    ->getFirstItem();

                        if (!$rateModel->getEntityId()) { //insert new
                            $rateModel = $this->_objectManager->create('Hypework\Shipping\Model\Rates');
                            $rateModel->setData([
                                'carrier_id' => $carrierModel->getEntityId(),
                                'region_id' => $regionModel->getRegionId(),
                                'city_id' => $cityModel->getEntityId(),
                                'district_id' => $districtId,
                                'subdistrict_id' => $subdistrictId,
                                'rate' => $row['rate'],
                                'created_at' => $now,
                                'updated_at' => $now
                            ]);

                        } else { //update existing
                            $rateModel->setRate($row['rate']);
                            $rateModel->setUpdatedAt($now);
                        }

                        $rateModel->save();

                    }

                    //Delete File in pub/media
                    $this->_file->deleteFile($filePath);

                    return $result->setData([
                        'status' => __('Success'),
                        'message' => __('Import Rates has been completed'),
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