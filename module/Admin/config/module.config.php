<?php
return [
    'controllers' => [
        'invokables' => [
            'Admin\\Controller\\Users' => 'Admin\\Controller\\UsersController',
            'Admin\\Controller\\Tenants' => 'Admin\\Controller\\TenantsController',
        ],
    ],
    // The following section is new and should be added to your file
    'router' => [
        'routes' => [
            'admin_users' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/admin/users[/:action][/:us_id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'Admin\\Controller\\Users',
                        'action'     => 'list',
                    ],
                ],
            ],
            'admin_tenants' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/admin/tenants[/:action][/:te_id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'Admin\\Controller\\Tenants',
                        'action'     => 'list',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'config' => __DIR__ . '/../view',
        ],
    ],
    'translator' => [ 
        'translation_file_patterns' => [    
            [            
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],                                                                                          
    ],
];