<?php
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
                    'Application\Entity'    => 'application_entities',
                    'Auth\Entity'           => 'auth_entities',
                    'RSS\Entity'            => 'rss_entities',
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
                'identity_class'        => 'Application\Entity\User',
                'identity_property'     => 'username',
                'credential_property'   => 'password',
                'credential_callable'   => '\Application\Entity\User::isAuthenticationValid'
            ),
        ),
    )

);
