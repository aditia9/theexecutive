<?php
namespace Ranosys\SalesRule\Setup;
 
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ){
        if (version_compare($context->getVersion(), '1.0.5') < 0) {
            
            $installer = $setup;
            $installer->startSetup();
            
            $installer->getConnection()->addColumn(
            $installer->getTable('salesrule'),
            'area_code',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'Area Code',
                'default' => '0',
            ]
            );
            
 
        $installer->endSetup();
        }
    }
}