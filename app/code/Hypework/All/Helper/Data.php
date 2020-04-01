<?php

namespace Hypework\All\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    protected $_transportBuilder;
    protected $_inlineTranslation;
    protected $_storeManager;

    public function __construct(
            \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
            \Magento\Framework\Translate\Inline\StateInterface $inlineTransaction,
            \Magento\Store\Model\StoreManagerInterface $storeManager
        ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTransaction;
        $this->_storeManager = $storeManager;
    }

    public function sendEmail($templateCode, $fromEmail, $fromName, $toEmail, $templateVars) {
        try {
            $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->_storeManager->getStore()->getId());

            $from = array(
                'email' => $fromEmail,
                'name' => $fromName
            );
            $this->_inlineTranslation->suspend();
            $to = array($toEmail);

            $transport = $this->_transportBuilder->setTemplateIdentifier($templateCode)
                            ->setTemplateOptions($templateOptions)
                            ->setTemplateVars($templateVars)
                            ->setFrom($from)
                            ->addTo($to)
                            ->getTransport();
            $transport->sendMessage();
            $this->_inlineTranslation->resume();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}