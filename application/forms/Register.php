<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        $decorators = array(
            'ViewHelper',
            array('Errors', array ('class' => 'help-inline')),
            array(
                array('inner' => 'HtmlTag'),
                array('tag'   => 'div',
                      'class' => 'controls',
                )
            ),
            array(
                'Label',
                array('placement' => 'prepend',
                      'class'     => 'control-label',
                )
            ),
            array(
                array('outer' => 'HtmlTag'),
                array('tag'   => 'div',
                      'class' => 'control-group')),
        );
        $password = new Zend_Form_Element_Password('passwordraw');
        $password
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-pwd')
                    ->setAttrib('placeholder','Password')
                    ->setAttrib('tabindex', '2')
                    ->setAttrib('class', 'ui-input-password ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(1);
        ;
        
        $passwordcheck = new Zend_Form_Element_Password('passwordcheck');
        $passwordcheck
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->addValidator('Identical', false, array('token' => 'passwordraw'))
                    ->setAttrib('id','register-pwdRpt')
                    ->setAttrib('placeholder','Repeat password')
                    ->setAttrib('tabindex', '3')
                    ->setAttrib('class', 'ui-input-password ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(2);
                
                
        ;
        
        $username = new Zend_Form_Element_Text('username');
        $username   
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','login-username')
                    ->setAttrib('placeholder','Username')
                    ->setAttrib('tabindex', '1')
                    ->setAttrib('autofocus', 'autofocus')
                    ->setAttrib('class', 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(3);
        ;
        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname  
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-fname')
                    ->setAttrib('placeholder','Firstname')
                    ->setAttrib('tabindex', '4')
                    ->setAttrib('class', 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(4);

        ;
        $surname = new Zend_Form_Element_Text('surname');
        $surname   
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-fname')
                    ->setAttrib('placeholder','Surname')
                    ->setAttrib('tabindex', '5')
                    ->setAttrib('class', 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(5);
        ;
        
        $email = new Zend_Form_Element_Text('email');
        $email 
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->addValidator('EmailAddress',true)
                    ->setAttrib('id','register-email')
                    ->setAttrib('placeholder','Email')
                    ->setAttrib('tabindex', '6')
                    ->setAttrib('class', 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(6);
        ;
        
        $gender = new Zend_Form_Element_Radio('gender');
        $gender     
                    ->setLabel('Gender')
                    ->addMultiOptions(array(
                        'm' => 'Male',
                        'f' => 'Female',
                    ))
                    ->setRequired()
                    ->setAttrib('tabindex', '7')
                    ->setOrder(7);
        ;
        $description = new Zend_Form_Element_Textarea('description');
        $description  
                    ->setAttrib('placeholder', "Describe yourself briefly (optional).")
                    ->setAttrib('id','textarea-a')
                    ->setAttrib('tabindex', '8')
                    ->setAttrib('class', 'ui-input-text ui-body-c ui-corner-all ui-shadow-inset')
                    ->setOrder(8);
        ;
        $website = new Zend_Form_Element_Text('website');
        $website     
                    ->addFilter('StringTrim')
                    ->setAttrib('id','register-website')
                    ->setAttrib('placeholder','Website')
                    ->setAttrib('tabindex', '9')
                    ->setAttrib('class', 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c')
                    ->setOrder(9);
        ;
        
        $avatar = new Zend_Form_Element_File('avatar');
        $avatar     ->setLabel('Avatar (Max 500KB, png or jpeg)')
                    ->setDestination( PUBLIC_PATH . "/images")
                    ->addValidator('IsImage')
                    ->addValidator('Size', false, 512000)
                    ->setMaxFileSize(512000)
                    ->addValidator('Count', false, 1)
                    ->setAttrib('tabindex', '10')
                    ->setOrder(10);
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit
                    ->setLabel('Register')
                    ->setOptions(array('class' => 'btn btn-success'))
                    ->setAttrib('id', 'register-btn')
                    ->setAttrib('tabindex', '11')
                    ->setOrder(20);
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

        

        $this->setOptions(array('id' => 'register'))
             ->setEnctype(Zend_Form::ENCTYPE_MULTIPART)
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($username)
             ->addElement($password )
             ->addElement($passwordcheck )
             ->addElement($firstname )
             ->addElement($surname )
             ->addElement($email )
             ->addElement($gender )
             ->addElement($description )
             ->addElement($website )
             ->addElement($avatar )
             ->addElement($submit )
        ;
    }

    /**
     * @param mixed $data Form data.
     * @return boolean
     */
   public function isValid($data)
    {
        $valid = parent::isValid($data);

        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {
                $decorator = $element->getDecorator('outer');
                if($decorator != NULL)
                {
                    $options = $decorator->getOptions();
                    $options['class'] .= ' error';
                    $decorator->setOptions($options);
                }
            }
        }
        return $valid;
    }   



}

