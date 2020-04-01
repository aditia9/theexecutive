<?php
namespace Hypework\Payment\Block\Frontend\Onepage;

use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\ResourceConnection;

class Success extends Template
{
    protected $session;
    protected $order;
    protected $logger;
    protected $resourceConnection;

    public function __construct(
        Session $session,
        Order $order,
        ResourceConnection $resourceConnection,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->logger = $context->getLogger();
        $this->order = $order;
        $this->resourceConnection = $resourceConnection;
    }

    protected function getOrder()
    {
        return $order = $this->order->loadByIncrementId($this->session->getLastRealOrder()->getIncrementId());
    }

    public function getVaNumber()
    {
        $this->logger->info('===== getVaNumber ===== Start');
        try {
            $order = $this->getOrder();
            $getOrder = $this->resourceConnection
                ->getConnection()->select()->from('hypework_prismalink_va')
                ->where('increment_id=?', $order->getIncrementId())
                ->where('store_id=?', $order->getStoreId());
            $findOrder = $this->resourceConnection->getConnection()->fetchRow($getOrder);

            return $findOrder['account_no'];
        } catch(\Exception $e) {
            $this->logger->info('error : '. $e->getMessage());
        }

        $this->logger->info('===== getVaNumber ===== End');
    }
}
