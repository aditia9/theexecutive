<?php

namespace Hypework\Shipping\Controller\Adminhtml\City;

class Template extends \Magento\Backend\App\Action 
{
    const ADMIN_RESOURCE = 'Hypework_Shipping::city_template';
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
                    __('region_code'),
                    __('name'),
                );

            $fileSystem = $om->create('\Magento\Framework\Filesystem');
            $varPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)->getAbsolutePath();
            $outputFile = $varPath."city_template.csv";
            $handle = fopen($outputFile, 'w');
            fputcsv($handle, $heading);

            $dummyCollection = array(
                    array('ID-JK', 'Jakarta Pusat'),
                    array('ID-JK', 'Jakarta Barat'),
                    array('ID-JK', 'Jakarta Timur'),
                    array('ID-JK', 'Jakarta Utara'),
                    array('ID-JK', 'Jakarta Selatan'),
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