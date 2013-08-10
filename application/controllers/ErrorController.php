<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $this->view->headTitle("Error");
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = "The page you requested does not exist.";
                $this->renderScript('error/error_404.phtml');
                break;
            default:
                // application error
                if ($this->getResponse()->getHttpResponseCode() != 401) {
                    $this->getResponse()->setHttpResponseCode(500);
                }
                if ($errors->exception->getMessage() == "ACL") {
                    $this->getResponse()->setHttpResponseCode(401);
                    $this->renderScript('error/error_401.phtml');
                    break;
                }
                $priority = Zend_Log::CRIT;
                $this->view->exception = $errors->exception;
                $this->view->request = $errors->request;
                $this->renderScript('error/error_500.phtml');
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

