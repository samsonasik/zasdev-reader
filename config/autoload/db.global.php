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
                    __DIR__ . '/../../module/Application/src/Application/Entity',
                )
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities',
                )
            ),

        ),
        // Database connection params
        'connection' => array(
            'orm_default' => array(
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'          => 'localhost',
                    'port'          => '3306',
                    'user'          => '',
                    'password'      => '',
                    'dbname'        => '',
                    'driverOptions' => array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ),
                )
            )
        ),
        // Authentication service
        'authentication' => array(
            'orm_default' => array(
                'objectManager'         => 'Doctrine\ORM\EntityManager',
                'identityClass'         => 'Application\Entity\User',
                'identityProperty'      => 'username',
                'credentialProperty'    => 'password',
                'credentialCallable'    => '\Application\Entity\User::isAuthenticationValid'
            ),
        ),
    )

);
