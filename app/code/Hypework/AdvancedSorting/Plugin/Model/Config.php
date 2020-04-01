<?php
namespace Hypework\AdvancedSorting\Plugin\Model;

use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Config
 * @package Linchpoin\AdvancedSorting\Plugin\Model
 */
class Config  {

	/**
	 * @var StoreManagerInterface
	 */
	protected $_storeManager;

	/**
	 * Config constructor.
	 * @param StoreManagerInterface $storeManager
	 *
	 */
	public function __construct(
		StoreManagerInterface $storeManager
	) {
		$this->_storeManager = $storeManager;
	}

	/**
	 * Adding custom options and changing labels
	 *
	 * @param \Magento\Catalog\Model\Config $catalogConfig
	 * @param [] $options
	 * @return []
	 */
	public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $catalogConfig, $options)
	{
		$store = $this->_storeManager->getStore();
		$currencySymbol = $store->getCurrentCurrency()->getCurrencySymbol();

		// Remove specific default sorting options
		$default_options = [];

		unset($options['position']);
		unset($options['price']);

		//Changing label
		$customOption['position'] = __( 'New Arrivals' );

		//New sorting options
		$customOption['price_desc'] = __( 'High to Low' );
		$customOption['price_asc'] = __( 'Low to High' );

		//Merge default sorting options with custom options
		$options = array_merge($customOption, $options);

		return $options;
	}
}