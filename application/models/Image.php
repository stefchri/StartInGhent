<?php

class Application_Model_Image
{
    /**
     * Image id
     *
     * @var bigint
     */
    protected $_id;
    /**
     * Image mimetype
     *
     * @var string
     */
    protected $_mimetype;
    /**
     * Image image
     *
     * @var longblob
     */
    protected $_image;
    
   
    /**
     * @param array $values
     */
    public function __construct(array $values = null) {
        if ($values === null) {
            //just construct
        }
        else {
          foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
       }
        
    }

   
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }
     public function getMimetype() {
        return $this->_mimetype;
    }

    public function setMimetype($mimetype) {
        $this->_mimetype = $mimetype;
    }

    public function getImage() {
        return $this->_image;
    }

    public function setImage($image) {
        $this->_image = $image;
    }

            
}