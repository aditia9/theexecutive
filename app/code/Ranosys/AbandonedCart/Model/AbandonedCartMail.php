<?php

namespace Ranosys\AbandonedCart\Model;

use Ranosys\AbandonedCart\Api\Data\AbandonedCartMailInterface;

class AbandonedCartMail extends \Magento\Framework\Model\AbstractModel implements AbandonedCartMailInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'abandoned_cart_mail';

    /**
     * @var string
     */
    protected $cacheTag = 'abandoned_cart_mail';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $eventPrefix = 'abandoned_cart_mail';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\AbandonedCart\Model\ResourceModel\AbandonedCartMail');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
  
    /**
     * {@inheritdoc}
     */
    public function getCartId()
    {
        return $this->getData(self::CART_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCartId($cart_id)
    {
        return $this->setData(self::CART_ID, $cart_id);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getSentAt()
    {
        return $this->getData(self::SENT_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setSentAt($sent_at)
    {
        return $this->setData(self::SENT_AT, $sent_at);
    }
    
}
