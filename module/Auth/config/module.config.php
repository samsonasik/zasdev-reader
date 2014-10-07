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

return array(

    'controllers' => array(
        'factories' => array(
            'Auth\Controller\Index' => 'Auth\Controller\Factory\IndexControllerFactory',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => 'Auth\Service\Factory\AuthenticationServiceFactory',
            'Auth\Service\PersistentLoginService'       => 'Auth\Service\Factory\PersistentLoginServiceFactory',
            'Auth\Service\AuthCheckerService'           => 'Auth\Service\Factory\AuthCheckerFactory',
            'Auth\Form\LoginForm'                       => 'Auth\Form\Factory\LoginFormFactory',
            'Auth\Options\AuthOptions'                  => 'Auth\Options\Factory\AuthOptionsFactory',
        ),
    ),

    'router' => array(
        'routes' => array(

            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Index',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Index',
                        'action'     => 'logout',
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/login' => __DIR__ . '/../view/layout/login.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

);
