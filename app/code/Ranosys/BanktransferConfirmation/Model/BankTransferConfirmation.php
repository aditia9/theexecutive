<?php

namespace Ranosys\BanktransferConfirmation\Model;

use Magento\Framework\Exception\LocalizedException;
class BankTransferConfirmation implements \Ranosys\BanktransferConfirmation\Api\BankTransferConfirmationInterface {
    
    
	protected $request;
	protected $uploaderFactory;
	protected $adapterFactory;
	protected $filesystem;
	protected $orderCollectionFactory;
	protected $bankTransfer;
	protected $dataFactory;
    protected $eventManager;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\App\Request\Http $request,
		\Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
		\Magento\Framework\Image\AdapterFactory $adapterFactory,
		\Magento\Framework\Filesystem $filesystem,
		\Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Hypework\BanktransferConfirmation\Block\Confirmation\Form $bankTransfer,
        \Ranosys\BanktransferConfirmation\Api\Data\BankTransferdataInterfaceFactory $dataFactory
	) {
		$this->request = $request;
		$this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->bankTransfer = $bankTransfer;
        $this->dataFactory = $dataFactory;
        $this->eventManager = $context->getEventManager();
	}

      public function addBankInformation($customerId)
      {

    	$postValue = $this->request->getPostValue();
        
    	$orderCollection = $this->orderCollectionFactory->create()
            	->addFieldToFilter('increment_id', ['eq' => $postValue['orderid']])
            	->getFirstItem();

        $customer_id = $orderCollection->getCustomerId();
        if($customer_id != $customerId)
        {
             throw new LocalizedException(__('Unauthorized Customer for this Order'));
        }
        $paymentMethod = $orderCollection->getPayment()->getMethod();
        if ($paymentMethod != 'banktransfer') {
        	 throw new LocalizedException(__('Your Order is not using Bank Transfer Method.'));
        }

        $grandTotal = (int)$orderCollection->getGrandTotal();

        if ($grandTotal != $postValue['amount'] ) {
        
        	 throw new LocalizedException(
                    __('Your Amount is not Same')
                );
        }

    	try{
            $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'attachment']);
            $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

            $imageAdapter = $this->adapterFactory->create();
            
            /* start of validated image */
            $uploaderFactory->addValidateCallback('custom_image_upload', $imageAdapter,'validateUploadFile');
            $uploaderFactory->setAllowRenameFiles(true);
            $uploaderFactory->setFilesDispersion(true);
            $uploaderFactory->setAllowCreateFolders(true);

            $mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

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
            
            $this->eventManager->dispatch('banktransferconfirmation_submit_after', ['order' => $orderCollection]);

            return sprintf('%s', __('Submit Bank Transfer Confirmation Success.'));

        } catch (\Exception $e) {
        	throw new LocalizedException(
                    __('Submit Bank Transfer Confirmation Failed, please try again.')
                );
        }
    }
    
    public function getBankRecipient()
    {
        $recipients = $this->bankTransfer->getBanksRecipient();
        foreach($recipients as $recipient)
        {
        $bankRecipient = $this->dataFactory->create();
        $bankRecipient->setLabel($recipient);
        $bankRecipient->setValue($recipient);
        $bankRecipients[] = $bankRecipient;
        }
       return $bankRecipients;
    }
    
    public function getTransferMethod()
    {
        $methods = $this->bankTransfer->getTransferMethod();
         foreach($methods as $method)
        {
        $transferMethod = $this->dataFactory->create();
        $transferMethod->setLabel($method);
        $transferMethod->setValue($method);
        $transferMethods[] = $transferMethod;
        
        }
        return $transferMethods;
    }
    
}
