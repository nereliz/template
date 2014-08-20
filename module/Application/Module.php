<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

use \Auth\Model\AuthStorage;

class Module
{
    public function onBootstrap($e)
    {
        $session = $e->getApplication()->getServiceManager()->get( 'session' );
        if( isset( $session->lang ) )
        {
            $translator = $e->getApplication()->getServiceManager()->get( 'translator' );
            $translator->setLocale( $session->lang );

            $viewModel = $e->getViewModel();
            $viewModel->lang = str_replace( '_', '-', $session->lang );
        }
        $eventManager = $e->getApplication()->getEventManager();

        $eventManager->attach('route', function( $e )
        {
            $lang = $e->getRouteMatch()->getParam('lang');

            // If there is no lang parameter in the route, nothing to do
            if( empty( $lang ) ) 
                return;

            $services = $e->getApplication()->getServiceManager();

            // If the session language is the same, nothing to do
            $session = $services->get('session');
            if( isset( $session->lang ) && ( $session->lang == $lang ) )
                return;

            $viewModel  = $e->getViewModel();
            $translator = $services->get( 'translator' );

            $viewModel->lang = $lang;
            $lang = str_replace( '-', '_', $lang );
            $translator->setLocale( $lang );
            $session->lang = $lang;
        }, -10);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach( $eventManager );
        
        
        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();
        $sharedManager->attach( 'Zend\Mvc\Application', 'dispatch.error', function( $e ) use ( $sm ) {
            if( $e->getParam( 'exception' ) )
                $sm->get( 'Logger' )->crit( $e->getParam( 'exception' ) );
        });        
        
        $e->getApplication()->getServiceManager()->get( 'viewhelpermanager' )->setFactory( 'ngnview', function( $sm ) use ( $e ) {
             return new View\Helper( $e->getRouteMatch() );
        });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'configItem' => function(  $helperPluginManager )
                {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\ConfigItem();
                    $viewHelper->setServiceLocator( $serviceLocator );
                                                                            
                    return $viewHelper;
                }
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'initializers' => [
                function( $instance, $sm )
                {
                    if( $instance instanceof ConfigAwareInterface )
                    {
                        $locator = $sm->getServiceLocator();
                        $config  = $locator->get( 'Config' );
                        $instance->setConfig( $config['application'] );
                    }
                }
                ]
        ];
    }
    
    public function getServiceConfig()
    {
        return [
            'initializers' => [
                function( $instance, $sm )
                {
                    if( $instance instanceof ConfigAwareInterface )
                    {
                        $config  = $sm->get('Config');
                        $instance->setConfig($config['application']);
                    }
                }
            ],
            'factories' => [
                'Logger' => function($sm) {
                    $logger = new \Zend\Log\Logger;

                    if( !is_dir( './data/log/' . date( 'Y' ) . '/' . date( 'm' ) ) )
                        mkdir( './data/log/' . date( 'Y' ) . '/' . date( 'm' ), 0777, true  ); 

                    $writer = new \Zend\Log\Writer\Stream( './data/log/' . date( 'Y' ) . '/' . date( 'm' ) . '/' . date( 'd' ) . '.log' );
                    $logger->addWriter( $writer );  

                    return $logger;
                },
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

}
