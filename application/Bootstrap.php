<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initViewHelpers()
    {
        $this->bootstrap('layout'); 
        $view = $this->getResource('layout')->getView();

        $front = $this->getResource('frontController');
        $front->setRequest(new Zend_Controller_Request_Http());

        $view->doctype('HTML5'); 
        $view->headMeta()
            ->setCharset('utf-8')
            ->appendName('viewport', 'width=device-width, initial-scale=1.0')
        ;

        $view
            ->headTitle('StartInGhent', $view->title)
            ->setDefaultAttachOrder('PREPEND')
            ->setSeparator(' | ')
        ;

        $view->headLink() 
            ->appendStylesheet($view->baseUrl('_styles/css/_libs/reset/reset.css'), 'all')
            ->appendStylesheet($view->baseUrl('_styles/css/_libs/bootstrap/bootstrap.css'), 'all')
            ->appendStylesheet($view->baseUrl('_styles/css/_libs/bootstrap/bootstrap-responsive.css'), 'all')
            ->appendStylesheet('http://fonts.googleapis.com/css?family=PT+Sans+Narrow:700', 'all')
            ->appendStylesheet($view->baseUrl('_styles/css/common.css'), 'all')
            ->appendStylesheet($view->baseUrl('_styles/css/main.css'), 'all')
             
             
        ;
        $view->headScript()
            ->appendFile($view->baseUrl('_scripts/_libs/modernizr/modernizr-2.6.2.min.js'));
       

        $view->inlineScript()
            ->appendFile('http://code.jquery.com/jquery-latest.js')
            ->appendFile($view->baseUrl('_scripts/_libs/bootstrap/bootstrap.min.js'))
        ;
    }
    /***
     * initREST
     * 
     * SET UP RESTFUL ROUTES ON API MODULE
     */
    public function _initREST()
    {
        $frontController = Zend_Controller_Front::getInstance();

        // set custom request object
        $frontController->setRequest(new REST_Request);
        $frontController->setResponse(new REST_Response);

        // add the REST route for the API module only
        $restRoute = new Zend_Rest_Route($frontController, array(), array('api'));
        $frontController->getRouter()->addRoute('rest', $restRoute);
    }

}

