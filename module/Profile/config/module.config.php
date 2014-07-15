<?php
return [
    'controllers' => [
        'invokables' => [
            'Profile\Controller\Profile' => 'Profile\Controller\ProfileController',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'profile' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/profile[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Profile\Controller\Profile',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'profile' => __DIR__ . '/../view',
        ],
    ],
];