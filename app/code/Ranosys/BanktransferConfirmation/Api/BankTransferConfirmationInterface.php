<?php

namespace Ranosys\BanktransferConfirmation\Api;

interface BankTransferConfirmationInterface
{
   /**
     * Add Bank Transfer Information
     *
     *@param int $customerId  
     * @return string message 
     */
    public function addBankInformation($customerId);
    
       /**
     * Get Bank Recipient
     *       
     * @return \Ranosys\BanktransferConfirmation\Api\Data\BankTransferdataInterface[]
     */
    public function getBankRecipient();
    
      /**
     * Get Transfer Method
     *       
     * @return \Ranosys\BanktransferConfirmation\Api\Data\BankTransferdataInterface[]
     */
    public function getTransferMethod();
   
}

?>