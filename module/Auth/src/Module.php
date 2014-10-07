<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ZasDev\Auth;

use ZasDev\Auth\Service\AuthCheckerService;
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
                    /** @var Http\Request $request */
                    $request = $event->getRequest();

                    $url = $event->getRouter()->assemble(
                        array(),
                        array('name' => 'login', 'query' => array('redirect' => $request->getUriString()))
                    );

                    $resp->setStatusCode(302)
                         ->getHeaders()->addHeaders(array('Location' => $url));
                    return $resp;
                }
            }
        }, 100);
    }
}
