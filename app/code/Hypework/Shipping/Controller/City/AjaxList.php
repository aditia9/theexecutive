<?php

namespace Hypework\Shipping\Controller\City;

class AjaxList extends \Magento\Framework\App\Action\Action
{
    protected $_cityList;
    protected $_resultJsonFactory;

        public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Hypework\Shipping\Model\Config\Source\Adminhtml\CityList $cityList
    ) {
        $this->_cityList = $cityList;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute() {
        if ($this->getRequest()->isAjax()) {
            $result = $this->_resultJsonFactory->create();
            $params = $this->getRequest()->getParams();
            $dataArray = [];
            if ($params['region_id']) {
                $dataArray = $this->_cityList->toOptionArray($params['region_id']);
            } else {
                $dataArray = $this->_cityList->toOptionArray();
            }
            $objManager = \Magento\Framework\App\ObjectManager::getInstance();
            $response = [];
            
            $response['htmlcontent'][] = "<option value=''>" . __('Please select a city.') . "</option>";

            foreach ($dataArray as $arr) {

                if ($params['region_id']) {
                    $checkRates = $objManager->get('Hypework\Shipping\Model\ResourceModel\Rates\CollectionFactory')->create()
                            ->addFieldToFilter('region_id', $params['region_id'])
                            ->addFieldToFilter('city_id', $arr['value'])
                            ->getFirstItem();
                    if (empty($checkRates)) {
                        continue;
                    }
                }

                $response['htmlcontent'][] = "<option value='" . $arr['label'] . "'>" . $arr['label'] . "</option>";
            }

            return $result->setData($response);
        }
    }
}   