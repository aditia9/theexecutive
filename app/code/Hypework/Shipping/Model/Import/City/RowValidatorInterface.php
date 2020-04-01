<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Hypework\Shipping\Model\Import\City;

interface RowValidatorInterface extends \Magento\Framework\Validator\ValidatorInterface
{
  	const ERROR_INVALID_REGION_CODE = 'InvalidValueRegionCode';
    const ERROR_REGION_CODE_IS_EMPTY = 'EmptyRegionCode';
    const ERROR_INVALID_NAME = 'InvalidValueName';
    const ERROR_NAME_IS_EMPTY = 'EmptyName';
    
    /**
     * Initialize validator
     *
     * @return $this
     */
    public function init($context);
}