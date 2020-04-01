<?php

namespace Ranosys\Notification\Model;

abstract class NotificationBuilder {

    protected $scopeConfig;
    
    protected $serverKey;
    
    protected $notification;
    
    protected $headers;
    
    protected $deviceId;
    
    protected $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
    
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }
    
    protected function getServerKey(){
        if(!$this->serverKey){
            $this->serverKey = $this->scopeConfig->getValue('fcmnotification/general/fcm_server_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }
        return $this->serverKey;
    }
    
    /**
     * Set notification object
     * 
     * @param 
     */
    public function setNotification(\Ranosys\Notification\Model\Notificationpending $notification){
        $this->notification = $notification;
        return $this;
    }
    
    protected function getHeaders(){
        if(!$this->headers){
            $headers = [
                'Authorization: key=' . $this->getServerKey(),
				'Content-Type: application/json'
            ];
            $this->headers = $headers;
        }
        
        return $this->headers;
    }
    
    abstract protected function getPayload();
    
    
    public function send(){
        try{
            $payload = $this->getPayload();
            $request = curl_init();
            curl_setopt( $request, CURLOPT_URL, $this->fcmUrl );
            curl_setopt( $request, CURLOPT_POST, true );
            curl_setopt( $request, CURLOPT_HTTPHEADER, $this->getHeaders());
            curl_setopt( $request, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $request, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $request, CURLOPT_POSTFIELDS, json_encode($payload));
            $response = curl_exec($request);
            curl_close($request);
            $result = json_decode($response);
            return $result;
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }
    }

}