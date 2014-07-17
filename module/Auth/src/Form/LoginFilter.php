<?php
namespace Auth\Form;

use Zend\InputFilter\InputFilter;

/**
 * Filters for login form
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->initFilters();
    }
    
    /**
     * Initializes filters for each element in LoginForm
     * @see \Application\Form\LoginForm
     */
    protected function initFilters()
    {
        // Username
        $this->add(array(
            'name'      => LoginForm::USER,
            'required'  => true
        ));
        
        // Password
        $this->add(array(
            'name'      => LoginForm::PASSWORD,
            'required'  => true
        ));
    }
}
