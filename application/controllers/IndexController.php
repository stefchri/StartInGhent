<?php

class IndexController extends Zend_Controller_Action
{

    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $this->view->headTitle("Home");
        //Do nothing but show some information from view
    }

    public function answerAction()
    {
        $this->view->headTitle("Answer");
        $id=0;
        try{
            $id = $this->_auth->getStorage()->read()['id'];
        }
        catch(Exception $ex)
        {
            //NOT LOGGED IN
        }
        $this->view->id = $id;
        
    }
}