<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        $decorators = array(
            'ViewHelper',
            array('Errors', array ('class' => 'help-inline')),
            array(
                'Label',
                array('placement' => 'prepend',
                )
            )
        );
        $password = new Zend_Form_Element_Password('passwordraw');
        $password   
                    ->setLabel("Password")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-pwd')
                    ->setAttrib('placeholder','Password')
                    ->setAttrib('tabindex', '2')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setAttrib('autofocus', 'autofocus')
                    ->setOrder(1);
        ;
        
        $passwordcheck = new Zend_Form_Element_Password('passwordcheck');
        $passwordcheck   
                    ->setLabel("Repeat password")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->addValidator('Identical', false, array('token' => 'passwordraw'))
                    ->setAttrib('id','register-pwdRpt')
                    ->setAttrib('placeholder','Repeat password')
                    ->setAttrib('tabindex', '3')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setOrder(2);
                
                
        ;
        
        $username = new Zend_Form_Element_Text('username');
        $username      
                    ->setLabel("Username")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','login-username')
                    ->setAttrib('placeholder','Username')
                    ->setAttrib('tabindex', '1')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setOrder(3);
        ;
        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname  
           
                    ->setLabel("Firstname")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-fname')
                    ->setAttrib('placeholder','Firstname')
                    ->setAttrib('tabindex', '4')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setOrder(4);

        ;
        $surname = new Zend_Form_Element_Text('surname');
        $surname   
                    ->setLabel("Surname")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->setAttrib('id','register-fname')
                    ->setAttrib('placeholder','Surname')
                    ->setAttrib('tabindex', '5')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setOrder(5);
        ;
        
        $email = new Zend_Form_Element_Text('email');
        $email    
                    ->setLabel("Email")
                    ->setRequired()
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty', true)
                    ->addValidator('EmailAddress',true)
                    ->setAttrib('id','register-email')
                    ->setAttrib('placeholder','Email')
                    ->setAttrib('tabindex', '6')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
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
                    ->setAttrib('class', 'inline')
                   // ->setDecorators($decorators)
                    ->setOrder(7);
        ;
        $description = new Zend_Form_Element_Textarea('description');
        $description     
                    ->setLabel("Description")
                    ->setAttrib('placeholder', "Describe yourself briefly (optional).")
                    ->setAttrib('id','textarea-a')
                    ->setAttrib('tabindex', '8')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setDecorators($decorators)
                    ->setOrder(8);
        ;
        
        $avatar = new Zend_Form_Element_File('avatar');
        $avatar     ->setLabel('Avatar (Max 500KB, png or jpeg)')
                    ->setDestination( PUBLIC_PATH . "/images")
                    ->addValidator('IsImage')
                    ->addValidator('Size', false, 512000)
                    ->setMaxFileSize(512000)
                    ->addValidator('Count', false, 1)
                    ->setAttrib('tabindex', '10')
                    ->setAttrib('class', 'form-field input-xxlarge')
                    ->setOrder(10);
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit
                    ->setLabel('Register')
                    ->setOptions(array('class' => 'btn btn-success'))
                    ->setDecorators(array('ViewHelper',array('Errors', array ('class' => 'help-inline'))))
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

