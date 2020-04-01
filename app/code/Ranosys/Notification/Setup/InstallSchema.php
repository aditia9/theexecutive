<?php

namespace Ranosys\Notification\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
                        $installer->getTable('notification_devices')
                )->addColumn(
                        'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
                )->addColumn(
                        'device_type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'Device Type'
                )->addColumn(
                        'registration_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'Registration Id'
                )->addColumn(
                        'device_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'imei id only for android'
                )->addColumn(
                        'store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false], 'Store Id'
                )->addColumn(
                        'customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => true], 'Customer Id'
                )->addColumn(
                        'created_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Created At'
                )->addColumn(
                        'updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Updated At'
                );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
                $installer->getTable('notifications')
            )->addColumn(
                'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
            )->addColumn(
                'alert', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'ALERT'
            )->addColumn(
                'title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'TITLE'
            )->addColumn(
                'description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k', ['nullable' => false], 'DESCRIPTION'
            )->addColumn(
                'store_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'STORE ID'
            )->addColumn(
                'status', \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN, null, ['nullable' => false], 'STATUS'
            )->addColumn(
                'image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'IMAGE'
            )->addColumn(
                'notifications_sent', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => 0], 'No. Of Notification Sent'
            )->addColumn(
                'type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Type'
            )->addColumn(
                'type_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => true], 'Redirection Type Id'
            )->addColumn(
                'redirection_title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Title'
            )->addColumn(
                'notification_type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Notification Type'
            )->addColumn(
                'publish_status', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0], 'Pending/Published/Sent'
            )->addColumn(
                'sent_date', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, [], 'SENT DATE'
            )->addColumn(
                'created_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Created At'
            )->addColumn(
                'updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Updated At'
            );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
                    $installer->getTable('notifications_pending')
            )->addColumn(
                    'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
            )->addColumn(
                    'notification_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false], 'NOTIFICATION ID'
            )->addColumn(
                    'device_type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'DEVICE TYPE'
            )->addColumn(
                    'registration_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'REGISTRATION ID'
            )->addColumn(
                    'device_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'DEVICE ID'
            )->addColumn(
                    'alert', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'ALERT'
            )->addColumn(
                    'title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'TITLE'
            )->addColumn(
                    'message', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k', ['nullable' => false], 'MESSAGE'
            )->addColumn(
                    'customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => true], 'Customer Id'
            )->addColumn(
                    'created_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Created At'
            )->addColumn(
                    'type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Type'
            )->addColumn(
                    'type_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => true], 'Redirection Type Id'
            )->addColumn(
                    'redirection_title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Title'
            )->addColumn(
                    'image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'IMAGE'
            );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
                        $installer->getTable('notifications_delivered')
                )->addColumn(
                        'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
                )->addColumn(
                        'notification_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false], 'NOTIFICATION ID'
                )->addColumn(
                        'sent_status', \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN, 50, ['nullable' => false, 'default' => 0], 'IS READ'
                )->addColumn(
                        'store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false], 'Store Id'
                )->addColumn(
                        'created_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => false], 'Created At'
                )->addColumn(
                        'sent_date', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, [], 'SENT DATE'
                )->addColumn(
                        'type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Type'
                )->addColumn(
                        'type_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => true], 'Redirection Type Id'
                )->addColumn(
                        'redirection_title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'Redirection Title'
                )->addColumn(
                        'image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false], 'IMAGE'
                )->addColumn(
                        'alert', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'ALERT'
                )->addColumn(
                        'title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, ['nullable' => false], 'TITLE'
                )->addColumn(
                        'message', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64k', ['nullable' => false], 'MESSAGE'
                );

        $installer->getConnection()->createTable($table);
        
        $table = $installer->getConnection()->newTable(
                        $installer->getTable('notification_delivered_devices')
                )->addColumn(
                        'id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true], 'Id'
                )->addColumn(
                        'notification_delivered_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => true], 'Customer Id'
                )->addColumn(
                        'device_type', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'Device Type'
                )->addColumn(
                        'device_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'imei id only for android'
                )->addColumn(
                        'registration_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, ['nullable' => false], 'REGISTRATION ID'
                )->addColumn(
                        'customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => true], 'Customer Id'
                )->addColumn(
                        'is_read', \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN, 50, ['nullable' => false, 'default' => 0], 'IS READ'
                )->addColumn(
                        'read_at', \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME, null, ['nullable' => true], 'READ AT'
                );

        $installer->getConnection()->createTable($table);

    }

}
