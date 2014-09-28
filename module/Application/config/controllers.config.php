<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index'      => 'Application\Controller\IndexController',
        ),
        'factories' => array(
            'Application\Controller\Console'    => 'Application\Controller\Factory\ConsoleControllerFactory',
        )
    ),

);
