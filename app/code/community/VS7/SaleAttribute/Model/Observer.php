<?php

class VS7_SaleAttribute_Model_Observer
{
    public function addTab($observer)
    {
        $tabs = $observer->getTabs();
        if ($tabs) {
            $tabs->addTab('sale', array(
                'label'     => Mage::helper('vs7_saleattribute')->__('Sale'),
                'content'   => $tabs->getLayout()->createBlock('vs7_saleattribute/adminhtml_catalog_category_tab_sale', 'category.sale')->toHtml(),
            ));
        }
    }

    public function saveCategory($observer)
    {
        $category = $observer->getCategory();
        if (empty($category) || $category->getId() == null) {
            return;
        }
        $request = $observer->getRequest();
        if (empty($request)) {
            return;
        }
        $data = $request->getPost();
        if (empty($data) || !isset($data['vs7_saleattribute'])) {
            return;
        }

        Mage::getModel('vs7_saleattribute/category')
            ->setData($data['vs7_saleattribute'])
            ->setId($category->getId())
            ->save();
    }
}