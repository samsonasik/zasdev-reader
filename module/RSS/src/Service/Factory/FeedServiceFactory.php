<?php
namespace RSS\Service\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use RSS\Event\FeedListener;
use RSS\Service\FeedService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FeedServiceFactory
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        /** @var AuthenticationService $authService */
        $authService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        $service = new FeedService($objectManager, $authService);
        $service->getEventManager()->attach(new FeedListener());

        return $service;
    }
}
