<?php

namespace Auth\Model;

use Zend\Authentication\Adapter;
use Zend\Authentication\Result;

/**
 * @deprecated
 */
class ApiAuth implements \Zend\Authentication\Adapter\AdapterInterface
{
    private $req_confs = [ 'uri', 'user', 'secret', 'type' ];
    private $username;
    private $pasword;
    private $configs;
  
    public function __construct( $configs )
    {
        foreach( $this->req_confs as $key )
        {
            if( !array_key_exists( $key, $configs ) )
                throw new \Exception( "Missign required configuration $key" );
            
        }
        $this->configs = $configs;
    } 
  
    public function authenticate()
    {
        
        $pest = new \PestJSON( $this->configs['uri'] );
        $pest->setupAuth( $this->configs['user'], $this->configs['secret'] , $this->configs['type'] );

        try
        {  
            $result = $pest->get( "/auth/username/" . $this->username . "/password/" . $this->password . ".json" );
            $identity = $result['content'];
            $identity['type'] = 'operator';
            
        }
        catch( \Exception $e )
        {
            return new \Zend\Authentication\Result( \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID );
        }
        
        return new \Zend\Authentication\Result( \Zend\Authentication\Result::SUCCESS, $identity );
                                                                                                                                                                                                      
    }
    
    public function setIdentity( $identity )
    {
        $this->username = $identity;
        return $this;
    }
    
    public function setCredential( $credential )
    {
        $this->password = $credential;
        return $this;
    }
}
