<?php
/**
 * @category  Apptrian
 * @package   Apptrian_FacebookCatalog
 * @author    Apptrian
 * @copyright Copyright (c) Apptrian (http://www.apptrian.com)
 * @license   http://www.apptrian.com/license Proprietary Software License EULA
 */
 
namespace Apptrian\FacebookCatalog\Cron;

class Generate
{
    /**
     * @var \Apptrian\FacebookCatalog\Helper\Data
     */
    public $helper;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    public $logger;
    
    /**
     * Constructor
     *
     * @param \Apptrian\FacebookCatalog\Helper\Data $helper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Apptrian\FacebookCatalog\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
    }
    
    /**
     * Cron method for executing optmization process.
     */
    public function execute()
    {
        $cronJobEnabled = (int) $this->helper->getConfig(
            'apptrian_facebookcatalog/cron/enabled'
        );
        
        if ($cronJobEnabled) {
            try {
                $this->helper->generate();
            } catch (\Exception $e) {
                $this->logger->debug(
                    'Facebook Catalog Cron: Product Feed generation failed.'
                );
                $this->logger->critical($e);
            }
        }
    }
}
