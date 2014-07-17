<?php
namespace Auth;

use Auth\Service\AuthCheckerServiceInterface;
use Zend\Debug\Debug;
use Zend\Http\Response;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->checkAuthentication($e);
        /* @var ServiceManager $sm */
        $sm = $e->getApplication()->getServiceManager();
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
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    public function checkAuthentication(MvcEvent $e)
    {
        $sharedManager =  $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach("*", MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
            /* @var AuthCheckerServiceInterface $service */
            $service = $event->getApplication()->getServiceManager()->get('Auth\Service\AuthCheckerService');
            $service->setEvent($event);
            if (!$service->checkAuthentication()) {
                /* @var Response $resp */
                $resp = $event->getResponse();
                $resp->setStatusCode(302)
                     ->getHeaders()->addHeaders(array("Location" => "/login"));
                return $resp;
            }
        }, 100);
    }
}
