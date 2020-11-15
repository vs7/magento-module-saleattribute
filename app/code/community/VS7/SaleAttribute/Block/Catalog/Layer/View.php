<?php

class VS7_SaleAttribute_Block_Catalog_Layer_View extends Amasty_Shopby_Block_Catalog_Layer_View
{
    /**
     * State block name
     *
     * @var string
     */
    protected $_saleBlockName = 'vs7_saleattribute/catalog_layer_filter_sale';

    /**
     * Prepare child blocks
     *
     * @return Mage_Catalog_Block_Layer_View
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $saleBlock = $this->getLayout()->createBlock($this->_saleBlockName)
            ->setLayer($this->getLayer())
            ->init();

        $this->setChild('sale_filter', $saleBlock);

        return $this;
    }

    /**
     * Get all layer filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = parent::getFilters();

        $category = Mage::registry('current_category');
        if ($category) {
            $categoryId = $category->getId();
            if ($categoryId) {
                $excludedCategories = array_map('trim', explode(',', Mage::getStoreConfig('vs7_saleattribute/general/categories_limits')));
                if (!empty($excludedCategories) && in_array($categoryId, $excludedCategories)) {
                    return $filters;
                }
            }
        }

        if (($saleFilter = $this->_getSaleFilter())) {
            array_unshift($filters, $saleFilter);
        }

        return $filters;
    }

    /**
     * Get sale filter block
     *
     * @return Mage_Catalog_Block_Layer_Filter_Sale
     */
    protected function _getSaleFilter()
    {
        return $this->getChild('sale_filter');
    }
}