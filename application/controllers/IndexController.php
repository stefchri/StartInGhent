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
        //Do nothing but show some information from view
    }

    public function answerAction()
    {
        // action body
    }


}

