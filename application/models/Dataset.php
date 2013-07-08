<?php

class Application_Model_Dataset
{
    /**
     * Image id
     *
     * @var bigint
     */
    protected $_id;
    /**
     * Image name
     *
     * @var string
     */
    protected $_name;
    /**
     * Image value
     *
     * @var json string
     */
    protected $_value;
    /**
     * Image modifieddate
     *
     * @var datetime
     */
    protected $_modifieddate;
    
    /**
     * @param array $values
     */
    public function __construct(array $values) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }
    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getValue() {
        return $this->_value;
    }

    public function setValue($value) {
        $this->_value = $value;
    }

    public function getModifieddate() {
        return $this->_modifieddate;
    }

    public function setModifieddate($modifieddate) {
        $this->_modifieddate = $modifieddate;
    }


            
}