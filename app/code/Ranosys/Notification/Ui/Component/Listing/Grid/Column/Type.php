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
class Type extends Column
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
    protected $typeResolver;
    
 
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
       \Ranosys\Notification\Model\Option $typeResolver,
       \Ranosys\Notification\Model\Notification $notificationFactory,
        array $components = [],
        array $data = []
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->typeResolver = $typeResolver;
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
               $type = $item['type'];
               $options = $this->typeResolver->getTypeArray(); 
               $item['type'] = $options[$type];
            }
        }

        return $dataSource;
    }

}