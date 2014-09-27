<?php
namespace RSS\Controller;

use RSS\Service\FeedServiceInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FeedControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        /** @var TranslatorInterface $translator */
        $translator = $serviceLocator->getServiceLocator()->get('Translator');
        /** @var FeedServiceInterface $feedService */
        $feedService = $serviceLocator->getServiceLocator()->get('RSS\Service\FeedService');

        return new FeedController($feedService, $translator);
    }
}
