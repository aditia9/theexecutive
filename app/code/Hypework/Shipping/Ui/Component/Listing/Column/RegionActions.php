<?php
namespace Hypework\Shipping\Ui\Component\Listing\Column;

use \Hypework\Shipping\Model\ResourceModel\Region as regionResourceModel;

class RegionActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path  to edit
     *
     * @var string
     */
    const FAQ_CATEGORY_URL_PATH_EDIT = 'hypeworkshipping/region/edit';
    /**
     * Url path to delete
     *
     * @var string
     */
    const FAQ_CATEGORY_URL_PATH_DELETE = 'hypeworkshipping/region/delete';
    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder
     */
    protected $actionUrlBuilder;
    /**
     * constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder $actionUrlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
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
                $name = $this->getData('name');
                if (isset($item['region_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::FAQ_CATEGORY_URL_PATH_EDIT, ['region_id' => $item['region_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::FAQ_CATEGORY_URL_PATH_DELETE, ['region_id' => $item['region_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.default_name }"'),
                            'message' => __('Are you sure you wan\'t to delete this Regions?')
                        ]
                    ];
                }
                // if (isset($item['identifier'])) {
                //     $item[$name]['preview'] = [
                //         'href' => $this->actionUrlBuilder->getUrl(faqResourceModel::FAQ_CATEGORY_PATH.'/'.$item['identifier'].faqResourceModel::FAQ_DOT_HTML, isset($item['store_id']) ? $item['store_id'] : null, null),
                //         'label' => __('View')
                //     ];
                // }
            }
        }
        return $dataSource;
    }
}