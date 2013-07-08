<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users'; // WARNING: case sensitive!

    protected $_primary = 'user_id';
}