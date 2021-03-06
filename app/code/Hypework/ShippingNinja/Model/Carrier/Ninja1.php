<?php
/**
 * Created by PhpStorm.
 * User: rifki
 * Date: 3/18/18
 * Time: 8:35 PM
 */
namespace Hypework\ShippingNinja\Model\Carrier;
 
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
 
class Ninja extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'ninja';
    protected $_ratesCollectionFactory;
    protected $_checkoutSession;
    protected $_rateResultFactory;
    protected $_rateMethodFactory;
    protected $_quoteFactory;
 
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Hypework\Shipping\Model\ResourceModel\Rates\CollectionFactory $ratesCollectionFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_ratesCollectionFactory = $ratesCollectionFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_quoteFactory = $quoteFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }
 
    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
 
    /**
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) return false;
 
        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->_rateResultFactory->create();

        $items = $request->getAllItems();
        $quoteId = false;
        foreach ($items  as $item) {
            $quoteId = $item->getQuoteId();
            break;
        }
        $quote = $this->getCurrentQuote($quoteId);
 
        /*you can fetch shipping price from different sources over some APIs, we used price from config.xml - xml node price*/
        $amount = $this->getConfigData('price');
        $ratesCollection = $this->_ratesCollectionFactory->create();
        //join with city
        $ratesCollection->getSelect()->joinLeft(
            array('city' => 'hypework_shipping_city'),
            'main_table.city_id = city.entity_id',
            array('city_name' => 'city.name')
        );
        //join with carrier
        $ratesCollection->getSelect()->joinLeft(
            array('carrier' => 'hypework_shipping_carrier'),
            'main_table.carrier_id = carrier.entity_id',
            array('carrier_name' => 'carrier.name')
        );
        //filter by selected city & carrier
        if(is_numeric($request->getDestCity())) {
            $rate = $ratesCollection->addFieldToFilter('city.entity_id', $request->getDestCity())
                    ->addFieldToFilter('main_table.region_id', $request->getDestRegionId())
                    ->addFieldToFilter('carrier.name', $this->_code)
                    ->addFieldToFilter('main_table.rate', ['neq' => 0]);
        } else {
            $rate = $ratesCollection->addFieldToFilter('city.name', $request->getDestCity())
                    ->addFieldToFilter('main_table.region_id', $request->getDestRegionId())
                    ->addFieldToFilter('carrier.name', $this->_code)
                    ->addFieldToFilter('main_table.rate', ['neq' => 0]);
        }

        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $configShipping = $om->create('\Magento\Framework\App\Config\ScopeConfigInterface');
        $carrierTitle = $configShipping->getValue('carriers/ninja/title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $carrierName = $configShipping->getValue('carriers/ninja/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        foreach ($rate as $key => $value) {
            /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
            $method = $this->_rateMethodFactory->create();
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($carrierTitle);
            $method->setMethod($value->getCarrierName());
            $method->setMethodTitle($carrierName);
            $method->setPrice($value->getRate());
            $method->setCost($value->getRate());
            $result->append($method);
        }
        
        return $result;
    }

    protected function getCurrentQuote($quoteId)
    {
        return $this->_quoteFactory->create()->load($quoteId);
    }

    private function getVolumeWeight($request)
    {
        $weight = 0;
        $prod = Mage::getModel('catalog/product');
        foreach ($request->getAllItems() as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            $dim = $prod->load($item->getProduct()->getId());
            if (is_numeric($length = $dim->getLength()) && is_numeric($width = $dim->getWidth()) && is_numeric($height = $dim->getHeight())) {
                $volumeWeight = ($length * $width * $height) / 6000;
                $weight += ( ($item->getWeight() > $volumeWeight ? $item->getWeight() : $volumeWeight) * $item->getQty() );
            } else {
                $weight += ( $item->getWeight() * $item->getQty() );
            }
        }

        return ceil($weight);
    }
}