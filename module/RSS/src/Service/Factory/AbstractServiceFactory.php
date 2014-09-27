<?php
namespace RSS\Service\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use RSS\Event\FeedListener;
use RSS\Service\FeedService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return class_exists($requestedName) && is_subclass_of($requestedName, 'ZasDev\Common\Service\AbstractService');
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        /** @var AuthenticationService $authService */
        $authService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        $service = new $requestedName($objectManager, $authService);
        if ($service instanceof FeedService) {
            $service->getEventManager()->attach(new FeedListener());
        }

        return $service;
    }
}
