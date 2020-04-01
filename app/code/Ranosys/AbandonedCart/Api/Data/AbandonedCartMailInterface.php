<?php

namespace Ranosys\AbandonedCart\Api\Data;

interface AbandonedCartMailInterface
{

    const ID = 'id';
    const CART_ID = 'cart_id';
    const SENT_AT = 'sent_at';
      
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
     * Get Cart Id
     * 
     * @return int
     */
    public function getCartId();
    
    /**
     * Set Cart Id
     * 
     * @param int $cart_id
     * @return $this
     */
    public function setCartId($cart_id);
    
    
    /**
     * Get Sent At
     * 
     * @return string 
     */
    public function getSentAt();
    
    /**
     * Set Sent At
     * 
     * @param string $sent_at
     * @return $this
     */
    public function setSentAt($sent_at); 
 
}
