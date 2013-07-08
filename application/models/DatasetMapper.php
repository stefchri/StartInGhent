<?php
/***
 * 
 * 
 ***/

class Application_Model_DatasetMapper
{
    protected $_dbTable;

    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Datasets();
    }

    /**
     *
     * @param Application_Model_Dataset $dataset
     */
    public function save(Application_Model_Dataset $dataset)
    {
        $data = array('dataset_name'        => $dataset->getName(),
                      'dataset_value'       => $dataset->getValue(),
                      'dataset_modifieddate'=> $dataset->getModifieddate(),
        );

        if (null === $dataset->getId()) {
            return $this->_dbTable->insert($data);
        } else {
            $data['dataset_id'] = $dataset->getId();
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
                                    'name'          =>  'dataset_name' ,
                                    'value'         =>  'dataset_value' ,
                                    'modifieddate'  =>  'dataset_modifieddate' ,
                                    )
                        )
                        ->where('dataset_id = :id')
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
        $datasets = $this->_toObjects($rowset);

        return $datasets;
    }

    /**
     * Convert row to object.
     *
     * @param Zend_Db_Table_Row_Abstract $row
     * @return Application_Model_Dataset $dataset
     */
    protected function _toObject(Zend_Db_Table_Row_Abstract $row = null)
    {
        $values = array();
        if ($row) {
            $values['id'            ] = $row['dataset_id'           ];
            $values['name'          ] = $row['dataset_name'         ];
            $values['value'         ] = $row['dataset_value'        ];
            $values['modifieddate'  ] = $row['dataset_modifieddate' ];
            
        }

        return $dataset = new Application_Model_Dataset($values);
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