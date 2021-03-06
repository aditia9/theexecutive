<?php

namespace Ranosys\Notification\Model\ResourceModel;

class Notificationdelivered extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $idFieldName = 'id';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime       $date
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->date = $date;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('notifications_delivered', 'id');
    }
}
