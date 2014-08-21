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
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ],
    ],
    'application' => [
        'site' => [
            'name' => "Cloud PBX Admin",
            'url'  => "http://nerijus.telinsta.com",
        ],
        'template' => [
            'layout/messages' =>  __DIR__ . "/../../module/Application/view/layout/messages.tpl",
            'layout/topmenu'  =>  __DIR__ . "/../../module/Application/view/layout/top-menu.tpl",
            'form/element'    =>  __DIR__ . "/../../module/Application/view/layout/form/element.tpl",
        ],
        
        'defaults' => [
        ]
    ],
    'db' => [
        'driver' => 'Mysqli',
        'host' => 'localhost',
        'database' => 'asterisk',
        'username' => 'asterisk',
        'password' => 'qwerty78'
    ],
];