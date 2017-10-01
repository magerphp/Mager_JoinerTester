<?php
namespace Mager\JoinerTester\Setup;
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        //START: install stuff
        //END:   install stuff
        
        //START table setup
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mager_joinertester_product')
        )->addColumn(
            'mager_joinertester_product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ],
            'Entity ID'
        )->addColumn(
            'needs_sync',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [ 'nullable' => true, ],
            'Needs Sync'
        );
        $installer->getConnection()->createTable($table);
        //END   table setup
        
        $installer->endSetup();
    }
}
