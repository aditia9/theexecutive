<?php

namespace Ranosys\Notification\Api\Data;

interface DeviceInterface
{

    const ID = 'id';
    const DEVICE_TYPE = 'device_type';
    const REGISTRATION_ID = 'registration_id';
    const DEVICE_ID = 'device_id';
    const STORE_ID = 'store_id';
    const CUSTOMER_ID = 'customer_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    
    /**
     * Get id
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Set id
     * 
     * @param int $id
     * @return $this
     */
    public function setId($id);
    
    
    /**
     * Get Device Type
     * 
     * @return string
     */
    public function getDeviceType();
    
    /**
     * Set Device Type
     * 
     * @param string $device_type
     * @return $this
     */
    public function setDeviceType($device_type);
    
    
    /**
     * Get Registration Id
     * 
     * @return string 
     */
    public function getRegistrationId();
    
    /**
     * Set Registration Id
     * 
     * @param string $registration_id
     * @return $this
     */
    public function setRegistrationId($registration_id); 
    
    
    /**
     * Get Device Id 
     * 
     * @return string
     */
    public function getDeviceId();

    /**
     * Set Device Id
     * 
     * @param string $device_id
     * @return $this
     */
    public function setDeviceId($device_id);

    
    /**
     * Get Store Id
     * 
     * @return int
     */
    public function getStoreId();
     
    /**
     * Set Store Id
     * 
     * @param int $store_id
     * @return $this
     */
    public function setStoreId($store_id);
     
    /**
     * Get Created At 
     * 
     * @return string
     */
    public function getCreatedAt();
    
    /**
     * Set Created At
     * 
     * @param string $updated_at
     * @return $this
     */
    public function setCreatedAt($updated_at);
    
    /**
     * Get Updated At
     * 
     * @return string
     */
    public function getUpdatedAt();
     
    /**
     * Set Updated At
     * 
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at);
    
    /**
     * Get Customer Id
     * 
     * @return int
     */
    public function getCustomerId();
   
    /**
     * Set Customer Id
     * 
     * @param int $customer_id
     * @return $this
     */
    public function setCustomerId($customer_id);
    
    
}
