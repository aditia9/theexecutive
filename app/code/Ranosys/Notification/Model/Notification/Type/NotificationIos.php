<?php

namespace Ranosys\Notification\Model\Notification\Type;


class NotificationIos extends \Ranosys\Notification\Model\NotificationBuilder {
    
    protected function getPayload() {
        
        $messageBody = $this->notification->getMessage();
        
        $payload = [];
        
        $media_url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        
        if($this->notification->getImage()) {
            $image_url = $media_url . 'notification_image' . $this->notification->getImage();
        } else {
            $image_url = '';
        }
        
        $notification = [
            'body' => $messageBody,
            'title' => $this->notification->getTitle(),
            'sound' => 'default',
            'badge' => 1,
            'click_action' => 'defaultCategory',
        ];
        
        $data = [
            'type' => $this->notification->getType(),
            'typeId' => $this->notification->getTypeId(),
            'redirect_title' => $this->notification->getRedirectionTitle(),
            'image_url' => $image_url,
            'notification_id' => $this->notification->getNotificationId()
        ];
        
        $payload = [
            'to' => $this->notification->getRegistrationId(),
            'mutable_content' => true,
            'notification'	=> $notification,
            'data' => $data
        ];
        
        return $payload;
    }
    
}