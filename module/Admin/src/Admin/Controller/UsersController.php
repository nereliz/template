<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;

use Admin\Model\User;

class UsersController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'admin_users', [ 'action' => 'list' ] );
    }
        
    public function listAction()
    {
        if( !$this->getAuth()->hasIdentity() || $this->getIdentity()->getUpUserprofile()->getUpId() != 1 )
        {
            $this->redirect()->toRoute( 'index', [ 'action' => "index" ] );
            return false;
        }
        
        $em = $this->getEManager();
        $users = $em->getRepository('Application\\Entity\\UsUsers')->findAll();
        if( !$users )
        {
            $this->flashmessenger()->addMessage( "Failed to get users.@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return false;
        }
        
        return $this->finalise( [ 'users' => $users ] );
        
    }
    
    public function addAction()
    {
        if( !$this->getAuth()->hasIdentity() || $this->getIdentity()->getUpUserprofile()->getUpId() != 1 )
        {
            $this->redirect()->toRoute( 'index', [ 'action' => "index" ] );
            return false;
        }
            
        $form = $this->resolveForm();        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                unset( $data['submit'] );
                
                $user = new \Application\Entity\UsUsers();
                
                $tmp = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usUsername' => $data['us_username'] ] );
                if( $tmp )
                {
                    $form->get( 'us_username' )->setMessages( [ 'This user name already in use' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                else
                    $user->setUsUsername( $data['us_username'] );
                
                if( !$data['us_password'] )
                {    
                    $form->get( 'us_password' )->setMessages( [ 'This value can not be empty' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                else
                    $user->setUsPassword( $user->hashPassword( $data['us_password'] ) );
                
                $profile = $this->getEManager()->getRepository( "Application\\Entity\\UpUserprofiles" )->findOneBy( [ 'upId' => $data['up_id'] ] );
                $user->setUpUserProfile( $profile );
                
                if( $data['te_ids'] )
                {
                    foreach( $data['te_ids'] as $teid )
                    {
                        $tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $teid ] );
                        if( !$user->getTeTenants()->contains( $tenant ) )
                            $user->getTeTenants()->add( $tenant );
                    }
                }
                        
                if( $data['rp_ids'] )
                {
                    foreach( $data['rp_ids'] as $rpid )
                    {
                        $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $rpid ] );
                        if( !$user->getRpRoutingprofiles()->contains( $rprofile ) )
                            $user->getRpRoutingprofiles()->add( $rprofile );
                    }
                }

                try{
                    $this->getEManager()->persist( $user );
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "Failed to add User.@danger" );
                    $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "User was added successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id  %s added new user with id %s" , $this->getIdentity()->getUsId(), $user->getUsId() ) );
                $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
                return true;
            }
        }

        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function editAction()
    {
        if( !$this->getAuth()->hasIdentity() || $this->getIdentity()->getUpUserprofile()->getUpId() != 1 )
        {
            $this->redirect()->toRoute( 'index', [ 'action' => "index" ] );
            return false;
        }
            
        $user = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usId' => $this->params( 'us_id' ) ] );
        if( !$user )
        {
            $this->flashmessenger()->addMessage( "Failed to retrieve User.@danger" );
            $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
            return false;
        }

        $form = $this->resolveForm( $user );

        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                
                if( $data['us_username'] != $user->getUsUsername() )
                {
                    $tmp = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usUsername' => $data['us_username'] ] );
                    if( $tmp )
                    {
                        $form->get( 'us_username' )->setMessages( [ 'This user name already in use' ] );
                        return $this->finalise( [ 'form' => $form ] );
                    }
                    $user->setUsUsername( $data['us_username'] );
                }
                
                if( $data['us_password'] )
                    $user->setUsPassword( $user->hashPassword( $data['us_password'] ) );
                
                if( $data['up_id'] != $user->getUpUserprofile()->getUpId() )
                {
                    $profile = $this->getEManager()->getRepository( "Application\\Entity\\UpUserprofiles" )->findOneBy( [ 'upId' => $data['up_id'] ] );
                    $user->setUpUserProfile( $profile );
                }
                
                if( $data['te_ids'] )
                {
                    foreach( $data['te_ids'] as $teid )
                    {
                        $tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $teid ] );
                        if( !$user->getTeTenants()->contains( $tenant ) )
                            $user->getTeTenants()->add( $tenant );
                    }
                }
                else
                    $data['te_ids'] = array();
                    
                foreach( $user->getTeTenants() as $tenant )
                    if( !in_array( $tenant->getTeId(), $data['te_ids'] ) )
                        $user->getTeTenants()->removeElement( $tenant );
                        
                if( $data['rp_ids'] )
                {
                    foreach( $data['rp_ids'] as $rpid )
                    {
                        $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $rpid ] );
                        if( !$user->getRpRoutingprofiles()->contains( $rprofile ) )
                            $user->getRpRoutingprofiles()->add( $rprofile );
                    }
                }
                else
                    $data['rp_ids'] = array();
                    
                foreach( $user->getRpRoutingprofiles() as $rprofile )
                    if( !in_array( $rprofile->getRpId(), $data['rp_ids'] ) )
                        $user->getRpRoutingprofiles()->removeElement( $rprofile );
                
                try{
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "Failed to edit User.@danger" );
                    $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "User was edited successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s edited user with id %s" , $this->getIdentity()->getUsId(), $user->getUsId() ) );
                $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
                return true;
            }
        }

        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function removeAction()
    {
        if( !$this->getAuth()->hasIdentity() || $this->getIdentity()->getUpUserprofile()->getUpId() != 1 )
        {
            $this->redirect()->toRoute( 'index', [ 'action' => "index" ] );
            return false;
        }
            
        $user = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usId' => $this->params( 'us_id' ) ] );
        if( !$user )
        {
            $this->flashmessenger()->addMessage( "Failed to retrieve User.@danger" );
            $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
            return false;
        }
        
        try{
            $this->getEManager()->remove( $user );
            $this->getEManager()->flush();
        }
        catch( Exception $e )
        {
            $this->flashmessenger()->addMessage( "Failed to remove user.@danger" );
            $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
            return false;
        }
                
        $this->flashmessenger()->addMessage( "User was removed successfully.@success" );
        $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s removed user with id %s" , $this->getIdentity()->getUsId(), $this->params( 'us_id'  ) ) );
        $this->redirect()->toRoute( 'admin_users', [ 'action'=> 'list' ] );
        
        return true; 
    }
        
    private function resolveForm( $user = false )
    {
        $muser = new User(); 
        $builder = new AnnotationBuilder();
        $form    = $builder->createForm( $muser );
        
        $form->setAttribute( 'method', "post" );
        $form->setAttribute( 'class', "form-horizontal" );
        $form->setAttribute( 'action', "/admin/users/" . ( $user ? "edit/{$user->getUsId()}" : "add" ) );
        $form->get( 'up_id' )->setValueOptions( $this->getEManager()->getRepository( "Application\\Entity\\UpUserprofiles" )->getNamesIdsList() );
        $form->get( 'te_ids' )->setValueOptions( $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->getNamesIdsList() );
        $form->get( 'rp_ids' )->setValueOptions( $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->getNamesIdsList() );
        
        if( $user )
        {
            $form->get( 'us_username' )->setValue( $user->getUsUsername() );
            $form->get( 'up_id' )->setValue( $user->getUpUserprofile()->getUpId() );
            $form->get( 'te_ids' )->setValue( array_keys( $user->getTeTenantNames() ) );
            $form->get( 'rp_ids' )->setValue( array_keys( $user->getRpRoutingprofilesNames() ) );
        }
        else
        {
            $form->get( 'up_id' )->setValue( 3 );
        }
        
        return $form;
    }    
}