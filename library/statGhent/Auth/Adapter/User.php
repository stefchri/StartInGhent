<?php

class statGhent_Auth_Adapter_User extends Zend_Auth_Adapter_DbTable
{
    
    public function __construct($username, $password)
    {
        parent::__construct();
        $this->setTableName('users') 
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setIdentity($username)
                ->setCredential($password)
                
                //->where('activationdate IS NOT NULL')
                //->where('deleteddate IS NULL')
        ;
    }
}