<?php

class VS7_SaleAttribute_Block_Adminhtml_Catalog_Category_Tab_Sale extends Mage_Adminhtml_Block_Catalog_Form
{

    protected $_category;

    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = Mage::registry('category');
        }
        return $this->_category;
    }

    protected function _prepareForm() {
        $module = 'vs7_saleattribute';

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('fieldset_' . $module, array(
            'legend'    => Mage::helper('vs7_saleattribute')->__('Sale Page Params'),
            'class'     => 'fieldset-wide',
        ));

        $fieldset->addField($module . '_' . 'category_name', 'text', array(
            'name'  => 'category_name',
            'label' => Mage::helper('vs7_saleattribute')->__('Category Name')
        ));

        $fieldset->addField($module . '_' . 'page_title', 'text', array(
            'name'  => 'page_title',
            'label' => Mage::helper('vs7_saleattribute')->__('Page Title')
        ));

        $fieldset->addField($module . '_' . 'meta_keywords', 'textarea', array(
            'name'  => 'meta_keywords',
            'label' => Mage::helper('vs7_saleattribute')->__('Meta Keywords')
        ));

        $fieldset->addField($module . '_' . 'meta_description', 'textarea', array(
            'name'  => 'meta_description',
            'label' => Mage::helper('vs7_saleattribute')->__('Meta Description')
        ));

        if ($category = $this->getCategory()) {
            $categoryId = $category->getId();
            if ($categoryId) {
                $saleCategory = Mage::getModel('vs7_saleattribute/category')
                    ->load($categoryId);
                if ($saleCategory) {
                    $data = $saleCategory->getData();
                    unset($data['category_id']);
                    $prefixedData = array();
                    foreach ($data as $key => $value) {
                        $prefixedData[$module . '_' . $key] = $value;
                    }
                    $form->addValues($prefixedData);
                }
            }
        }

        $form->setFieldNameSuffix($module);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
