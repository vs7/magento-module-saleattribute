<?php

$this->startSetup();
$this->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('vs7_saleattribute/category')} (
  `category_id` int(11) unsigned NOT NULL,
  `page_title` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$this->endSetup();