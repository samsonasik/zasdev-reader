<?php
namespace Auth;

use Zend\Debug\Debug;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->checkAuthentication($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function checkAuthentication(MvcEvent $e) {
        $e->getApplication()->getEventManager()->getSharedManager()->attach("*", MvcEvent::EVENT_DISPATCH, function(MvcEvent $event) {
            $service = $event->getApplication()->getServiceManager()->get('Auth\Service\AuthCheckerService');
            $service->setEvent($event);
            if (!$service->checkAuthentication()) {
                $event->getResponse()->setStatusCode(302);
                $event->getResponse()->getHeaders()->addHeaders(array("Location" => "/login"));
                return $event->getResponse();
            }
        }, 100);
    }

}
