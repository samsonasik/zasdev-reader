<?php
return array(

    'controllers' => array(
        'invokables' => array(
            'RSS\Controller\Feed' => 'RSS\Controller\FeedController'
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
