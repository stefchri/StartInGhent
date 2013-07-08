<?php
/***
 * 
 * 
 ***/

class Application_Model_UserMapper
{
    protected $_dbTable;

    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Users();
    }

    /**
     *
     * @param Application_Model_User $user
     */
    public function save(Application_Model_User $user)
    {
        $data = array('user_firstname'          => $user->getFirstname(),
                      'user_surname'            => $user->getSurname(),
                      'user_email'              => $user->getEmail(),
                      'user_username'           => $user->getUsername(),
                      'user_password'           => $user->getPassword(),
                      'user_sex'                => $user->getSex(),
                      'user_description'        => $user->getDescription(),
                      'user_website'            => $user->getWebsite(),
                      'user_createddate'        => $user->getCreateddate(),
                      'user_modifieddate'       => $user->getModifieddate(),
                      'user_deleteddate'        => $user->getDeleteddate(),
                      'user_lastloggedindate'   => $user->getLastloggedindate(),
                      'user_activationkey'      => $user->getActivationkey(),
                      'user_activationdate'     => $user->getActivationdate(),
                      'user_image'              => $user->getImage(),
        );

        if (null === $user->getId()) {
            return $this->_dbTable->insert($data);
        } else {
            $data['user_id'] = $user->getId();
            Zend_Debug::dump($data);
            $this->_dbTable->update($data);
        }
    }

    public function read($id = null)
    {
        $table = $this->_dbTable;

        $select = $table->select()
                        ->from($table,
                               array(
                                    'id'                => 'user_id' ,
                                    'firstname'         => 'user_firstname' ,
                                    'surname'           => 'user_surname',           
                                    'email'             => 'user_email',
                                    'username'          => 'user_username',
                                    'password'          => 'user_password',
                                    'sex'               => 'user_sex',
                                    'description'       => 'user_description',
                                    'website'           => 'user_website',
                                    'createddate'       => 'user_createddate',
                                    'modifieddate'      => 'user_modifieddate',
                                    'deleteddate'       => 'user_deleteddate',
                                    'lastloggedindate'  => 'user_lastloggedindate',
                                    'activationkey'     => 'user_activationkey',
                                    'activationdate'    => 'user_activationdate',
                                    'image'             => 'user_image',
                               )
                        )
                        ->where('user_id = :id')
                        ->bind(array(':id' => $id))
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }
    
    public function readWithvalue($column, $value)
    {
        $table = $this->_dbTable;

        $select = $table->select()
                        ->from($table,
                               array(
                                    'id'                => 'user_id' ,
                                    'firstname'         => 'user_firstname' ,
                                    'surname'           => 'user_surname',           
                                    'email'             => 'user_email',
                                    'username'          => 'user_username',
                                    'password'          => 'user_password',
                                    'sex'               => 'user_sex',
                                    'description'       => 'user_description',
                                    'website'           => 'user_website',
                                    'createddate'       => 'user_createddate',
                                    'modifieddate'      => 'user_modifieddate',
                                    'deleteddate'       => 'user_deleteddate',
                                    'lastloggedindate'  => 'user_lastloggedindate',
                                    'activationkey'     => 'user_activationkey',
                                    'activationdate'    => 'user_activationdate',
                                    'image'             => 'user_image',
                               )
                        )
                        ->where($column .' = :c')
                        ->bind(array(':c' => $value))
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }


    /**
     * @return array
     */
    public function fetchAll()
    {
        $rowset = $this->_dbTable->fetchAll();
        $users = $this->_toObjects($rowset);

        return $users;
    }

    /**
     * Convert row to object.
     *
     * @param Zend_Db_Table_Row_Abstract $row
     * @return Application_Model_User
     */
    protected function _toObject(Zend_Db_Table_Row_Abstract $row = null)
    {
        $values = array();
        if ($row) {
            $values['id'                ] = $row['adm_id'               ];
            $values['surname'           ] = $row['user_surname'         ];
            $values['firstname'         ] = $row['user_firstname'       ];
            $values['email'             ] = $row['user_email'           ];
            $values['username'          ] = $row['user_username'        ];
            $values['password'          ] = $row['user_password'        ];
            $values['sex'               ] = $row['user_sex'             ];
            $values['description'       ] = $row['user_description'     ];
            $values['website'           ] = $row['user_website'         ];
            $values['createddate'       ] = $row['user_createddate'     ];
            $values['modifieddate'      ] = $row['user_modifieddate'    ];
            $values['deleteddate'       ] = $row['user_deleteddate'     ];
            $values['lastloggedindate'  ] = $row['user_lastloggedindate'];
            $values['activationkey'     ] = $row['user_activationkey'   ];
            $values['activationdate'    ] = $row['user_activationdate'  ];
            $values['image'             ] = $row['user_image'           ];       
           
        }

        return $user = new Application_Model_User($values);
    }

    /**
     * Convert rowset to array of objects.
     *
     * @param Zend_Db_Table_Rowset_Abstract $rowset
     * @return array
     */
    protected function _toObjects(Zend_Db_Table_Rowset_Abstract $rowset = null)
    {
        $objects = array();

        if ($rowset) {
            foreach ($rowset as $row) {
                $objects[] = $this->_toObject($row);
            }
        }

        return $objects;
    }
}