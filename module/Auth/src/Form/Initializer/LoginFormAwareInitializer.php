<?php
namespace Auth\Form\Initializer;

use Auth\Form\LoginForm;
use Auth\Form\LoginFormAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class LoginFormAwareInitializer
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginFormAwareInitializer implements InitializerInterface
{
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof LoginFormAwareInterface) {
            /* @var LoginForm $form */
            $form = $serviceLocator->get('Auth\Form\LoginForm');
            $instance->setLoginForm($form);
        }
    }
}
