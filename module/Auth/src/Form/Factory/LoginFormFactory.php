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

namespace ZasDev\Auth\Form\Factory;

use ZasDev\Auth\Entity\Login;
use ZasDev\Auth\Form\LoginFilter;
use ZasDev\Auth\Form\LoginForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Reflection;

/**
 * Class LoginFormFactory
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class LoginFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new LoginForm(
            new LoginFilter(),
            new Reflection(),
            new Login(),
            $serviceLocator->get('ZasDev\Common\Options\CommonOptions')
        );
    }
}
