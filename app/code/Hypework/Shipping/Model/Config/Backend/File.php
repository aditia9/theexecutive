<?php

namespace Hypework\Shipping\Model\Config\Backend;

class File extends \Magento\Config\Model\Config\Backend\File
{
	public function getAllowedExtensions() {
		return ['csv'];
	}
}