<?php

namespace Hypework\Shipping\Controller\Adminhtml\City;

class AjaxList extends \Magento\Backend\App\Action 
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

	public function execute()
	{
        if ($this->getRequest()->isAjax())
        {
            $result = $this->_resultJsonFactory->create();
            $params = $this->getRequest()->getParams();
            $dataArray = [];
            if($params['region_id']) {
                $dataArray = $this->_cityList->toOptionArray($params['region_id']);
            } else {
                $dataArray = $this->_cityList->toOptionArray();
            }

            $response = [];
            foreach($dataArray as $arr) {
                $response['htmlcontent'][] = "<option value='".$arr['value']."'>".$arr['label']."</option>";
            }

    		return $result->setData($response);
        }
	}
}