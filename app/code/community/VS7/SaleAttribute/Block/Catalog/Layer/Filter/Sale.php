<?php

class VS7_SaleAttribute_Block_Catalog_Layer_Filter_Sale extends Mage_Catalog_Block_Layer_Filter_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->_filterModelName = 'vs7_saleattribute/catalog_layer_filter_sale';
    }

    public function getAttributeModel()
    {
        $model = new Varien_Object();
        $model->setAttributeCode('sale');

        return $model;
    }
}