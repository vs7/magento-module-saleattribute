<?php

class VS7_SaleAttribute_Model_Catalog_Layer_Filter_Sale extends Mage_Catalog_Model_Layer_Filter_Abstract
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_requestVar = 'sale';
    }

    /**
     * Apply sale filter to layer
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Mage_Core_Block_Abstract $filterBlock
     * @return  Mage_Catalog_Model_Layer_Filter_Sale
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        $filter = (int)$request->getParam($this->getRequestVar());
        if (!$filter || Mage::registry('sale_filter')) {
            return $this;
        }

        $select = $this->getLayer()->getProductCollection()->getSelect();
        /* @var $select Zend_Db_Select */

        $select->where('price_index.final_price < price_index.price');
        $stateLabel = Mage::helper('vs7_saleattribute')->__('Sale');

        $state = $this->_createItem(
            $stateLabel, $filter
        )->setVar($this->_requestVar);
        /* @var $state Mage_Catalog_Model_Layer_Filter_Item */

        $this->getLayer()->getState()->addFilter($state);

        Mage::register('sale_filter', true);

        $this->_setPageParams();

        return $this;
    }

    private function _setPageParams()
    {
        $head = Mage::app()->getLayout()->getBlock('head');
        if ($head) {
            if ($currentCategory = $this->getLayer()->getCurrentCategory()) {
                if($categoryId = $currentCategory->getId()) {
                    $saleCategory = Mage::getModel('vs7_saleattribute/category')
                        ->load($categoryId);
                    if ($saleCategory->getId()) {
                        if ($title = $saleCategory->getPageTitle()) {
                            $head->setTitle($title);
                        }
                        if ($description = $saleCategory->getMetaDescription()) {
                            $head->setDescription($description);
                        }
                        if ($keywords = $saleCategory->getMetaKeywords()) {
                            $head->setKeywords($keywords);
                        }
                        if ($categoryName = $saleCategory->getCategoryName()) {
                            $currentCategory->setName($categoryName);
                        }
                    }
                }
            }
        }
    }

    /**
     * Get filter name
     *
     * @return string
     */
    public function getName()
    {
        return Mage::helper('vs7_saleattribute')->__('Sale');
    }

    /**
     * Get data array for building sale filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        $data = array();
        $status = $this->_getCount();
        if (isset($status['yes']) && $status['yes'] > 0) {
            $data[] = array(
                'label' => Mage::helper('vs7_saleattribute')->__('Sale'),
                'value' => 1,
                'count' => isset($status['yes']) ? $status['yes'] : 0,
            );
        }

        return $data;
    }

    protected function _getCount()
    {
        // Clone the select
        $select = clone $this->getLayer()->getProductCollection()->getSelect();
        /* @var $select Zend_Db_Select */

        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);
        $select->reset(Zend_Db_Select::WHERE);

        // Count the on sale and not on sale
        $sql = 'SELECT IF(final_price >= price, "no", "yes") as on_sale, COUNT(*) as count from ('
            . $select->__toString() . ') AS q GROUP BY on_sale';

        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        /* @var $connection Zend_Db_Adapter_Abstract */

        return $connection->fetchPairs($sql);
    }

    protected function _createItem($label, $value, $count = 0)
    {
        return Mage::getModel('catalog/layer_filter_item')
            ->setFilter($this)
            ->setLabel($label)
            ->setValue($value)
            ->setCount($count)
            ->setActive(Mage::registry('sale_filter'));
    }
}
