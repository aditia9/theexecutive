<?php

namespace Ranosys\Promotion\Api\Data;
 
interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const PROMOTION_ID = 'promotion_id';
    const PROMOTION_TITLE = 'promotion_title';
    const PROMOTION_DESCRIPTION = 'promotion_description';
    const PROMOTION_TYPE = 'promotion_type';
    const PROMOTION_VALUE = 'promotion_value';
    const PROMOTION_POSITION = 'promotion_position';
    const PROMOTION_IMAGE = 'promotion_image';
    const CREATED_AT = 'created_at';
 
    /**
     * Get EntityId.
     *
     * @return string
     */
    public function getEntityId();
 
    /**
     * Set EntityId.
     * @param string $entityId
     * @return string
     */
    public function setEntityId($entityId);
 
    /**
     * Get Title.
     *
     * @return string
     */
    public function getTitle();
 
    /**
     * Set Title.
     * @return string
     */
    public function setTitle($title);
 
    /**
     * Get Description.
     *
     * @return string
     */
    public function getDescription();
 
    /**
     * Set Description.
     * @return string
     */
    public function setDescription($content);
    
    /**
     * Get Type.
     *
     * @return string
     */
    public function getType();
 
    /**
     * Set Type.
     * @return string
     */
    public function setType($type);
    
    /**
     * Get Value.
     *
     * @return string
     */
    public function getValue();
 
    /**
     * Set Value.
     * @return string
     */
    public function setValue($value);
     /**
     * Get Position.
     *
     * @return int
     */
    public function getPosition();
 
    /**
     * Set Position.
     * @return int
     */
    public function setPosition($position);
    /**
     * Get Image.
     *
     * @return string
     */
    public function getImage();
 
    /**
     * Set Image.
     * @return string
     */
    public function setImage($image);
 
    /**
     * Get CreatedAt.
     *
     * @return string
     */
    public function getCreatedAt();
 
    /**
     * Set CreatedAt.
     * @return string
     */
    public function setCreatedAt($createdAt);
}