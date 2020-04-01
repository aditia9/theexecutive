<?php

namespace Hypework\BanktransferConfirmation\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'bank_name',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Bank Name'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'account_number',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Holder Account Number'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'transfer_amount',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Transfer Amount'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'bank_recipient',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Bank Recipient'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'transfer_method',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Transfer Method'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'transfer_date',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Transfer Date'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'attachment',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Attachment Proof'
                    ]
            );
        }

        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'name_who_transfer',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Name Who Transfer'
                    ]
            );
            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order'),
                    'email_who_transfer',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => false,
                        'comment' => 'Email Who Transfer'
                    ]
            );
        }

        $setup->endSetup();
    }
}