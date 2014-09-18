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
    
    public function getSession()
    {
        return $this->getServiceLocator()->get( 'Zend\\Session\\SessionManager' );
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
    
    public function setDefaultTenant( $tenant = false )
    {
        $defaults = new \Zend\Session\Container( 'defaults' );
        
        if( $tenant )
        {
            $defaults->tenant = $tenant;
        }
        else
        {
            $idty = $this->getIdentity();
            if( $idty && $idty->getUpUserprofile()->getUpId() != 1 )
                $defaults->tenant = $idty->getTeTenants()[0];
            else
                $defaults->tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findAll()[0];
        }
        
        return $defaults->tenant;            
    }
    
    public function getDefaultTenant()
    {
        $defaults = new \Zend\Session\Container( 'defaults' );
        
        if( $defaults && $defaults->tenant )
            $tenant = $defaults->tenant;
        else 
            $tenant = $this->setDefaultTenant();
            
        return $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $tenant->getTeId() ] );
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
        
        $dtenant = $this->getDefaultTenant();
        return $data + [ 'messages' => $this->flashmessenger()->getMessages(), 'config' => $this->config, 'auth' => $auth, 'idty' => $idty, 'aTenants' => $aTenants, 'dTenant' => $dtenant ];
    }
    
    /**
     * If auth neaded and users is not loged in redirects to login.
     *
     * @param string|bool $type Identity type should be as given.
     * @return booln
     */
    private function isAuth( $up_id = false )
    {
        if( !$this->getAuth()->hasIdentity() )
        {
            $this->flashmessenger()->addMessage( "{t}You need to loign first{/t}@danger" );
            $this->redirect()->toRoute( 'auth', [ 'action'=> 'login' ] );
            return flase;
        }

        if( $up_id && $this->getIdentity()->getUpUserprofile()->getUpId() != $up_id  )
        {
            $this->flashmessenger()->addMessage( "{t}You do not have permisions to do this action{/t}@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return flase;
        }

        return true;
    }
    
    public function do_translation( $params, $content, $smarty, &$repeat, $template = false )
    {
        if( isset( $content ) )
        {
            $translator = $smarty->getRegisteredObject( 'translator' );
            $lang = isset( $params["lang"] ) && $params["lang"] ? $params["lang"] : false;
            $domain = isset( $params["domain"] ) && $params["domain"] ? $params["domain"] : 'default';
            // do some translation with $content
                                                                      
            return $translator->translate( $content, $domain, $lang );
            return "hello";
        }
    }
                                                                                                               
}