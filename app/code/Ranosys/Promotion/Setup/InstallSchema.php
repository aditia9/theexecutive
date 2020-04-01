<?php
/**
* Copyright © 2016 Magento. All rights reserved.
* See COPYING.txt for license details.
*/

namespace Ranosys\Promotion\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
    * {@inheritdoc}
    * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
    */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
          /**
          * Create table 'home_promotions'
          */
          $table = $setup->getConnection()
                ->newTable($setup->getTable('home_promotions'))
                ->addColumn(
                  'promotion_id',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  null,
                  ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                  'Promtoion ID'
                )
                ->addColumn(
                  'promotion_title',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion Title'
                )
                  ->addColumn(
                  'promotion_description',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion Description'
                )
                  ->addColumn(
                  'promotion_type',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion Type'
                )
                  ->addColumn(
                  'promotion_value',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion Value'
                )
                  ->addColumn(
                  'promotion_image',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion image'
                )
                  ->addColumn(
                  'promotion_position',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  255,
                  ['nullable' => false, 'default' => 0],
                    'Promotion Position'
                )
                  ->addColumn(
                   'created_at',
                   \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                   null,
                   ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                   'Created At'
                )
                   ->addColumn(
                  'status',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['nullable' => false, 'default' => ''],
                    'Promotion Status'
                )->setComment("Home Promotions table");
          
                $setup->getConnection()->createTable($table);
    }
}