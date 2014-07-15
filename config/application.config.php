<?php
return [
    'modules' => [
        'Profile',
        'Application',
        'Auth',
        'Profile',
        'Admin',
        'SmartyModule',
    ],
    'module_listener_options' => [
        'config_glob_paths'    => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'module_paths' => [
            './module',
            './vendor',
        ],
    ],
];
