<?php
namespace Auth\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Password;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\Reflection;
use Auth\Entity\Login;

/**
 * Login form
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginForm extends Form
{
    
    const FORM_NAME = "form-login";
    const USER      = "user";
	const PASSWORD  = "pass";
	const REMEMBER  = "remember";
	const HASH      = "hash";
	const SUBMIT    = "submit";
	
	private $userElement;
	private $passwordElement;
	private $rememberElement;
	private $hashElement;
	private $submitElement;
    
    public function __construct() {
        parent::__construct(self::FORM_NAME);
        $this->setAttributes(array(
        	"class" => self::FORM_NAME
        ));
        
        $this->initElements()
             ->add($this->userElement)
             ->add($this->passwordElement)
             ->add($this->rememberElement)
             ->add($this->hashElement)
             ->add($this->submitElement);
        
        $this->setHydrator(new Reflection())
             ->setObject(new Login())
             ->setInputFilter(new LoginFilter());
    }
    /**
     * Initializes all elements on this form and returns it
     * @return $this
     */
    protected function initElements() {
        // User element
        $this->userElement = new Text(self::USER);
        $this->userElement->setAttributes(array(
        	"class"         => "form-control",
        	"placeholder"   => "Usuario",
            "required"      => true,
            "autofocus"     => true,
        ));
        
        // Password element
        $this->passwordElement = new Password(self::PASSWORD);
        $this->passwordElement->setAttributes(array(
            "class"         => "form-control",
            "placeholder"   => "Contraseña",
            "required"      => true,
        ));
        
        // Remember element
        $this->rememberElement = new Checkbox(self::REMEMBER);
        $this->rememberElement->setLabel("Recordarme");
        
        // Submit element
        $this->submitElement = new Submit(self::SUBMIT);
        $this->submitElement->setAttributes(array(
        	"value" => "Iniciar sesión",
            "class" => "btn btn-lg btn-primary btn-block"
        ));
        
        // Hash element
        $this->hashElement = new Csrf(self::HASH);
        
        return $this;
    }
    
    /**
     * 
     * @return \Zend\Form\Element\Text
     */
	public function getUserElement() {
    	return $this->userElement;
    }
	/**
	 * 
	 * @return \Zend\Form\Element\Password
	 */
	public function getPasswordElement() {
    	return $this->passwordElement;
    }
	/**
	 * 
	 * @return \Zend\Form\Element\Checkbox
	 */
	public function getRememberElement() {
    	return $this->rememberElement;
    }
	/**
	 * 
	 * @return \Zend\Form\Element\Csrf
	 */
	public function getHashElement() {
    	return $this->hashElement;
    }
	/**
	 * 
	 * @return \Zend\Form\Element\Submit
	 */
	public function getSubmitElement() {
    	return $this->submitElement;
    }
	
    
    
}