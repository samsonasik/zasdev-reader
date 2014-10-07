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

    // Doctrine parameters
    'doctrine' => array(
        // Entity mapping driver
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'apc',
                'paths' => array(
                    __DIR__ . '/../../module/Application/src/Entity',
                )
            ),
            'auth_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'apc',
                'paths' => array(
                    __DIR__ . '/../../module/Auth/src/Entity',
                )
            ),
            'rss_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'apc',
                'paths' => array(
                    __DIR__ . '/../../module/RSS/src/Entity',
                )
            ),

            'orm_default' => array(
                'drivers' => array(
                    'ZasDev\Application\Entity'    => 'application_entities',
                    'ZasDev\Auth\Entity'           => 'auth_entities',
                    'ZasDev\RSS\Entity'            => 'rss_entities',
                )
            ),

        ),
        // Database connection params
        'connection' => array(
            'orm_default' => array(
//                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array()
            )
        ),
        // Authentication service
        'authentication' => array(
            'orm_default' => array(
                'objectManager'         => 'Doctrine\ORM\EntityManager',
                'identity_class'        => 'ZasDev\Application\Entity\User',
                'identity_property'     => 'username',
                'credential_property'   => 'password',
                'credential_callable'   => '\ZasDev\Application\Entity\User::isPasswordValid'
            ),
        ),
    )

);
