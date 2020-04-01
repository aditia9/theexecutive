<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Ranosys\Notification\Ui\Component\Listing\Grid\Column;
 
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
 
/**
 * Shows department name in admin grids instead of department id
 */
class PublishStatus extends Column
{
    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;
 
    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;
 
    protected $productFactory;  
    protected $notificationFactory;  
    protected $status;
    
 
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
       \Ranosys\Notification\Model\Option $statusResolver,
       \Ranosys\Notification\Model\Notification $notificationFactory,
        array $components = [],
        array $data = []
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->statusResolver = $statusResolver;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
         if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
               $publish_status = $item['publish_status'];
               $options = $this->statusResolver->getPublishStatusArray();
               $item['publish_status'] = $options[$publish_status];
            }
        }

        return $dataSource;
    }

}