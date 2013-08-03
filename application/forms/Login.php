<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $decorators = array(
            'ViewHelper',
            array('Errors', array ('class' => 'help-inline')),
            
            array('Label',array('placement' => 'prepend',"class" => ""))
        );
        
        $text_username = new Zend_Form_Element_Text('username');
        $text_username
                      ->setRequired()
                      ->setLabel('Username')
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty', true) 
                      ->setAttrib('id','login-username')
                      ->setAttrib('class','form-field')
                      ->setAttrib('placeholder','Username')
                      ->setAttrib('tabindex', '1')
                      ->setAttrib('autofocus', 'autofocus')
                      ->setDecorators($decorators);
        ;

        $password_raw = new Zend_Form_Element_Password('passwordraw');
        $password_raw->setRequired()
                      ->setLabel('Password')
                      ->addValidator('NotEmpty', true)
                      ->setAttrib('id','login-pwd')
                      ->setAttrib('class','form-field')
                      ->setAttrib('placeholder','Password')
                      ->setAttrib('tabindex', '2')
                      ->setDecorators($decorators);
                
        $forgot = new statGhent_Form_Element_Html('forgot');
        $forgot->setValue('<a href="'. WEB_BASE_PATH .'account/forgotpassword" class="">Forgot password?</a>')
                ->setDecorators(array(
                            'ViewHelper',
                            array('Errors', array ('class' => 'help-inline')),
                        ));
        
        $break = new statGhent_Form_Element_Html('break');
        $break->setValue('<br/>')
                ->setDecorators(array(
                            'ViewHelper',
                            array(
                                array('outer' => 'HtmlTag'),
                                array('tag'   => 'div',
                                      'class' => 'control-group')),
                        ));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel("Login")
               ->setOptions(array('class' => 'btn'))
               ->setAttrib('id', 'login-btn')
               ->setAttrib('tabindex', '4')
               ->setDecorators(array(
                        'ViewHelper',
                            array('Errors', array ('class' => 'help-inline'))
                        ));
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

       
        $this->setOptions(array('id' => 'login', "class" => 'form-horizontal'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_username)
             ->addElement($password_raw )
             ->addElement($break       )
             ->addElement($submit       )
             ->addElement($forgot       )
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

