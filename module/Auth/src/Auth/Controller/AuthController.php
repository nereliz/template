<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Auth\Form\LoginForm;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;
use Application\Traits\APITrait;
use Application\Traits\AuthTrait;


class AuthController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    use APITrait;
    use AuthTrait;
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'auth', [ 'action' => 'login' ] );
    }
        
    public function loginAction()
    {
        $form = new LoginForm();
        $form->setAttribute( 'action', '/auth/login' );
        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
          
            if( $form->isValid() )
            {
                
                $this->getAuthService()->getAdapter()
                    ->setIdentity( $form->get( 'username' )->getValue() )
                    ->setCredential( $form->get( 'password' )->getValue() );
                                                                                                                                      
                $result = $this->getAuthService()->authenticate();
                                
                if( $result->isValid() )
                {
                    if( $form->get( 'rememberme' )->getValue() )
                    {
                        $this->getSessionStorage()->setRememberMe( 1 );
                        //set storage again
                        $this->getAuthService()->setStorage( $this->getSessionStorage() );
                    }
                    $this->flashmessenger()->addMessage( "You've been logged in@success" );
                    $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
                    
                    $this->getServiceLocator()->get( 'Logger' )->debug( $form->get( 'username' )->getValue() . " user loged in" );
                    
                }
                else
                {
                    $this->flashmessenger()->addMessage( "Login failed@danger" );
                    $this->redirect()->toRoute( 'auth', [ 'action'=> 'login' ] );
                }
                    
            }            
        }
        
        $form->prepare();
                
        return $this->finalise( [ 'form' => $form ] );
    }
    
    public function logoutAction()
    {
        if( $this->identity() )
        {
            $username = $this->identity()['username'];
            $this->getSessionStorage()->forgetMe();
            $this->getAuthService()->clearIdentity();
            
            $this->getServiceLocator()->get( 'Logger' )->debug( $username . " user loged out" );             
            $this->flashmessenger()->addMessage( "You've been logged out@success" );
        }
        else
            $this->flashmessenger()->addMessage( "You need to login first@danger" );
            
        $this->redirect()->toRoute( 'auth', [ 'action'=> 'login' ] );
    }
        
}