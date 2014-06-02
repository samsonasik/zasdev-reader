<?php
namespace ZasDev\Common\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element;
use Zend\Form\Form;
use ZasDev\Common\I18n\FakeTranslator;

/**
 * AbstractForm with basic functionality any form will probably need
 * @author ZasDev
 * @link https://github.com/zasDev
 */
abstract class AbstractForm extends Form
{

    const SUBMIT    = 'submit';
    const RESET     = 'reset';

    /**
     * @var Button
     */
    private $submitElement;

    public function __construct($name, $options = array())
    {
        parent::__construct($name, $options);

        $this->submitElement = new Button(self::SUBMIT);
        $this->submitElement->setAttributes(array(
                                'type'          => 'submit',
                                'class'         => 'btn btn-primary',
                                'data-loading'  => FakeTranslator::translate('Saving...')
                            ))
                            ->setLabel(FakeTranslator::translate("Save"));
        $this->add($this->submitElement);
    }

    /**
     * Sets this form's action attribute
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->setAttribute('action', $action);
        return $this;
    }

    /**
     * Resets all the elements in this form
     * @return $this
     */
    public function reset()
    {
        /* @var Element $element */
        foreach ($this->getElements() as $element) {
            $element->setValue('');
        }
        return $this;
    }

    /**
     * Initializes this form elements
     * @return $this
     */
    abstract protected function initElements();

    /**
     * @return Button
     */
    public function getSubmitElement()
    {
        return $this->submitElement;
    }

} 