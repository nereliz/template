<?php

use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;

use Auth\Model\APIAuth; 
use Auth\Model\AuthStorage;

namespace Application\Traits;

trait AuthTrait{

    private $storage;
    private $authservice;
    
    public function getAuthService()
    {
        if( !$this->authservice )
        {
            $adapter  = new \Auth\Model\APIAuth( [
                'uri' =>    $this->config['ngn_api']['url'],
                'user' =>   $this->config['ngn_api']['auth_user'],
                'secret' => $this->config['ngn_api']['auth_secret'],
                'type' =>   $this->config['ngn_api']['auth_type']   
            ] );
    
            $authService = new \Zend\Authentication\AuthenticationService();
            $authService->setAdapter( $adapter );
            //$authService->setStorage( $this->getSessionStorage() );
          
            $this->authservice = $authService;                       
        }
          
        return $this->authservice;
    }
          
    public function getSessionStorage()
    {
        if( !$this->storage )
        $this->storage = new \Auth\Model\AuthStorage( 'ngn_portal' );
              
        return $this->storage;                                           
    }         
}