<?php
namespace Auth;

use Auth\Service\AuthCheckerService;
use Zend\EventManager\EventInterface;
use Zend\Http\Response;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Http;

/**
 * Class Module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface
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

    public function checkAuthentication(MvcEvent $e)
    {
        // TODO Remove this once BjyAuthorize module is enabled
        $sharedManager =  $e->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->attach("*", MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
            /* @var AuthCheckerService $service */
            $service = $event->getApplication()->getServiceManager()->get('Auth\Service\AuthCheckerService');
            $service->setEvent($event);
            if (!$service->checkAuthentication()) {
                $resp = $event->getResponse();
                if ($resp instanceof Http\Response) {
                    $resp->setStatusCode(302)
                         ->getHeaders()->addHeaders(array("Location" => "/login"));
                    return $resp;
                }
            }
        }, 100);
    }
}
