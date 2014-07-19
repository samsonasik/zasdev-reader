<?php
namespace Auth;

use Auth\Service\AuthCheckerService;
use Auth\Service\AuthCheckerServiceInterface;
use Zend\Debug\Debug;
use Zend\EventManager\EventInterface;
use Zend\Http\Response;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /* @var MvcEvent $e */
        $this->checkAuthentication($e);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function checkAuthentication(MvcEvent $e)
    {
        $sharedManager =  $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach("*", MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
            /* @var AuthCheckerService $service */
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
