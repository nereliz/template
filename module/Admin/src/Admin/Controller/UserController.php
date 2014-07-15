<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;
use Application\Traits\APITrait;

use Admin\Form\AddUserForm;
use Admin\Form\EditUserForm;

class UserController extends AbstractActionController
    implements ConfigAwareInterface
{
    use APITrait;
    use HelperTrait;
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'administrator', [ 'action', 'list' ] );
    }
        
    public function listAction()
    {
        if( !$this->isAuth() )
            return false;
            
        $users = $this->callAPIGet( $success, "/admin/users" );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Failed to get administrators.@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return false;
        }
        
        return $this->finalise( [ 'users' => $users ] );
        
    }
    
    public function addAction()
    {
        if( !$this->isAuth() )
            return false;
            
        $form = $this->resolveForm();        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                unset( $data['submit'] );                

                $result = $this->callAPIPost( $success, "/admin/users", $data );
                if( !$success )
                {
                    if( $result['code'] == 406 )
                    {
                        $form->get( 'username' )->setMessages( [ 'This user name already in use' ] );
                        return $this->finalise( [ 'form' => $form ] );
                    }
                    $this->flashmessenger()->addMessage( "Failed to add administrator.@danger" );
                    $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "Administrator was added successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "Administrator %s added new administrator %s" , $this->identity()['username'], $data['username'] ) );
                $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
                return true;
            }
        }

        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function editAction()
    {
        if( !$this->isAuth() )
            return false;
            
        $user = $this->callAPIGet( $success, "/admin/users/" . $this->params( 'username' ) );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Failed to retrieve administrator.@danger" );
            $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
            return false;
        }

        $form = $this->resolveForm( $user );

        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                unset( $data['submit'] );                
                
                $result = $this->callAPIPost( $success, "/admin/users/" . $this->params( 'username' ), $data );
                if( !$success )
                {
                    if( $result['code'] == 406 )
                    {
                        $form->get( 'new_username' )->setMessages( [ 'This user name already in use' ] );
                        return $this->finalise( [ 'form' => $form ] );
                    }
                    $this->flashmessenger()->addMessage( "Failed to edit administrator.@danger" );
                    $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "Administrator was edited successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "Administrator %s edited administrator %s" , $this->identity()['username'], $data['new_username'] ) );
                $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
                return true;
            }
        }

        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function removeAction()
    {
        if( !$this->isAuth() )
            return false;
        
        $this->callAPIDelete( $success, "/admin/users", [ 'username' => $this->params( 'username' ) ]  );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Failed to remove administrator.@danger" );
            $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
            return false;
        }
                
        $this->flashmessenger()->addMessage( "Administrator was removed successfully.@success" );
        $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "Administrator %s removed administrator %s" , $this->identity()['username'], $this->params( 'username'  ) ) );
        $this->redirect()->toRoute( 'administrator', [ 'action'=> 'list' ] );
        
        return true; 
    }
        
    private function resolveForm( $user = false )
    {
        if( !$user )
        {
            $form = new AddUserForm();
            $form->setAttribute( 'action', '/admin/user/add' );
        }
        else
        {
            $form = new EditUserForm();
            $form->setAttribute( 'action', '/admin/user/edit/' . $this->params( 'username' ) );
        
            $form->get( 'new_username' )->setValue( $user['username'] );
            $form->get( 'name'     )->setValue( $user['name'] );
            $form->get( 'email'    )->setValue( $user['email'] );
            $form->get( 'read_only' )->setChecked( $user['read_only'] );
        }
        
        if( $this->identity()['type'] != 'operator' )
        {
            $form->remove( 'customers_id' );
        }
        else
        {
            $customers = $this->callAPIGet( $success, '/admin/customers' );
            $custs = [ $this->identity()[ 'customers_id' ] => $this->identity()[ 'company' ] ];
            foreach( $customers as $customer )
                $custs[ $customer[ 'id' ] ] = $customer[ 'name' ];

            $form->get( 'customers_id' )->setAttribute( 'options', $custs );
            if( $user )
                $form->get( 'customers_id' )->setValue( $user['customers_id'] );
        }
        
        $form->prepare();
        return $form;
    }    
}