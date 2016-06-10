<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->getConnection()->modifyColumn($installer->getTable('request4quote/quote'), 'r4q_status',array(
    'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => true,
));

$installer->endSetup();
