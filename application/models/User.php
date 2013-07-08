<?php

class Application_Model_User
{
        
    /**
     * User id
     *
     * @var bigint
     */
    protected $_id;
    /**
     * User firstname
     *
     * @var string
     */
    protected $_firstname;
    /**
     * User surname
     *
     * @var string
     */
    protected $_surname;
    /**
     * User email
     *
     * @var string
     */
    protected $_email;
    /**
     * User gender
     *
     * @var enum('m','f')
     */
    protected $_sex;
    /**
     * User description
     *
     * @var string
     */
    protected $_description;
    /**
     * User website
     *
     * @var string
     */
    protected $_website;
    /**
     * User createddate
     *
     * @var datetime
     */
    protected $_createddate;
    /**
     * User modifieddate
     *
     * @var datetime
     */
    protected $_modifieddate;
    /**
     * User deleteddate
     *
     * @var datetime
     */
    protected $_deleteddate;
    /**
     * User lastloggedindate
     *
     * @var datetime
     */
    protected $_lastloggedindate;
    /**
     * User activationkey
     *
     * @var string
     */
    protected $_activationkey;
    /**
     * User activationdate
     *
     * @var datetime
     */
    protected $_activationdate;
    /**
     * User image
     *
     * @var BIGINT
     */
    protected $_image;
    /**
     * User name
     *
     * @var string
     */
    protected $_username;

    /**
     * User Password
     *
     * @var string
     */
    protected $_password;
    /**
     * User Password
     *
     * @var string
     */
    protected $_passwordraw;

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
    

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Setter for passwordraw form field that hashes the password string.
     *
     * @param string $password
     */
    public function setPasswordraw($password)
    {
        $this->_password = statGhent_Utility::hash($password);
    }

    /**
     * Dummy password repeat form field
     *
     * @param type $password
     */
    public function setPasswordcheck($password)
    {
        // Do nothing
    }
    
    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getFirstname() {
        return $this->_firstname;
    }

    public function setFirstname($firstname) {
        $this->_firstname = $firstname;
    }

    public function getSurname() {
        return $this->_surname;
    }

    public function setSurname($surname) {
        $this->_surname = $surname;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($email) {
        $this->_email = $email;
    }

    public function getSex() {
        return $this->_sex;
    }

    public function setSex($sex) {
        $this->_sex = $sex;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setDescription($description) {
        $this->_description = $description;
    }

    public function getWebsite() {
        return $this->_website;
    }

    public function setWebsite($website) {
        $this->_website = $website;
    }

    public function getCreateddate() {
        return $this->_createddate;
    }

    public function setCreateddate($createddate) {
        $this->_createddate = $createddate;
    }

    public function getModifieddate() {
        return $this->_modifieddate;
    }

    public function setModifieddate($modifieddate) {
        $this->_modifieddate = $modifieddate;
    }

    public function getDeleteddate() {
        return $this->_deleteddate;
    }

    public function setDeleteddate($deleteddate) {
        $this->_deleteddate = $deleteddate;
    }

    public function getLastloggedindate() {
        return $this->_lastloggedindate;
    }

    public function setLastloggedindate($lastloggedindate) {
        $this->_lastloggedindate = $lastloggedindate;
    }

    public function getActivationkey() {
        return $this->_activationkey;
    }

    public function setActivationkey($activationkey) {
        $this->_activationkey = $activationkey;
    }

    public function getActivationdate() {
        return $this->_activationdate;
    }

    public function setActivationdate($activationdate) {
        $this->_activationdate = $activationdate;
    }

    public function getImage() {
        return $this->_image;
    }

    public function setImage($image) {
        $this->_image = $image;
    }
    
   

    
}