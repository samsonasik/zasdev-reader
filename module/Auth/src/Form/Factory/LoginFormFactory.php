<?php
namespace Auth\Form\Factory;

use Auth\Entity\Login;
use Auth\Form\LoginFilter;
use Auth\Form\LoginForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Reflection;

/**
 * Class LoginFormFactory
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new LoginForm(
            new LoginFilter(),
            new Reflection(),
            new Login(),
            $serviceLocator->get('ZasDev\Common\Options\CommonOptions')
        );
    }
}
