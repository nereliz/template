<?php

use Zend\Authentication\AuthenticationService;

namespace Application\Traits;
trait HelperTrait{
    
    protected $config;
    protected $authservice;
                
    public function getAuth()
    {
        if( !$this->authservice )
            $this->authservice = $this->getServiceLocator()->get( 'AuthService' );

        return $this->authservice;
    }
    
    public function setConfig( $config )
    {
        $this->config = $config;
    }
    
    public function getIdentity()
    {
        if( $this->getAuth()->hasIdentity() )
        {
            $identity =  $this->getAuth()->getIdentity();
            $em =  $this->getEManager();
            $user = $em->getRepository( 'Application\\Entity\\UsUsers' )->findOneBy( [ 'usUsername' => $identity->getUsUsername() ] );
            return $user;
        }
        else
            return false;
    }
    
    public function getEManager()
    {
        return $this->getServiceLocator()->get( 'Doctrine\\ORM\\EntityManager' );
    }
                        
    
    public function finalise( $data )
    {
        $auth = $this->getAuth();
        $idty = $this->getIdentity();
        if( $idty )
        {
            if( $idty->getUpUserprofile()->getUpId() != 1 )
                $aTenatns = $idty->getTeTenantNames();
            else
                $aTenants = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->getNamesIdsList();
        }
        else 
            $aTenants = array();
            
        return $data + [ 'messages' => $this->flashmessenger()->getMessages(), 'config' => $this->config, 'auth' => $auth, 'idty' => $idty, 'aTenants' => $aTenants ];
    }
    
    /**
     * If auth neaded and users is not loged in redirects to login.
     *
     * @param string|bool $type Identity type should be as given.
     * @return booln
     */
    private function isAuth( $type = false )
    {
        if( !$this->getAuth()->hasIdentity() )
        {
            $this->flashmessenger()->addMessage( "You need to loign first@danger" );
            $this->redirect()->toRoute( 'auth', [ 'action'=> 'login' ] );
            return flase;
        }

        if( $type && $this->identity()['type'] != $type )
        {
            $this->flashmessenger()->addMessage( "You do not have permisions to do this action@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return flase;
        }

        return true;
    }
                                                                                                                                                                                       
}