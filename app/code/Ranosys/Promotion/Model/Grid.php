<?php
 

namespace Ranosys\Promotion\Model;
 
use Ranosys\Promotion\Api\Data\GridInterface;
 
class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'home_promotions';
 
    /** 
     * @var string
     */
    protected $_cacheTag = 'home_promotions';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'home_promotions';
 
    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Ranosys\Promotion\Model\ResourceModel\Grid');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::PROMOTION_ID);
    }
 
    /**
     * Set EntityId.
     * 
     * @param string $entityId
     * @return int
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::PROMOTION_ID, $entityId);
    }
 
    /**
     * Get Title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::PROMOTION_TITLE);
    }
 
    /**
     * Set Title.
     */
    public function setTitle($title)
    {
        return $this->setData(self::PROMOTION_TITLE, $title);
    }
 
    /**
     * Get getContent.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::PROMOTION_DESCRIPTION);
    }
 
    /**
     * Set Content.
     */
    public function setDescription($content)
    {
        return $this->setData(self::PROMOTION_DESCRIPTION, $content);
    }
    
        /**
     * Get getContent.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::PROMOTION_TYPE);
    }
 
    /**
     * Set Content.
     */
    public function setType($type)
    {
        return $this->setData(self::PROMOTION_TYPE, $type);
    }
    
    /**
     * Get getContent.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->getData(self::PROMOTION_VALUE);
    }
 
    /**
     * Set Content.
     */
    public function setValue($value)
    {
        return $this->setData(self::PROMOTION_VALUE, $value);
    }
    /**
     * Get getContent.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->getData(self::PROMOTION_POSITION);
    }
 
    /**
     * Set Content.
     */
    public function setPosition($position)
    {
        return $this->setData(self::PROMOTION_POSITION, $position);
    }
 
     /**
     * Get getContent.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::PROMOTION_IMAGE);
    }
 
    /**
     * Set Content.
     */
    public function setImage($image)
    {
        return $this->setData(self::PROMOTION_IMAGE, $image);
    }
    /**
     * Get CreatedAt.
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }
 
    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}