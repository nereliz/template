<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
    'application' => [
        'site' => [
            'name' => 'NGN Provider',
            'url'  => 'http://portal.frapi'
        ],
        'template' => [
            'layout/messages' =>  __DIR__ . "/../../module/Application/view/layout/messages.tpl",
            'layout/topmenu'  =>  __DIR__ . "/../../module/Application/view/layout/top-menu.tpl",
            'form/element'    =>  __DIR__ . "/../../module/Application/view/layout/form/element.tpl",
        ],
        'ngn_api' => [
            'url'         => 'http://api.frapi',
            'auth_user'   => 'auth',
            'auth_secret' => 'fbc20ace4014bb000cf1336d13d8c6dc7c65fbd5',
            'auth_type'   => 'digest'
        ],
        'defaults' => [
            'customer' => [
                'types' => [
                    'reseller' => 'Reseller',
                    'customer' => 'Customer'
                ]
            ]
        ]
    ]
];