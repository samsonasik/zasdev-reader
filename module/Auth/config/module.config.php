<?php
return array(

    'controllers' => array(
        'factories' => array(
            'Auth\Controller\Index' => 'Auth\Controller\Factory\IndexControllerFactory',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Auth\Service\PersistentLoginService'   => 'Auth\Service\Factory\PersistentLoginServiceFactory',
            'Auth\Service\AuthCheckerService'       => 'Auth\Service\Factory\AuthCheckerFactory',
            'Auth\Form\LoginForm'                   => 'Auth\Form\Factory\LoginFormFactory',
        ),
//        'initializers' => array(
//            'Auth\Form\Initializer\LoginFormAwareInitializer'
//        ),
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
