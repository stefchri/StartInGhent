<?php
/**
 * @author Stefaan Christiaens <stefaan.ch@gmail.com>
 */
class Api_DatasetController extends REST_Controller
{
    /**
     * Get all the datasets
     */
    public function indexAction()
    {
        $l = new statGhent_DataAdapter();
        $db = $l->getConnection();
        
        $result = $db->fetchAll(
            'SELECT * FROM datasets'
        );
        //Zend_Debug::dump($result);exit();
        if (empty($result)) {
            $this->view->message = "No datasets found.";
        }
        //Zend_Debug::dump($result);exit();
        foreach ($result as $key => $l) {
            $json = $l["value"];
            $jsonbetter = json_decode($json);
            unset($l["value"]);
            $l["value"] = $jsonbetter;
            unset($result[$key]);
            $result[$key] = $l;
        }
        
        
        $this->view->datasets = $result;
        $this->_response->ok();
    }
    
    /**
     * Get the headers for the GET command, no body
     */
    public function headAction()
    {
        $this->_response->ok();
    }

    /**
     * Get a single dataset by id
     */
    public function getAction()
    {
        $id = $this->_getParam('id', 0);
        
        $l = new statGhent_DataAdapter();
        $db = $l->getConnection();
        
        $sql = 'SELECT * FROM datasets where dataset_id =:id';
        $stmnt = $db->prepare($sql);
        //Zend_Debug::dump($stmnt);exit();
        $vals = array(":id" => $id);  
        $stmnt->_execute($vals);
        
        $result = $stmnt->fetch();
        //Zend_Debug::dump($result);exit();
        if (empty($result)) {
            $this->view->message = "No dataset found with provided id.";
        }  else {
            //Zend_Debug::dump($result);exit();
            $json = $result["value"];
            $jsonbetter = json_decode($json);
            unset($result["value"]);
            $result["value"] = $jsonbetter;
            $this->view->dataset = $result;
        }
        
        $this->_response->ok();
    }
}