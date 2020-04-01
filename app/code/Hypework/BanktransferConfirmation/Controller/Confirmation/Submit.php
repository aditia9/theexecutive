<?php
namespace Hypework\BanktransferConfirmation\Controller\Confirmation;

class Submit extends \Magento\Framework\App\Action\Action
{
	protected $_request;
	protected $_storeManager;
	protected $_messageManager;
	protected $_customerSession;
	protected $_uploaderFactory;
	protected $_adapterFactory;
	protected $_filesystem;
	protected $_orderCollectionFactory;
	protected $_scopeConfig;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\App\Request\Http $request,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
		\Magento\Framework\Image\AdapterFactory $adapterFactory,
		\Magento\Framework\Filesystem $filesystem,
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
	) {
		$this->_request = $request;
		$this->_storeManager = $storeManager;
		$this->_messageManager = $context->getMessageManager();
		$this->_customerSession = $customerSession;
		$this->_uploaderFactory = $uploaderFactory;
        $this->_adapterFactory = $adapterFactory;
        $this->_filesystem = $filesystem;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_scopeConfig = $scopeConfig;

		return parent::__construct($context);
	}

    public function execute()
    {
    	$postValue = $this->_request->getPostValue();

    	$orderCollection = $this->_orderCollectionFactory->create()
            	->addFieldToFilter('increment_id', ['eq' => $postValue['orderid']])
            	->getFirstItem();

        $paymentMethod = $orderCollection->getPayment()->getMethod();

        if ($paymentMethod != 'banktransfer') {
        	$this->_redirect('customer/account/');
        	$this->_messageManager->addError(__('Your Order is not using Bank Transfer Method.'));
        }

        $grandTotal = (int)$orderCollection->getGrandTotal();

        if ($grandTotal != $postValue['amount'] ) {
        	$this->_redirect('customer/account/');
        	$this->_messageManager->addError(__('Your Amount is not same.'));
        }

    	try{
            $uploaderFactory = $this->_uploaderFactory->create(['fileId' => 'attachment']);
            $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

            $imageAdapter = $this->_adapterFactory->create();
            
            /* start of validated image */
            $uploaderFactory->addValidateCallback('custom_image_upload', $imageAdapter,'validateUploadFile');
            $uploaderFactory->setAllowRenameFiles(true);
            $uploaderFactory->setFilesDispersion(true);
            $uploaderFactory->setAllowCreateFolders(true);

            $mediaDirectory = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

            $destinationPath = $mediaDirectory->getAbsolutePath('banktransfer_confirmation/');
            $result = $uploaderFactory->save($destinationPath);

            if (!$result) {
                throw new LocalizedException(
                    __('File cannot be saved to path: $1', $destinationPath)
                );
            }

            $imagepath = $result['file'];

            $orderCollection->setBankName($postValue['bank_name']);
            $orderCollection->setAccountNumber($postValue['holder_account']);
            $orderCollection->setTransferAmount($postValue['amount']);
            $orderCollection->setBankRecipient($postValue['recipient']);
            $orderCollection->setTransferMethod($postValue['method']);
            $orderCollection->setTransferDate($postValue['date']);
            $orderCollection->setAttachment($imagepath);
            $orderCollection->setNameWhoTransfer($postValue['name']);
            $orderCollection->setEmailWhoTransfer($postValue['email_submitter']);
            $orderCollection->setStatus('payment_confirmation');
            $orderCollection->save();

            $this->_redirect('customer/account/');
            $this->_messageManager->addSuccess(__('Submit Bank Transfer Confirmation Success.'));

        } catch (\Exception $e) {
        	$e->getMessage();
            $this->_redirect('customer/account/');
        	$this->_messageManager->addError(__('Submit Bank Transfer Confirmation Failed, please try again.'));
        }
    }
}
