<?php

namespace Ranosys\Notification\Model;

use Magento\Framework\Data\OptionSourceInterface;
use Ranosys\Notification\Model\Notification;

class Option implements OptionSourceInterface
{
    
    public function getOptionArray()
    {
        $options = ['1' => __('Enabled'),
                    '0' => __('Disabled')];
        return $options;
    }

    /**
     * Get Grid row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get Grid row type array for option element.
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
    
     public function getTypeArray()
    {
        $options = ['Category' =>__('Category'),
                    'Product' => __('Product'),
                    'NotificationListing' => __('Notify List')];
        return $options;
    }
     public function getNotificationArray()
    {
        $options = [
            //'Standard' =>__('Standard'),
            'Promotional' => __('Promotional')
        ];
        return $options;
    }
    
    public function getPublishStatusArray(){
        $statuses = [
            Notification::NOTIFICATION_STATUS_PENDING => __(Notification::NOTIFICATION_STATUS_PENDING_LABEL),
            Notification::NOTIFICATION_STATUS_PUBLISHED => __(Notification::NOTIFICATION_STATUS_PUBLISHED_LABEL),
            Notification::NOTIFICATION_STATUS_SENT => __(Notification::NOTIFICATION_STATUS_SENT_LABEL),
        ];
        
        return $statuses;
    }
}
