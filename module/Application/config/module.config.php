<?php
return [ 
    'doctrine' => [
        'driver' => [
            'application_entities' => [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                 'cache' => 'array',
                 'paths' => array(__DIR__ . '/../src/Application/Entity')
            ],
                                
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities'
                ]
            ]
        ]
    ],                                       
    'router' => [
         'routes' => [
            
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/[:lang]',
                    'constraints' =>[
                        'lang' => '[a-z]{2}(-[A-Z]{2}){0,1}'
                    ],
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index'
                    ],
                ],
            ],
            'index' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/[:lang]',
                    'constraints' =>[
                        'lang' => '[a-z]{2}(-[A-Z]{2}){0,1}'
                    ],
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index'
                    ],
                ],
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '[/:lang]/application',
                    'constraints' => [
                        'lang' => '[a-z]{2}(-[A-Z]{2}){0,1}'
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route' => '[/:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ],
        'services' => [
            'session' => new Zend\Session\Container( 'ngn_portal' ),
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.tpl',
            'application/index/index' => __DIR__ . '/../view/application/index/index.tpl',
            'error/404'               => __DIR__ . '/../view/error/404.tpl',
            'error/index'             => __DIR__ . '/../view/error/index.tpl',
            'layout/messages'         => __DIR__ . '/../view/layout/messages.tpl'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
