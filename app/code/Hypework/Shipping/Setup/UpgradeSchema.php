<?php

namespace Hypework\Shipping\Setup;
 
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    private $_eavSetupFactory;

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        //handle all possible upgrade versions
 
        // if(!$context->getVersion()) {
            //no previous version found, installation, InstallSchema was just executed
            //be careful, since everything below is true for installation !
        // }
 
        if (version_compare($context->getVersion(), '0.0.5') < 0) {
            $setup->getConnection()->changeColumn(
            $setup->getTable('quote_address'),
               'city',
               'city',
               [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255
               ]
              );
        }       
 
        $setup->endSetup();
    }
}