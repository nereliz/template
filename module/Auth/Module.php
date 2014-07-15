<?php

namespace Auth;

use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;

use \Auth\Model\APIAuth;
use \Auth\Model\AuthStorage;

class Module
{
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}