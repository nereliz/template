<?php
return [
    'controllers' => [
        'invokables' => [
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Customer' => 'Admin\Controller\CustomerController',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'administrator' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/admin/user[/:action][/:username]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'Admin\Controller\User',
                        'action'     => 'list',
                    ],
                ],
            ],
            'customer' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/admin/customer[/:action][/:customers_id]',
                    'constraints' => [
                        'action'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'customers_id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Admin\Controller\Customer',
                        'action'     => 'list',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'admin' => __DIR__ . '/../view',
        ],
    ],
];