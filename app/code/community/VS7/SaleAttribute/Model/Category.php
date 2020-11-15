<?php

class VS7_SaleAttribute_Model_Category extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vs7_saleattribute/category');
    }
}