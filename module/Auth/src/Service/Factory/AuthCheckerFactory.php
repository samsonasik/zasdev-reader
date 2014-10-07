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

namespace ZasDev\Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use ZasDev\Auth\Service\AuthCheckerService;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * 
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AuthCheckerFactory implements FactoryInterface
{
    /**
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new AuthCheckerService($serviceLocator->get('ZasDev\Auth\Options\AuthOptions'));
        $service->setAuthService($serviceLocator->get('Zend\Authentication\AuthenticationService'))
                ->setPersistentLogin($serviceLocator->get('ZasDev\Auth\Service\PersistentLoginService'));
        return $service;
    }
}
