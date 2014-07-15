<?php
return array(

    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => 'Application\Service\Factory\AuthenticationServiceFactory'
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

);
