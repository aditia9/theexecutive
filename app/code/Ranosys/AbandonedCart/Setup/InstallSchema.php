<?php

namespace Ranosys\AbandonedCart\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
                        $installer->getTable('abandoned_cart_mail')
                )->addColumn(
                        'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
                )->addColumn(
                        'cart_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => true], 'Cart Id'
                )->addColumn(
                        'sent_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Sent At'
                );

        $installer->getConnection()->createTable($table);
    }

}
