<?php

class VS7_SaleAttribute_Model_Resource_Category extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('vs7_saleattribute/category', 'category_id');
        $this->_isPkAutoIncrement = false;
    }
}