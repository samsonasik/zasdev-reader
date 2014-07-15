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
            $serviceLocator->get('Zend\Authentication\AuthenticationService'),
            $serviceLocator->get('Auth\Service\PersistentLoginService')
        );
    }
}
