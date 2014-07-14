<?php
namespace Auth\Form;

use ZasDev\Common\Entity\AbstractEntity;
use ZasDev\Common\Form\AbstractForm;
use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator\Reflection;
use Auth\Entity\Login;

/**
 * Login form
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginForm extends AbstractForm
{
    const FORM_NAME = "form-login";
    const USER      = "user";
    const PASSWORD  = "pass";
    const REMEMBER  = "remember";
    const HASH      = "hash";

    private $userElement;
    private $passwordElement;
    private $rememberElement;
    private $hashElement;
    
    public function __construct(
        InputFilterInterface $filters,
        HydratorInterface $hydrator,
        AbstractEntity $entityPrototype
    ) {
        parent::__construct(self::FORM_NAME);
        $this->setAttributes(array(
            "class" => self::FORM_NAME
        ));
        
        $this->initElements()
             ->setInputFilter($filters)
             ->setHydrator($hydrator)
             ->setObject($entityPrototype);
    }
    /**
     * Initializes all elements on this form and returns it
     * @return $this
     */
    protected function initElements()
    {
        // User element
        $this->userElement = new Text(self::USER);
        $this->userElement->setAttributes(array(
            "class"         => "form-control",
            "placeholder"   => "Usuario",
            "required"      => true,
            "autofocus"     => true,
        ));
        $this->add($this->userElement);
        
        // Password element
        $this->passwordElement = new Password(self::PASSWORD);
        $this->passwordElement->setAttributes(array(
            "class"         => "form-control",
            "placeholder"   => "Contraseña",
            "required"      => true,
        ));
        $this->add($this->passwordElement);
        
        // Remember element
        $this->rememberElement = new Checkbox(self::REMEMBER);
        $this->rememberElement->setLabel("Recordarme");
        $this->add($this->rememberElement);

        // Hash element
        $this->hashElement = new Csrf(self::HASH);
        $this->add($this->hashElement);
        
        return $this;
    }
    
    /**
     * 
     * @return \Zend\Form\Element\Text
     */
    public function getUserElement()
    {
        return $this->userElement;
    }
    /**
     *
     * @return \Zend\Form\Element\Password
     */
    public function getPasswordElement()
    {
        return $this->passwordElement;
    }
    /**
     *
     * @return \Zend\Form\Element\Checkbox
     */
    public function getRememberElement()
    {
        return $this->rememberElement;
    }
    /**
     *
     * @return \Zend\Form\Element\Csrf
     */
    public function getHashElement()
    {
        return $this->hashElement;
    }
}
