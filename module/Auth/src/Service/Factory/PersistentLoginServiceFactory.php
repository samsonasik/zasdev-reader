<?php
namespace Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Auth\Service\PersistentLoginService;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * 
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class PersistentLoginServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return PersistentLoginService|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PersistentLoginService(
            $serviceLocator->get('Doctrine\ORM\EntityManager'),
            $serviceLocator->get('Request'),
            $serviceLocator->get('Response')
        );
    }
}
