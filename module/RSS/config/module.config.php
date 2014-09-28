<?php
return array(

    'controllers' => array(
        'factories' => array(
            'RSS\Controller\Feed' => 'RSS\Controller\FeedControllerFactory'
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
