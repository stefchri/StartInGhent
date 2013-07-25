<?php
/**
 * Description of DataAdapter
 *
 * @author Stefaan Christiaens
 */
class statGhent_DataAdapter
{
    private $_db = null;
    
    public function __construct() {
        if($this->_db == null)
        {
            $_db = $this->_getInstance();
        }
    }
    
    public function getConnection()
    {
        return $this->_db;
    }
    
    private function _getInstance()
    {
//        $options = array(
//            Zend_Db::ALLOW_SERIALIZATION => false
//        );
        
        $frontController = Zend_Controller_Front::getInstance();
        $options = new Zend_Config($frontController->getParam('bootstrap')->getOptions(), true);

        $resources = $options->get('resources', false);
        $data = $resources->db->params;
        $params = array(
            'host'           => $data->host,
            'username'       => $data->username,
            'password'       => $data->password,
            'dbname'         => $data->dbname,
//          'options'        => $options
        );

        $this->_db = Zend_Db::factory($resources->db->adapter, $params);
    }
}
