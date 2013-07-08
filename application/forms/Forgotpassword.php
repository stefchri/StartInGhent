<?php

class Application_Form_Forgotpassword extends Zend_Form
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
        
    $username = new Zend_Form_Element_Text('username');

        $username
                      ->setRequired()
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty', true) 
                      ->setAttrib('placeholder','Username')
                      ->setAttrib('tabindex', '1')
                      ->setAttrib('autofocus', 'autofocus')
                      ->setOptions(array('class' => 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c', 'id' => 'forgot-username'))
        ;

        $email = new Zend_Form_Element_Text('email');
        $email
                     ->setRequired()
                     ->addValidator('NotEmpty', true)
                     ->addValidator('EmailAddress')
                     ->addFilter('StringTrim')
                      ->setAttrib('placeholder','Email')
                      ->setAttrib('tabindex', '2')
                      ->setOptions(array('class' => 'ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c', 'id' => 'forgot-email'))
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Request password')
               ->setOptions(array('class' => 'btn btn-success', 'id' => "fpwd-btn"))
                      ->setAttrib('tabindex', '3')
               ;

        $view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('class' => 'form-horizontal', 'id' => 'view-forgot'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($username)
             ->addElement($email )
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

