<?php

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
        $this->view->datasets = $result;
        $this->_response->ok();
    }

    /**
     * The head action handles HEAD requests; it should respond with an
     * identical response to the one that would correspond to a GET request,
     * but without the response body.
     */
    public function headAction()
    {
        $this->_response->ok();
    }

    /**
     * The get action handles GET requests and receives an 'id' parameter; it
     * should respond with the server resource state of the resource identified
     * by the 'id' value.
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
            $json = $result["value"];
            $jsonbetter = json_decode($json);
            unset($result["value"]);
            $result["value"] = $jsonbetter;
            $this->view->dataset = $result;
        }
        
        $this->_response->ok();
    }
}