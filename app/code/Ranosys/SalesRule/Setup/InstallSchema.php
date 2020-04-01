<?php
/**
* Copyright © 2016 Magento. All rights reserved.
* See COPYING.txt for license details.
*/

namespace Ranosys\SalesRule\Setup;
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
          * Create table 'cart_rule_area'
          */
          $table = $setup->getConnection()
                ->newTable($setup->getTable('cart_rule_area'))
                ->addColumn(
                  'id',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  null,
                  ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                  'ID'
                )
                  ->addColumn(
                  'rule_id',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  255,
                  ['nullable' => false, 'default' => '0'],
                    'Rule Id'
                )
                   ->addColumn(
                  'area_code',
                  \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  255,
                  ['nullable' => false, 'default' => '0'],
                    'Promotion Area Code'
                )->setComment("Cart Rule Area Tabel");
          
                $setup->getConnection()->createTable($table);
    }
}