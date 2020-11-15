<?php
$installer = $this;
$installer->startSetup();

$connection = $installer->getConnection();

$tableName = $installer->getTable('vs7_saleattribute/category');
$columnName = 'category_name';

if ($connection->tableColumnExists($tableName, $columnName) === false) {
    $installer->run("
ALTER TABLE `{$this->getTable('vs7_saleattribute/category')}` ADD `{$columnName}` TEXT NOT NULL;
");
}

$installer->endSetup();