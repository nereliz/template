<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Application\ConfigAwareInterface;

use Auth\Model\User;


class AuthController extends AbstractActionController implements ConfigAwareInterface
{
    use \Application\Traits\HelperTrait;
    
    protected $form;
    protected $storage;
    protected $authservice;
    protected $main_route = 'auth';
    
    public function getAuthService()
    {
        if( !$this->authservice )
            $this->authservice = $this->getServiceLocator()->get( 'AuthService' );
    
        return $this->authservice;
    }
    
    public function getSessionStorage()
    {
        if( !$this->storage )
            $this->storage = $this->getServiceLocator()->get('Auth\\Model\\AuthStorage');
    
        return $this->storage;
    }
    
    public function getForm()
    {
        if( !$this->form )
        {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm( $user );
            $this->form->setAttribute( 'action', '/auth/authenticate' );
            $this->form->setAttribute( 'method', 'post' );
            $this->form->setAttribute( 'class', 'form-horizontal' );
        }
    
        return $this->form;
    }
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'login' );
    }
    
    public function loginAction()
    {
        //if already login, redirect to success page 
        if( $this->getAuthService()->hasIdentity() )
            return $this->redirect()->toRoute( 'config_ivrs', [ 'action'=> 'list' ] );
       
        $form    = $this->getForm();
        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
    }
    
    public function authenticateAction()
    {
        $form     = $this->getForm();    
        $request  = $this->getRequest();
        if( $request->isPost() )
        {
            $form->setData( $request->getPost() );
            if( $form->isValid() ) 
            {
                //check authentication...
                $this->getAuthService()->getAdapter()
                    ->setIdentity( $request->getPost( 'username' ) )
                    ->setCredential( $request->getPost( 'password' ) );
    
                $result = $this->getAuthService()->authenticate();
                //ZF2 Authentication messages
                /*foreach( $result->getMessages() as $message )
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage( $message . "@success" );
                }*/
    
                if( $result->isValid() )
                {
                    //check if it has rememberMe :
                    if( $request->getPost( 'rememberme' ) == 1 )
                    {
                        $this->getSessionStorage()->setRememberMe( 1 );
                        //set storage again 
                        $this->getAuthService()->setStorage( $this->getSessionStorage() );
                    }
                    $this->getAuthService()->getStorage()->write( $result->getIdentity() );
                    $this->setDefaultTenant();
                    
                    $this->flashmessenger()->addMessage( "{t}You've been logged in{/t}@success" );
                }
                else
                    $this->flashmessenger()->addMessage( "{t}Wrong username or password.{/t}@danger" );
                
                $defaults = $this->getSessionDefaults();    
                return $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            }
        }
        return $this->forward()->dispatch( 'Auth\\Controller\\Auth', array( 'action' => 'login' ) );
    }
    
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
    
        $this->flashmessenger()->addMessage("{t}You've been logged out{/t}@success");
        return $this->redirect()->toRoute( 'login' );
    }
    
    public function defaultTenantAction()
    {   
        $defaults = $this->getSessionDefaults();
        $dTenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $_POST['te_id'] ] );
        if( !$dTenant )
        {
            $this->flashmessenger()->addMessage( "{t}Tenant not found.{/t}@danger" );
            return $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
        }
        
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
        
        if( array_key_exists( $dTenant->getTeId(), $aTenants ) )                                                                                                    
        {
            $this->setDefaultTenant( $dTenant->getTeId() );
            $this->flashmessenger()->addMessage( "{t}Current tenant is switced to {/t}{$dTenant->getTeName()}.@success" );
            return $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
        }
        else
        {
            $this->flashmessenger()->addMessage( "{t}Tenant not found{/t}.@danger" );
            return $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
        }
    }        
}