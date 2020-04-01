<?php

namespace Ranosys\Notification\Model\Notification;

class DevicePool {
    
    protected $deviceTypes;
    
    public function __construct(
        array $deviceTypes
    ) {
        $this->deviceTypes = $deviceTypes;
    }
    
    /**
     * Get notification builder object by device
     * 
     * @param string $device
     */
    public function getNotificationBuilder($device) {
        if(array_key_exists($device, $this->deviceTypes)){
            return $this->deviceTypes[$device];
        }
        
        return FALSE;
    }
    
}