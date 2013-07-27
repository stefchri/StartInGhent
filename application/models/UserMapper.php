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
        $data = array('firstname'          => $user->getFirstname(),
                      'surname'            => $user->getSurname(),
                      'email'              => $user->getEmail(),
                      'username'           => $user->getUsername(),
                      'password'           => $user->getPassword(),
                      'gender'             => $user->getGender(),
                      'description'        => $user->getDescription(),
                      'website'            => $user->getWebsite(),
                      'createddate'        => $user->getCreateddate(),
                      'modifieddate'       => $user->getModifieddate(),
                      'deleteddate'        => $user->getDeleteddate(),
                      'lastloggedindate'   => $user->getLastloggedindate(),
                      'activationkey'      => $user->getActivationkey(),
                      'activationdate'     => $user->getActivationdate(),
                      'avatar'             => $user->getAvatar(),
                      'answers'            => $user->getAnswers(),
        );

        if (null === $user->getId()) {
            return $this->_dbTable->insert($data);
        } else {
            $data['user_id'] = $user->getId();
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
                                    'firstname'         => 'firstname' ,
                                    'surname'           => 'surname',           
                                    'email'             => 'email',
                                    'username'          => 'username',
                                    'password'          => 'password',
                                    'gender'            => 'gender',
                                    'description'       => 'description',
                                    'website'           => 'website',
                                    'createddate'       => 'createddate',
                                    'modifieddate'      => 'modifieddate',
                                    'deleteddate'       => 'deleteddate',
                                    'lastloggedindate'  => 'lastloggedindate',
                                    'activationkey'     => 'activationkey',
                                    'activationdate'    => 'activationdate',
                                    'avatar'            => 'avatar',
                                    'answers'           => 'answers',
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
                                    'firstname'         => 'firstname' ,
                                    'surname'           => 'surname',           
                                    'email'             => 'email',
                                    'username'          => 'username',
                                    'password'          => 'password',
                                    'gender'            => 'gender',
                                    'description'       => 'description',
                                    'website'           => 'website',
                                    'createddate'       => 'createddate',
                                    'modifieddate'      => 'modifieddate',
                                    'deleteddate'       => 'deleteddate',
                                    'lastloggedindate'  => 'lastloggedindate',
                                    'activationkey'     => 'activationkey',
                                    'activationdate'    => 'activationdate',
                                    'avatar'            => 'avatar',
                                    'answers'           => 'answers',
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
            $values['id'                ] = $row['user_id'         ];
            $values['surname'           ] = $row['surname'         ];
            $values['firstname'         ] = $row['firstname'       ];
            $values['email'             ] = $row['email'           ];
            $values['username'          ] = $row['username'        ];
            $values['password'          ] = $row['password'        ];
            $values['gender'            ] = $row['gender'          ];
            $values['description'       ] = $row['description'     ];
            $values['website'           ] = $row['website'         ];
            $values['createddate'       ] = $row['createddate'     ];
            $values['modifieddate'      ] = $row['modifieddate'    ];
            $values['deleteddate'       ] = $row['deleteddate'     ];
            $values['lastloggedindate'  ] = $row['lastloggedindate'];
            $values['activationkey'     ] = $row['activationkey'   ];
            $values['activationdate'    ] = $row['activationdate'  ];
            $values['avatar'            ] = $row['avatar'          ];       
            $values['answers'           ] = $row['answers'         ];       
           
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