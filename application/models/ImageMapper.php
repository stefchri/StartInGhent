<?php
/***
 * 
 * 
 ***/

class Application_Model_ImageMapper
{
    protected $_dbTable;

    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Images();
    }

    /**
     *
     * @param Application_Model_Image $image
     */
    public function save(Application_Model_Image $image)
    {
        $data = array('image_mimetype'  => $image->getMimeType(),
                      'image_image'     => $image->getImage(),
        );

        if (null === $image->getId()) {
            return $this->_dbTable->insert($data);
            
        } else {
            $data['image_id'] = $image->getId();
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
                                    'mimetype' =>  'image_mimetype' ,
                                    'image'    =>  'image_image' ,
                                    )
                        )
                        ->where('image_id = :id')
                        ->bind(array(':id' => $id))
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
        $images = $this->_toObjects($rowset);

        return $images;
    }

    /**
     * Convert row to object.
     *
     * @param Zend_Db_Table_Row_Abstract $row
     * @return Application_Model_Image
     */
    protected function _toObject(Zend_Db_Table_Row_Abstract $row = null)
    {
        $values = array();
        if ($row) {
            $values['id'        ] = $row['image_id'       ];
            $values['mimetype'  ] = $row['image_mimetype' ];
            $values['image'     ] = $row['image_image'    ];
            
        }

        return $image = new Application_Model_Image($values);
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