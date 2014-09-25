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

    protected $entity_name = "Application\\Entity\\UsUsers";
    protected $entity_prefix = "us";
    protected $main_route = "admin_users";
        
    public function indexAction()
    {
        $this->redirect()->toRoute( $this->main_route, [ 'action' => "list" ] );
    }
        
    public function listAction()
    {
        if( !$this->isAuth( 1 ) )
            return false;
        
        return $this->finalise( [ 'objects' => $this->getEManager()->getRepository( $this->entity_name )->findAll() ] );
    }
    
    public function addAction()
    {
        if( !$this->isAuth( 1 ) )
            return false;
            
        $form = $this->resolveForm();        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                unset( $data['submit'] );
                
                $object = new \Application\Entity\UsUsers();
                
                $tmp = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usUsername' => $data['us_username'] ] );
                if( $tmp )
                {
                    $form->get( 'us_username' )->setMessages( [ '{t}This user name already in use{/t}' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                else
                    $object->setUsUsername( $data['us_username'] );
                
                if( !$data['us_password'] )
                {    
                    $form->get( 'us_password' )->setMessages( [ '{t}This value can not be empty{/t}' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                else
                    $object->setUsPassword( $object->hashPassword( $data['us_password'] ) );
                
                $profile = $this->getEManager()->getRepository( "Application\\Entity\\UpUserprofiles" )->findOneBy( [ 'upId' => $data['up_id'] ] );
                $object->setUpUserProfile( $profile );
                
                if( $data['te_ids'] )
                {
                    foreach( $data['te_ids'] as $teid )
                    {
                        $tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $teid ] );
                        if( !$object->getTeTenants()->contains( $tenant ) )
                            $object->getTeTenants()->add( $tenant );
                    }
                }
                        
                if( $data['rp_ids'] )
                {
                    foreach( $data['rp_ids'] as $rpid )
                    {
                        $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $rpid ] );
                        if( !$object->getRpRoutingprofiles()->contains( $rprofile ) )
                            $object->getRpRoutingprofiles()->add( $rprofile );
                    }
                }

                try{
                    $this->getEManager()->persist( $object );
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "{t}Failed to add User.{/t}@danger" );
                    $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "{t}User was added successfully.{/t}@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id  %s added new user with id %s" , $this->getIdentity()->getUsId(), $object->getUsId() ) );
                $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
                return true;
            }
        }

        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function editAction()
    {
        if( !$this->isAuth( 1 ) || !( $object = $this->getRequestedObject( false ) ) )
            return false;

        $form = $this->resolveForm( $object );

        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                
                if( $data['us_username'] != $object->getUsUsername() )
                {
                    $tmp = $this->getEManager()->getRepository( "Application\\Entity\\UsUsers" )->findOneBy( [ 'usUsername' => $data['us_username'] ] );
                    if( $tmp )
                    {
                        $form->get( 'us_username' )->setMessages( [ '{t}This user name already in use{/t}' ] );
                        return $this->finalise( [ 'form' => $form ] );
                    }
                    $object->setUsUsername( $data['us_username'] );
                }
                
                if( $data['us_password'] )
                    $object->setUsPassword( $object->hashPassword( $data['us_password'] ) );
                
                if( $data['up_id'] != $object->getUpUserprofile()->getUpId() )
                {
                    $profile = $this->getEManager()->getRepository( "Application\\Entity\\UpUserprofiles" )->findOneBy( [ 'upId' => $data['up_id'] ] );
                    $object->setUpUserProfile( $profile );
                }
                
                if( $data['te_ids'] )
                {
                    foreach( $data['te_ids'] as $teid )
                    {
                        $tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $teid ] );
                        if( !$object->getTeTenants()->contains( $tenant ) )
                            $object->getTeTenants()->add( $tenant );
                    }
                }
                else
                    $data['te_ids'] = array();
                    
                foreach( $object->getTeTenants() as $tenant )
                    if( !in_array( $tenant->getTeId(), $data['te_ids'] ) )
                        $object->getTeTenants()->removeElement( $tenant );
                        
                if( $data['rp_ids'] )
                {
                    foreach( $data['rp_ids'] as $rpid )
                    {
                        $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $rpid ] );
                        if( !$object->getRpRoutingprofiles()->contains( $rprofile ) )
                            $object->getRpRoutingprofiles()->add( $rprofile );
                    }
                }
                else
                    $data['rp_ids'] = array();
                    
                foreach( $object->getRpRoutingprofiles() as $rprofile )
                    if( !in_array( $rprofile->getRpId(), $data['rp_ids'] ) )
                        $object->getRpRoutingprofiles()->removeElement( $rprofile );
                
                try{
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "{t}Failed to edit User.{/t}@danger" );
                    $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "{t}User was edited successfully.{/t}@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s edited user with id %s" , $this->getIdentity()->getUsId(), $object->getUsId() ) );
                $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
                return true;
            }
        }

        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function removeAction()
    {
        if( !$this->isAuth( 1 ) || !( $object = $this->getRequestedObject( false ) ) )
            return false;
        
        try{
            $this->getEManager()->remove( $object );
            $this->getEManager()->flush();
        }
        catch( Exception $e )
        {
            $this->flashmessenger()->addMessage( "{t}Failed to remove user.{/t}@danger" );
            $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
            return false;
        }
                
        $this->flashmessenger()->addMessage( "{t}User was removed successfully.{/t}@success" );
        $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s removed user with id %s" , $this->getIdentity()->getUsId(), $this->params( 'us_id'  ) ) );
        $this->redirect()->toRoute( $this->main_route, [ 'action'=> "list" ] );
        
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