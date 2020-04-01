<?php

namespace Ranosys\Promotion\Model;

use Ranosys\Promotion\Api\HomePromotionInterface;
use Magento\Framework\Exception\InputException;

/**
 * Implementation class of contract.
 */
class HomePromotion implements HomePromotionInterface
{

    /**
     * store config
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Ranosys\Promotion\Api\Data\GridInterfaceFactory $dataFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Ranosys\Promotion\Model\GridFactory $gridFactory,
        \Magento\Cms\Helper\Page $pageRepository
    ) {
        $this->dataFactory = $dataFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager=$storeManager;
        $this->_modelFactory = $gridFactory;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Return array
     *
     * @api
     * @param 
     * @return \Ranosys\Promotion\Api\Data\PromotiondataInterface[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getHomePromotion() {
        
        $promotionData = [];
        $currentStoreId = $this->_storeManager->getStore()->getId();
        $promotions = $this->_modelFactory->create()->getCollection()->addFieldToFilter('status', 1)->addFieldToFilter('promotion_store', array(array('finset'=> array('0')),array('finset'=> array($currentStoreId))))->setOrder('promotion_position','ASC');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."home_promotion";
        
        if(!$promotions->count()){
            throw new InputException(__('No Promotions Found'));
        }

        foreach ($promotions as $promotion)
        {
            $dataModel = $this->dataFactory->create();
            $dataModel->setEntityId($promotion->getPromotionId());
            $dataModel->setTitle($promotion->getPromotionTitle());
            $dataModel->setDescription($promotion->getPromotionDescription());
            $dataModel->setType($promotion->getPromotionType());
            $dataModel->setPosition($promotion->getPromotionPosition());
            $dataModel->setImage($baseUrl.$promotion->getPromotionImage());
            $dataModel->setCreatedAt($promotion->getCreatedAt());
            if($promotion->getPromotionType() == "CMS")
            {
                $cmsId = $promotion->getPromotionValue();
                $page = $this->pageRepository->getPageUrl($cmsId);
                $dataModel->setValue($page);
            }else{
                
                $dataModel->setValue($promotion->getPromotionValue());
            }
            $promotionData[] = $dataModel;
        }
        return $promotionData;
    }

}
