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

namespace ZasDev\Auth\Controller\Factory;

use ZasDev\Auth\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class IndexControllerFactory
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IndexController(
            $serviceLocator->getServiceLocator()->get('Zend\Authentication\AuthenticationService'),
            $serviceLocator->getServiceLocator()->get('ZasDev\Auth\Service\PersistentLoginService'),
            $serviceLocator->getServiceLocator()->get('ZasDev\Auth\Form\LoginForm'),
            $serviceLocator->getServiceLocator()->get('translator')
        );
    }
}
