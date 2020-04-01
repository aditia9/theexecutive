<?php

namespace Ranosys\Sales\Model;

use Ranosys\Sales\Api\MyOrdersInterface;
use Magento\Framework\Exception\InputException;
use \Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\ShippingAssignmentInterface;
use Magento\Sales\Model\Order\ShippingAssignmentBuilder;
use Magento\Sales\Model\ResourceModel\Metadata;
use Magento\Framework\App\ObjectManager;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;


/**
 * Implementation class of contract.
 */
class MyOrders implements MyOrdersInterface
{

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    protected $_orderCollectionFactory;
    protected $orders;
    
    /**
     * @var Metadata
     */
    protected $metadata;

    
    /**
     * @var OrderInterface[]
     */
    protected $registry = [];
    
    /**
     * @var ShippingAssignmentBuilder
     */
    private $shippingAssignmentBuilder;
    
    protected $orderItemExtensionFactory;
    
    protected $orderConfig;
    
    protected $orderItemOptionsFactory;
    
    protected $addressFactory;
    
    protected $regionFactory;
    
    protected $orderPaymentCollectionFactory;
    protected $orderSuccessDataFactory;
      protected $resourceConnection;
      protected $orderStatusFactory;


    /**
     * Constructor
     *
     * @param Metadata $metadata
     * @param \Magento\Sales\Api\Data\OrderExtensionFactory|null $orderExtensionFactory
     */

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productrepositoryinterface,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Ranosys\Sales\Api\Data\MyOrdersdataInterfaceFactory $dataFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        StoreManagerInterface $storeManager,
        \Magento\Sales\Model\OrderRepository $orderRepositoryModel,
        Metadata $metadata,
        \Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory = null,
        \Magento\Sales\Api\Data\OrderItemExtensionFactory $orderItemExtensionFactory,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Ranosys\Sales\Model\Data\OrderItemOptionsFactory $orderItemOptionsFactory,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory,
        \Magento\Customer\Api\Data\RegionInterfaceFactory $regionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Payment\CollectionFactory $orderPaymentCollectionFactory,
        ResourceConnection $resourceConnection,
        \Ranosys\Sales\Api\Data\OrderSuccessDetailInterfaceFactory $orderSuccessDataFactory,
        \Magento\Sales\Model\ResourceModel\Order\Status\Collection $orderStatusFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Customer\Api\Data\AddressExtensionFactory $addressExtensionFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderSuccessDataFactory = $orderSuccessDataFactory;
        $this->dataFactory = $dataFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->productrepositoryinterface = $productrepositoryinterface;
        $this->_storeManager = $storeManager;
        $this->metadata = $metadata;
        $this->orderRepositoryModel = $orderRepositoryModel;
        $this->orderItemExtensionFactory = $orderItemExtensionFactory;
        $this->orderConfig = $orderConfig;
        $this->orderItemOptionsFactory = $orderItemOptionsFactory;
        $this->orderPaymentCollectionFactory = $orderPaymentCollectionFactory;
        $this->addressFactory = $addressFactory;
        $this->regionFactory = $regionFactory;
        $this->orderExtensionFactory = $orderExtensionFactory ?: ObjectManager::getInstance()
            ->get(\Magento\Sales\Api\Data\OrderExtensionFactory::class);
         $this->resourceConnection = $resourceConnection;
         $this->orderStatusFactory = $orderStatusFactory;
         $this->orderFactory = $orderFactory;
         $this->scopeConfig = $scopeConfig;
         $this->timezone = $timezone;
         $this->_countryFactory = $countryFactory;
         $this->addressExtensionFactory = $addressExtensionFactory;
    }

    /**
     * Return array
     *
     * @api
     * @param int $customerId
     * @return \Ranosys\Sales\Api\Data\MyOrdersdataInterface[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getmyOrders($customerId) {
        
        $orderData = [];
        
        if (!$this->orders) {
        $this->orders = $this->_orderCollectionFactory->create()->addFieldToSelect(
            '*'
        )->addFieldToFilter(
            'customer_id',
            $customerId
        )->setOrder(
            'created_at',
            'desc'
        );
        
        /**
         * comment order status filter temporarily
         * ->addFieldToFilter(
            'status',
            ['in' => $this->orderConfig->getVisibleOnFrontStatuses()]            
        )
         */
        
        }
        $orders = $this->orders->getData();      
      
        foreach($orders as $order) {
            $orderId = $order['entity_id'];
            $order = $this->orderRepository->get($orderId);
            $statusLabel = $order->getStatusLabel();
            $ordersIncrementId = $order['increment_id'];
            $paymentMethod = $this->getPaymentMethod($ordersIncrementId);
            $orderDate = $order['created_at'];
            $orderPrice = $order['grand_total'];
            $orderStatus = $statusLabel;
            $orderImage = $this->getImageUrl($order);
            
            $dataModel = $this->dataFactory->create();
        
            $dataModel->setId($ordersIncrementId);
            $dataModel->setAmount($orderPrice);
            $dataModel->setDate($orderDate);
            $dataModel->setStatus($orderStatus);
            $dataModel->setImage($orderImage);
            $dataModel->setPaymentMethod($paymentMethod);
            $dataModel->setIsRefundable($this->isReturnable($order));
            
            $orderData[] = $dataModel;
        }
        
        return $orderData;
        
    }
    
    public function getPaymentMethod($ordersIncrementId)
    {
        $paymentInfo = $this->orderFactory->create()->loadByIncrementId($ordersIncrementId);
        $paymentMethod = $paymentInfo->getPayment()->getMethodInstance()->getTitle();
        return $paymentMethod;
    }
    
    public function isReturnable($order){
        
        $isReturnable = FALSE;
        $returnPeriod = $this->scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/returnin_days', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $returnEnabled = $this->scopeConfig->getValue('hypework_productreturn/hypework_productreturn_group/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        if($order['state'] == \Magento\Sales\Model\Order::STATE_COMPLETE && $returnEnabled == '1') {
            $orderedDate = strtotime($order['updated_at']);
            $currentDate = strtotime($this->timezone->gmtDate());
            $returnPeriodSeconds = $returnPeriod*24*60*60;
            $refundableDate = $orderedDate + $returnPeriodSeconds ;
            if($refundableDate >= $currentDate) {
                $isReturnable = TRUE;
            }
        }
        
        return $isReturnable;
    }
    
    public function getImageUrl($order) {
        
            foreach ($order->getAllVisibleItems() as $item) {
                $product = $item->getProduct();
                $productSku = $product->getData('sku');
                $loadedProduct = $this->productrepositoryinterface->get($productSku);
                return $imageUrl = $loadedProduct->getImage();
          }
        
    }
    
    
    /**
     * load entity
     *
     * @param string $orderId
     * @param int $customerId
     * @return \Magento\Sales\Api\Data\OrderInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    
    public function getDetail($orderId, $customerId) {
        
      if (!$orderId) {
            throw new InputException(__('Id required'));
        }
        if (!isset($this->registry[$orderId])) {
            
            /** @var OrderInterface $entity */
            $entity = $this->metadata->getNewInstance()->loadByIncrementId($orderId);
            if (!$entity->getEntityId()) {
                throw new NoSuchEntityException(__('Requested entity doesn\'t exist'));
            }
            $this->setShippingAssignments($entity);
            $this->setAdditionalData($entity);
            $this->registry[$orderId] = $entity;
        }
        return $this->registry[$orderId];
        
    }
    
    public function setAdditionalData(OrderInterface $order) {
        $items = $order->getItems();
        $output = [];
        $incrementId = $order->getIncrementId();
        $getOrder = $this->resourceConnection
                ->getConnection()->select()->from('hypework_prismalink_va')
                ->where('increment_id=?', $incrementId);
          $findOrder = $this->resourceConnection->getConnection()->fetchRow($getOrder);
          
        foreach($items as $item) {
            
            if($item->getProductType() == \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE && ($item->getParentItemId() !== NULL)){
                continue;
            }
            
            $extensionAttributes = $item->getExtensionAttributes();
            if($extensionAttributes === null) {
                $extensionAttributes = $this->orderItemExtensionFactory->create();
            }
            
            if($item->getProductType() == Configurable::TYPE_CODE){
                $productOptions = $item->getProductOptions();
                $productImage = $item->getProduct()->getImage();
                $extensionAttributes->setImage($productImage);
                $options = [];
                foreach($productOptions['attributes_info'] as $option) {
                    $orderItemOption = $this->orderItemOptionsFactory->create();
                    $orderItemOption->setLabel($option['label']);
                    $orderItemOption->setValue($option['value']);
                    $orderItemOption->setOptionId($option['option_id']);
                    $orderItemOption->setOptionValue($option['option_value']);
                    $options[] = $orderItemOption;
                }
                $extensionAttributes->setOptions($options);
            } elseif($item->getParentItemId() == NULL) {
                $productId = $item->getProductId();
                $product = $this->productrepositoryinterface->getById($productId);
                $extensionAttributes->setImage($product->getImage());
            }           
            
            
            $item->setExtensionAttributes($extensionAttributes);
            
            $output[] = $item;
        }
        
        $order->setItems($output);
        
        $extensionAttributes = $order->getExtensionAttributes();
        
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }
       
        $billingAddress = $order->getBillingAddress();
        if($billingAddress){
            $billingAddressFormatted = $this->prepareAddressFormat($order, $billingAddress);
            $extensionAttributes->setFormattedBillingAddress($billingAddressFormatted);
        }
        
        $shippingAddress = $order->getShippingAddress();
        if($shippingAddress){
            $shippingAddressFormatted = $this->prepareAddressFormat($order, $shippingAddress);
            $extensionAttributes->setFormattedShippingAddress($billingAddressFormatted);
        }
        
        if(isset($findOrder)){
            $va_number = $findOrder['account_no'];
            $extensionAttributes->setVirtualAccountNumber($va_number);
        }
        
        $extensionAttributes->setPaymentMethod($this->getPaymentMethod($incrementId));
        
        $order->setExtensionAttributes($extensionAttributes);
    }
    
    protected function prepareAddressFormat($order, $address) {
        $formattedAddress = $this->addressFactory->create();
        $formattedAddress->setId($address->getCustomerAddressId());
        $formattedAddress->setCustomerId($order->getCustomerId());
        $formattedAddress->setRegionId($address->getRegionId());
        $formattedAddress->setCountryId($address->getCountryId());
        $formattedAddress->setFax($address->getFax());
        $formattedAddress->setCompany($address->getCompany());
        $formattedAddress->setTelephone($address->getTelephone());
        $formattedAddress->setPostcode($address->getPostcode());
        $formattedAddress->setCity($address->getCity());
        $formattedAddress->setFirstname($address->getFirstname());
        $formattedAddress->setLastname($address->getLastname());
        $formattedAddress->setMiddlename($address->getMiddlename());
        $formattedAddress->setPrefix($address->getPrefix());
        $formattedAddress->setSuffix($order->getSuffix());
        $formattedAddress->setVatId($address->getVatId());
        $formattedAddress->setIsDefaultBilling(FALSE);
        $formattedAddress->setIsDefaultShipping(FALSE);
        
        $region = $this->regionFactory->create();
        $region->setRegion($address->getRegion());
        $region->setRegionId($address->getRegionId());
        $region->setRegionCode($address->getRegionCode());
        
        $formattedAddress->setRegion($region);
        $formattedAddress->setRegionId($address->getRegionId());
        $formattedAddress->setStreet($address->getStreet());

        $extensionAttributes = $formattedAddress->getExtensionAttributes();
     
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->addressExtensionFactory->create();
        }
        $country = $this->_countryFactory->create()->loadByCode($address->getCountryId());
        if(isset($country)){
            $countryName = $country->getName();
            $extensionAttributes->setCountryName($countryName);
        }
        $formattedAddress->setExtensionAttributes($extensionAttributes);
        
        return $formattedAddress;
    }
    
    
    /**
     * @param OrderInterface $order
     * @return void
     */
    public function setShippingAssignments(OrderInterface $order)
    {
        /** @var OrderExtensionInterface $extensionAttributes */
        $extensionAttributes = $order->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        } elseif ($extensionAttributes->getShippingAssignments() !== null) {
            return;
        }
        /** @var ShippingAssignmentInterface $shippingAssignment */
        $shippingAssignments = $this->getShippingAssignmentBuilderDependency();
        $shippingAssignments->setOrderId($order->getEntityId());
        $extensionAttributes->setShippingAssignments($shippingAssignments->create());
        $order->setExtensionAttributes($extensionAttributes);
    }
    
    public function getShippingAssignmentBuilderDependency()
    {
        if (!$this->shippingAssignmentBuilder instanceof ShippingAssignmentBuilder) {
            $this->shippingAssignmentBuilder = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Sales\Model\Order\ShippingAssignmentBuilder::class
            );
        }
        return $this->shippingAssignmentBuilder;
    }

    public function getOrderStatusInformation($orderId, $customerId)
    {
   
       $orderSuccessDataCollection = $this->orderSuccessDataFactory->create();
       $orderCollection = $this->_orderCollectionFactory->create()
            	->addFieldToFilter('entity_id', ['eq' => $orderId])
            	->getFirstItem();
       if(empty($orderCollection))
       {
           throw new LocalizedException(__('No Such Order Found'));
       }
       if($customerId != $orderCollection->getCustomerId())
       {
           throw new LocalizedException(__('Unauthorized Customer for this Order'));
       }

       $store_id = $orderCollection->getStoreId();
       $order_increment_id = $orderCollection->getIncrementId();
       $status = $orderCollection->getStatus();
       
       
       $orderStatus = $this->orderStatusFactory
                    ->addFieldToFilter('status', ['eq' => $status])->getData();
       
       $status_label = $orderStatus[0]['label'];
       
       $paymentCollection = $this->orderPaymentCollectionFactory->create()
               ->addFieldToFilter('parent_id', ['eq' => $orderId])
            	->getFirstItem();
       
       $payment_method =$paymentCollection->getMethod();
     
       
       $orderSuccessDataCollection->setPaymentMethod($payment_method);
       $orderSuccessDataCollection->setGrandTotal($orderCollection->getGrandTotal());
       $orderSuccessDataCollection->setShippingMethod($orderCollection->getShippingMethod());
       $orderSuccessDataCollection->setBaseCurrencyCode($orderCollection->getBaseCurrencyCode());
       $orderSuccessDataCollection->setOrderId($order_increment_id);
       $orderSuccessDataCollection->setStatusCode($orderCollection->getStatus());
       $orderSuccessDataCollection->setOrderState($orderCollection->getState());
       $orderSuccessDataCollection->setStatusLabel($status_label);
       
       if($payment_method == 'prismalink_vabca')
       {
          $getOrder = $this->resourceConnection
                ->getConnection()->select()->from('hypework_prismalink_va')
                ->where('increment_id=?', $order_increment_id)
                ->where('store_id=?', $store_id);
          $findOrder = $this->resourceConnection->getConnection()->fetchRow($getOrder);
          $va_number = $findOrder['account_no'];
          
          $orderSuccessDataCollection->setVirtualAccountNumber($va_number);
       }
             
       return $orderSuccessDataCollection;
    }
    
    public function cancelMyOrder($orderId, $customerId)
    {
        $order = $this->orderRepository->get($orderId);
        
        if($customerId != $order->getCustomerId())
        {
           throw new LocalizedException(__('Unauthorized Customer for this Order'));
        }
        
        if ((bool)$order->cancel()) 
        {
        $this->orderRepository->save($order);
        return true;
        }       
        return false;
    }
    
    
}
