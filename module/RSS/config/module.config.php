<?php
return array(

    'controllers' => array(
        'factories' => array(
            'RSS\Controller\Feed' => 'RSS\Controller\FeedControllerFactory'
        )
    ),

    'service_manager' => array(
        'abstract_factories' => array(
            'RSS\Service\Factory\AbstractServiceFactory'
        )
    ),

    'console' => array(
        'router' => array(
            'routes' => array(

                'refresh-feeds' => array(
                    'options' => array(
                        'route' => 'zdr feeds --refresh [-v|--verbose]',
                        'defaults' => array(
                            'controller' => 'RSS\Controller\Feed',
                            'action' => 'refresh'
                        )
                    )
                )

            ),
        ),
    ),

);
