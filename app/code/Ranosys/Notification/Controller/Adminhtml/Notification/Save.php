<?php

namespace Ranosys\Notification\Controller\Adminhtml\Notification;

use Magento\Framework\Exception\LocalizedException as FrameworkException;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action {

    protected $notificationFactory;
    protected $fileUploaderFactory;
    protected $imageModel;
    protected $categoryFactory;
    protected $productRepository;
    protected $timezone;
    protected $resultFactory;
  
    public function __construct(
    \Magento\Backend\App\Action\Context $context,
            \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
            \Ranosys\Notification\Model\NotificationFactory $notificationFactory,
            \Ranosys\Notification\Model\ResourceModel\Image $imageModel,
            \Magento\Catalog\Model\Category $categoryFactory,
           \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
            \Magento\Framework\Stdlib\DateTime\DateTime $timezone
            
    ) {
        parent::__construct($context);
        $this->notificationFactory = $notificationFactory;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->categoryFactory = $categoryFactory;
        $this->productRepository = $productRepository;
        $this->imageModel = $imageModel;
        $this->timezone = $timezone;
    }

    public function execute() {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->_redirect('notification/notification/addrow');
            return;
        }
        
        try {

            $rowData = $this->notificationFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }

            $type = $data['type'];
            if(($type == 'Category')|| ($type == 'Product'))
            {
                $type_id = $data['type_id'];
                $redirection_title=  $data['redirection_title'];
                if(($redirection_title == '') && ($type == 'Category'))
                {
                    $category = $this->categoryFactory->load($type_id);
                 if($category->getName()!='')
                   $rowData->setRedirectionTitle($category->getName());
                }
                else if(($redirection_title == '') && ($type == 'Product'))
                {
                    $product = $this->productRepository->get($type_id);
                 if($product->getName()!='')
                    $rowData->setRedirectionTitle($product->getName());
                }
            }
             
            $currentDate = $this->timezone->date('Y-m-d H:i:s');
                if (!$this->getRequest()->getParam('id')) {
                    $rowData->setCreatedAt($currentDate);
                }

            $rowData->setUpdatedAt($currentDate);
            $rowData->setStoreId($data['store_id'][0]);
            $rowData->setAlert($data['title']);
            $imageName = $this->uploadFileAndGetName('image', $this->imageModel->getBaseDir(), $data);
            $rowData->setImage($imageName);
            $rowData->save();

            $this->messageManager->addSuccess(__('Notification data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('notification/notification/index');
    }

    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Ranosys_Notification::save');
    }

        public function uploadFileAndGetName($input, $destinationFolder, $data)
{
    try {
        if (isset($data[$input]['delete'])) {
            return '';
        } else {
            $uploader = $this->fileUploaderFactory->create(['fileId' => $input]);
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
