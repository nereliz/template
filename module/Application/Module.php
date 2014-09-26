<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Auth\Model\DoctrineAuthAdapter;

use Auth\Model\AuthStorage;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    public function onBootstrap($e)
    {
        $defaults = new Container( 'defaults' );
        
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach( $eventManager );

        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $sharedManager->attach( 'Zend\\Mvc\\Application', 'dispatch.error', function( $e ) use ( $sm ) {
            if( $e->getParam( 'exception' ) )
                $sm->get( 'Logger' )->crit( $e->getParam( 'exception' ) );
        });        
        
        $sm->get( 'viewhelpermanager' )->setFactory( 'ngnview', function( $sm ) use ( $e ) {
             return new View\Helper( $e->getRouteMatch() );
        });
        
        //change here translation until UI will be done
        $defaults->lang = "en_US";
        $lang = isset( $defaults->lang ) && $defaults->lang  ? $defaults->lang : 'en_US';
        $translator = $sm->get('translator');
        $translator->setLocale( $lang )->setFallbackLocale('en_US');
        
        $sm->get( 'viewhelpermanager' )->get('translate')->setTranslator( $translator );
        $sm->get( 'smarty' )->registerObject( 'translator', $translator );
        $sm->get( 'smarty' )->registerPlugin( "block","t", "Application\\Smarty\\Plugins::do_translation" );
        
        if( substr( $_SERVER['REQUEST_URI'], 0, 5 ) != "/auth" && substr( $_SERVER['REQUEST_URI'], 0, 6 ) != "/index" && $_SERVER['REQUEST_URI'] != "/" )
        {
            if( $defaults->current_url )
            {
                $defaults->prev_url = $defaults->current_url;
                $defaults->current_url = $_SERVER['REQUEST_URI'];
            }
            else
                $defaults->current_url = $_SERVER['REQUEST_URI'];  
        }
    }
        
    public function bootstrapSession($e)
    {
        $session = $e->getApplication()->getServiceManager()->get('Zend\\Session\\SessionManager');
        $session->start();

        $container = new Container('initialized');
        if( !isset( $container->init ) )
        {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\\Loader\\StandardAutoloader' => array(
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
                'Auth\\Model\\AuthStorage' => function( $sm ){
                    return new \Auth\Model\AuthStorage( 'asterisk' );  
                },
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    $dAuthAdapter  = new DoctrineAuthAdapter( $sm, 'usUsername', 'usPassword' );

                    $authService = new AuthenticationService();
                    $authService->setAdapter( $dAuthAdapter );
                    $authService->setStorage( $sm->get( 'Auth\\Model\\AuthStorage' ) );

                    return $authService;
                },
                'Zend\\Session\\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    if( isset( $config['session'] ) )
                    {
                        $session = $config['session'];
                
                        $sessionConfig = null;
                        if( isset( $session['config'] ) )
                        {
                            $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\\Session\\Config\\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : [];
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }
                
                        $sessionStorage = null;
                        if( isset( $session['storage'] ) )
                        {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }
                
                        $sessionSaveHandler = null;
                        if( isset( $session['save_handler'] ) )
                        {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get( $session['save_handler'] );
                        }
                
                        $sessionManager = new SessionManager( $sessionConfig, $sessionStorage, $sessionSaveHandler );
                
                        if( isset( $session[ 'validator' ] ) )
                        {
                            $chain = $sessionManager->getValidatorChain();
                            foreach( $session['validator'] as $validator )
                            {
                                $validator = new $validator();
                                $chain->attach('session.validate', [ $validator, 'isValid'] );
                            }
                        }
                    }
                    else
                    {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager( $sessionManager );
                    return $sessionManager;
                },
            ],
        ];
    }
}

    
