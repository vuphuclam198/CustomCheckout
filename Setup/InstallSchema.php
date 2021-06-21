<?php
namespace AHT\CustomCheckout\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $attribute = [
            'delivery_date' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                'nullable' => false,
                'comment' => 'delivery date'
            ],
            'delivery_comment' =>[
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'nullable' => 'true',
            'length' => '255',
            'comment' => 'delivery comment'
            ]
        ];

        foreach ($attribute as $key => $value) {    
            $installer->getConnection()->addColumn(
                $installer->getTable('sales_order'),
                $key,
                $value
            );

            $installer->getConnection()->addColumn(
                $installer->getTable('quote'),
                $key,
                $value
            );
        }
        $installer->endSetup();
    }
} 

