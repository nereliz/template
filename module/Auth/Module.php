<?php

namespace Auth;

use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

use \Auth\Model\AuthStorage;

class Module
{
    public function getAutoloaderConfig()
    {
        return [
            'Zend\\Loader\\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\\Loader\\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories'=> [
                'Auth\\Model\\AuthStorage' => function( $sm )
                {
                    return new \Auth\Model\AuthStorage( 'asterisk' );  
                },
        
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    $dbAdapter           = $sm->get( 'Zend\\Db\\Adapter\\Adapter' );
                    $dbTableAuthAdapter  = new DbTableAuthAdapter( $dbAdapter, 
                        'us_users','us_username','us_password', 'MD5(?)');
        
                    $authService = new AuthenticationService();
                    $authService->setAdapter( $dbTableAuthAdapter );
                    $authService->setStorage( $sm->get( 'Auth\\Model\\AuthStorage' ) );
        
                    return $authService;
                },
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}