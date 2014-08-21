<?php

namespace Auth\Model;

use Zend\Authentication\Adapter;
use Zend\Authentication\Result;

use Application\Entity\UsUsers;

/**
 * @deprecated
 */
class DoctrineAuthAdapter implements \Zend\Authentication\Adapter\AdapterInterface
{
    private $username = "";
    private $password = "";
    private $username_field = "";
    private $password_field = "";
    private $encryption = "";
    private $service_locator = "";
  
    public function __construct( $service_locator, $username_field = "username", $password_field = "password", $encryption = "MD5" )
    {
        $this->service_locator = $service_locator;
        $this->username_field  = $username_field;
        $this->password_field  = $password_field;
        $this->encryption      = $encryption;
    } 
  
    public function authenticate()
    {
        $em = $this->service_locator->get( 'Doctrine\\ORM\\EntityManager' );
        $user = $em->getRepository( 'Application\\Entity\\UsUsers' )->findOneBy( [ $this->username_field => $this->username ] );
        
        if( !$user || $user->hashPassword( $this->password, $this->encryption ) !=  $user->getUsPassword() )    
            return new \Zend\Authentication\Result( \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID );
        else
            return new \Zend\Authentication\Result( \Zend\Authentication\Result::SUCCESS, $user );
                                                                                                                                                                                                      
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
