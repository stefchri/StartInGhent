<?php

class statGhent_Auth_Adapter_User extends Zend_Auth_Adapter_DbTable
{
    
    public function __construct($username, $password)
    {
        parent::__construct();
        $this->setTableName('users') 
             ->setIdentityColumn('user_username')
             ->setCredentialColumn('user_password')
             ->setIdentity($username)
             ->setCredential($password)
             //->setCredentialTreatment('sha1(?)')
             ->getDbSelect()->where('user_activationdate IS NOT NULL')
             //               ->where('adm_deleted = FALSE')
        ;
        //Zend_Debug::dump($this->getDbSelect()->assemble()); exit;
    }
}