<?php
/**
 * @author Stefaan Christiaens <stefaan.ch@gmail.com>
 */
class statGhent_Form_Element_Html extends Zend_Form_Element_Xhtml {
    /**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formNote';

    public function isValid($value, $context = null) {
        return true;
    }
}