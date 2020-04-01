<?php

namespace Hypework\Shipping\Controller\Adminhtml\Rates;

class Template extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::rates_template';
	protected $resultPageFactory = false;
    protected $resultForwardFactory;

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

	public function execute()
	{
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        try {

            $heading = array(
                    __('carrier_name'),
                    __('region_code'),
                    __('city_name'),
                    __('district_name'),
                    __('subdistrict_name'),
                    __('rate'),
                );

            $fileSystem = $om->create('\Magento\Framework\Filesystem');
            $varPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)->getAbsolutePath();

            $outputFile = $varPath."rates_template.csv";
            $handle = fopen($outputFile, 'w');
            fputcsv($handle, $heading);

            $dummyCollection = array(
                    array('jne', 'ID-JK', 'Jakarta Pusat', '', '', '9000'),
                    array('tiki', 'ID-JK', 'Jakarta Pusat', '', '', '10000'),
                    array('ekspedisi', 'ID-JK', 'Jakarta Pusat', '', '', '15000'),
                    array('hypework', 'ID-JK', 'Jakarta Pusat', '', '', '8000'),
                    array('hypework', 'ID-JK', 'Jakarta Utara', '', '', '10000'),
                    array('sap', 'ID-JK', 'Jakarta Pusat', '', '', '9000'),
                    array('sap', 'ID-JK', 'Jakarta Utara', '', '', '9500'),
                    array('ninja', 'ID-JK', 'Jakarta Pusat', '', '', '11000'),
                    array('ninja', 'ID-JK', 'Jakarta Utara', '', '', '12000'),
                );
            foreach ($dummyCollection as $dummy) {            
                fputcsv($handle, $dummy);
            }

            $helper = $this->getHelper();
            $helper->downloadCsv($outputFile);
            $this->messageManager->addSuccess(__('Download Template was succeed.'));

        } catch (Exception $ex) {
            $this->messageManager->addError(__('Download Template was failed.'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        //return $resultRedirect->setPath('*/*/*');
	}

    private function getHelper() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->get('\Hypework\Shipping\Helper\Data');

        return $helper;
    }
}