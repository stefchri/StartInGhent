<?php

class Application_Model_DbTable_Datasets extends Zend_Db_Table_Abstract
{
    protected $_name = 'datasets'; // WARNING: case sensitive!

    protected $_primary = 'dataset_id';
}