<?php
namespace Mager\JoinerTester\Setup;
class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $this->upgrade002($installer, $context);
        }
        $installer->endSetup();
    }

    protected function upgrade002(\Magento\Framework\Setup\SchemaSetupInterface $installer, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        
        $installer->getConnection()->dropTable('mager_joinertester_product');

        $table = $installer->getConnection()->newTable(
            $installer->getTable('mager_joinertester_product')
        )->addColumn(
            'mager_joinertester_product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
            'Entity ID'
        )->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => true, 'unsigned' => true],
            'Magento Product ID'
        )->addColumn(
            'needs_sync',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [ 'nullable' => true, ],
            'Needs Sync'
        );
        $installer->getConnection()->createTable($table);
    }
}
