<?php

class Application_Form_Login extends Zend_Form
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
            array('Label',
                array('placement' => 'prepend',
                      'class'     => 'control-label',
                )
            ),
            array(
                array('outer' => 'HtmlTag'),
                array('tag'   => 'div',
                      'class' => 'control-group')),
        );
        
        $text_username = new Zend_Form_Element_Text('username');

        $text_username
                      ->setRequired()
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty', true) 
                      ->setAttrib('id','login-username')
                      ->setAttrib('placeholder','Username')
                      ->setAttrib('tabindex', '1')
                      ->setAttrib('autofocus', 'autofocus')
        ;

        $password_raw = new Zend_Form_Element_Password('passwordraw');
        $password_raw->setRequired()
                     ->addValidator('NotEmpty', true)
                      ->setAttrib('id','login-pwd')
                      ->setAttrib('placeholder','Password')
                      ->setAttrib('tabindex', '2')
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
               ->setOptions(array('class' => 'btn btn-success'))
               ->setAttrib('id', 'login-btn')
                      ->setAttrib('tabindex', '3')
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

       
        $this->setOptions(array('id' => 'view-login'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_username)
             ->addElement($password_raw )
             ->addElement($submit       )
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

