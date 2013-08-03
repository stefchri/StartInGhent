<?php

class Application_Form_Forgotpassword extends Zend_Form
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
        
        $username = new Zend_Form_Element_Text('username');

        $username->setLabel('Username')
                      ->setRequired()
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty', true) 
                      ->setAttrib('placeholder','Username')
                      ->setAttrib('tabindex', '1')
                      ->setAttrib('autofocus', 'autofocus')
                      ->setDecorators($decorators)
                      ->setOptions(array('class' => 'form-field', 'id' => 'forgot-username'))
        ;

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
                     ->setRequired()
                     ->addValidator('NotEmpty', true)
                     ->addValidator('EmailAddress')
                     ->addFilter('StringTrim')
                      ->setAttrib('placeholder','Email')
                      ->setAttrib('tabindex', '2')
                      ->setDecorators($decorators)
                      ->setOptions(array('class' => 'form-field', 'id' => 'forgot-email'))
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Request new password')
               ->setOptions(array('class' => 'btn btn-success', 'id' => "fpwd-btn"))
                      ->setAttrib('tabindex', '3')
                ->setDecorators(array(
                                        'ViewHelper',
                                        
                                    ))
               ;

        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('id' => 'forgot'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($username)
             ->addElement($email )
             ->addElement($submit)
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

