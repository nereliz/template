<?php
return [
    'controllers' => [
        'invokables' => [
            'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'auth' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/auth[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'login',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'auth' => __DIR__ . '/../view',
        ],
    ],
];