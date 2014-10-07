<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Auth\Form;

use ZasDev\Common\Entity\AbstractEntity;
use ZasDev\Common\Form\AbstractForm;
use ZasDev\Common\I18n\FakeTranslator;
use ZasDev\Common\Options\CommonOptions;
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
        $entityPrototype,
        CommonOptions $commonOptions
    ) {
        parent::__construct(self::FORM_NAME, $commonOptions);
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
            "class"         => "form-control input-lg",
            "placeholder"   => FakeTranslator::translate("User"),
            "required"      => true,
            "autofocus"     => true,
        ));
        $this->add($this->userElement);
        
        // Password element
        $this->passwordElement = new Password(self::PASSWORD);
        $this->passwordElement->setAttributes(array(
            "class"         => "form-control input-lg",
            "placeholder"   => FakeTranslator::translate("Password"),
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

        $oldClass = $this->getSubmitElement()->getAttribute('class');
        $this->getSubmitElement()->setAttribute('class', $oldClass . " btn-block btn-lg")
                                 ->setLabel(FakeTranslator::translate("Log in"));
        
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
