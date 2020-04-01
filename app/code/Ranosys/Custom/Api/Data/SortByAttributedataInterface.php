<?php

namespace Ranosys\Custom\Api\Data;

/**
 * @api
 */
interface SortByAttributedataInterface {

    /**
     * Get code of attributes
     *
     * @return string
     */
    public function getAttributeCode();

    /**
     * Get name of attribute
     *
     * @return string
     */
    public function getAttributeName();

    /**
     * Set code of attributes
     * 
     * @param string $attributecode
     * @return $this
     */
    public function setAttributeCode($attributecode);

    /**
     * Set name of attributes
     * 
     * @param string $attributename
     * @return $this
     */
    public function setAttributeName($attributename);
}
