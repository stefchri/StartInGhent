<?php
/***
 *
 * @author     Olivier Parent adapted by Stefaan Christiaens 7 Tom Van humbeek
 * @copyright  Copyright (c) 2012 Artevelde University College Ghent
 */

class statGhent_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    protected $_acl;

    public function __construct()
    {
        $session = new Zend_Session_Namespace('statGhent_acl');

        if ( isset($session->acl) ) {
            $this->_acl = $session->acl;
        } else
            $this->_acl = new statGhent_Acl();
            $session->acl = $this->_acl;
        
    }

    /**
     * @param Zend_Controller_Request_Abstract $request
     * @return boolean
     * @throws Zend_Exception
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);

        $auth = Zend_Auth::getInstance();
        $role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : statGhent_Acl::ROLE_GUEST; // PHP 5.4!

        $resource = statGhent_Acl::getResource($request->getControllerName(),
                                         $request->getModuleName());
        $privilege = statGhent_Acl::getPrivilege($request->getActionName());
        if ($this->_acl->isAllowed($role, $resource, $privilege)) {
            return true;
        }
        throw new Zend_Exception("Access violation for Role '{$role}': no access to resource '{$resource}' for privilege '{$privilege}'");
    }
}