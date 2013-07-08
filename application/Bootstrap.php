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

        $view->headTitle($view->title, 'PREPEND')
             ->setDefaultAttachOrder('PREPEND')
             ->setSeparator(' | ')
        ;

        $view->headLink() 
             ->appendStylesheet($view->baseUrl('_styles/css/_libs/reset/reset.css'), 'all')
             ->appendStylesheet($view->baseUrl('_styles/css/common.css'), 'all')
             ->appendStylesheet($view->baseUrl('_styles/css/main.css'), 'screen,projection')
             ->appendStylesheet($view->baseUrl('_styles/css/tablet.css'), 'all and (min-width: 481px) and (max-width: 1024px)')
             ->appendStylesheet($view->baseUrl('_styles/css/_libs/bootstrap/bootstrap.css'), 'all and (min-width: 481px) and (max-width: 1024px)')
             ->appendStylesheet($view->baseUrl('_styles/css/mobile.css'), 'all and (max-width: 481px)')
             ->appendStylesheet($view->baseUrl('_styles/css/_libs/jqmobile/jquery.mobile-1.2.0.min.css'), 'all and (max-width: 481px)')
             
        ;
        $view->headScript()
                ->appendFile($view->baseUrl('_scripts/_libs/modernizr/modernizr-2.6.2.min.js'));
       

        $view->inlineScript()
             ->appendFile('http://code.jquery.com/jquery-latest.js')
             ->appendFile($view->baseUrl('_scripts/_libs/jqmobile/jquery.mobile-1.2.0.min.js'))
             ->appendFile($view->baseUrl('_scripts/_libs/bootstrap/bootstrap.min.js'))
             ->appendFile($view->baseUrl('_scripts/js/geolocation.js'))
             ->appendFile($view->baseUrl('_scripts/js/statGhent.js'))
             ->appendFile($view->baseUrl('_scripts/js/loadData.js'))
        ;
    }

}

