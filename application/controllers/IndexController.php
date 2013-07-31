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
    }

    public function aboutAction()
    {
        // action body
    }


}



