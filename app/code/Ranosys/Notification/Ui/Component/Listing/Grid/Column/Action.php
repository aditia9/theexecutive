<?php

namespace Ranosys\Notification\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    /** Url path */
    const ROW_EDIT_URL = 'notification/notification/addrow';
    const ROW_PUBLISH_URL = 'notification/notification/publish';
    const ROW_SEND_URL = 'notification/notification/sendnotification';
    /** @var UrlInterface */
    protected $urlBuilder;

    protected $notificationFactory;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Ranosys\Notification\Model\NotificationFactory $notificationFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->notificationFactory = $notificationFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $notification = $this->notificationFactory->create()->load($item['id']);
                    if($notification->canEdit()){
                        $item[$name]['edit'] = [
                            'href' => $this->urlBuilder->getUrl(
                                self::ROW_EDIT_URL,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Edit'),
                        ];
                    }
                    
                    if($notification->canSend()) {
                        $item[$name]['send'] = [
                            'href' => $this->urlBuilder->getUrl(
                                self::ROW_SEND_URL,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Send'),
                            'confirm' => [
                                'title' => __('Send "${ $.$data.title }"'),
                                'message' => __('Are you sure you want to send "${ $.$data.title }" notification?')
                            ]
                        ];
                    }
                    
                    if($notification->canPublish()) {
                        $item[$name]['publish'] = [
                            'href' => $this->urlBuilder->getUrl(
                                self::ROW_PUBLISH_URL,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Publish'),
                            'confirm' => [
                                'title' => __('Publish "${ $.$data.title }"'),
                                'message' => __('Are you sure you want to publish "${ $.$data.title }" notification?')
                            ]
                        ];
                    }
                }
            }
        }

        return $dataSource;
    }
}
