<?php
namespace Hypework\BanktransferConfirmation\Block\Adminhtml\Order\View\Tab;

class BanktransferConfirmation extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
	
	/**
     * Template
     *
     * @var string
     */
    protected $_template = 'order/view/tab/banktransferconfirmation.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Sales\Helper\Admin
     */
    private $adminHelper;

    protected $_orderCollectionFactory;

    protected $_storeManager;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
        $this->adminHelper = $adminHelper;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_storeManager = $storeManager;
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    public function getThisOrder()
    {
        $order = $this->_orderCollectionFactory->create()
            ->addFieldToFilter('increment_id', ['eq' => $this->getOrder()->getRealOrderId()])
            ->getFirstItem();

        return $order;
    }

	/**
     * get confirmation image
     */
    public function getConfirmationImage()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl.'banktransfer_confirmation'.$this->getThisOrder()->getAttachment();
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Bank Transfer Confirmation');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Bank Transfer Confirmation');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        $method = $this->getOrder()->getPayment()->getMethod();

        if ($method == 'banktransfer') {
        	return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Get Tab Class
     *
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax only';
    }

    /**
     * Get Class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->getTabClass();
    }

    /**
     * Get Tab Url
     *
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('banktransferconfirmation/*/confirmation', ['_current' => true]);
    }
}