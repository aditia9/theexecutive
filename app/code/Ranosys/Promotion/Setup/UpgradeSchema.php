<?php
namespace Ranosys\Promotion\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
//        if (version_compare($context->getVersion(), "1.0.0", "<")) {
//        
//        }
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
          $installer->getConnection()->addColumn(
                $installer->getTable('home_promotions'),
                'promotion_store',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'comment' => 'Promotion Store'
                ]
            );
        }
        $installer->endSetup();
    }
}