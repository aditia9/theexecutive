<?php


namespace Ranosys\Promotion\Controller\Adminhtml\Grid;
use Magento\Framework\Exception\LocalizedException as FrameworkException;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Ranosys\Promotion\Model\GridFactory
     */
    var $gridFactory;

    protected $imageModel;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Ranosys\Promotion\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Ranosys\Promotion\Model\GridFactory $gridFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Ranosys\Promotion\Model\ResourceModel\Image $imageModel
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->gridFactory = $gridFactory;
        $this->imageModel = $imageModel;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['promotion_id'])) {
                $rowData->setEntityId($data['promotion_id']);
            }
            $rowData['promotion_store']=implode(',',$rowData['promotion_store']);
            $imageName = $this->uploadFileAndGetName('promotion_image', $this->imageModel->getBaseDir(), $data);
            $rowData->setpromotion_image($imageName);
            $rowData->save();
            $this->messageManager->addSuccess(__('Promotion data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
       $this->_redirect('grid/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ranosys_Promotion::save');
    }
    
    public function uploadFileAndGetName($input, $destinationFolder, $data)
{
    try {
        if (isset($data[$input]['delete'])) {
            return '';
        } else {
            $uploader = $this->uploaderFactory->create(['fileId' => $input]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            $result = $uploader->save($destinationFolder);
            return $result['file'];
        }
    } catch (\Exception $e) {
        if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
            throw new FrameworkException($e->getMessage());
        } else {
            if (isset($data[$input]['value'])) {
                return $data[$input]['value'];
            }
        }
    }
    return '';
}
}
