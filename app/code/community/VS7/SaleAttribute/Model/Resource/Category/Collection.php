<?php

class VS7_SaleAttribute_Model_Resource_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vs7_saleattribute/category');
    }
}