<?php
namespace Auth\Controller\Factory;

use Auth\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class IndexControllerFactory
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndexController(
            $serviceLocator->getServiceLocator()->get('Zend\Authentication\AuthenticationService'),
            $serviceLocator->getServiceLocator()->get('Auth\Service\PersistentLoginService'),
            $serviceLocator->getServiceLocator()->get('Auth\Form\LoginForm'),
            $serviceLocator->getServiceLocator()->get('translator')
        );
    }
}
