<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;

use Admin\Model\Tenant;
use Admin\Model\TenantSettings;

class TenantsController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'admin_tenants', [ 'action', 'list' ] );
    }
        
    public function listAction()
    {
        if( !$this->isAuth( 1 ) )
            return false;
        
        $em = $this->getEManager();
        $tenants = $em->getRepository('Application\\Entity\\TeTenants')->findAll();

        return $this->finalise( [ 'tenants' => $tenants ] );
        
    }
    
    public function addAction()
    {
        if( !$this->isAuth( 1 ) )
            $this->redirect()->toRoute( 'index', [ 'action' => "index" ] );
            
        $form = $this->resolveForm();        
        if( $this->getRequest()->isPost() )
        {
            $data = $this->getRequest()->getPost();
            $form->get( 'settings' )->setData( $data );
            $data['settings'] = $data;
            $form->setData( $data );
            if( $form->isValid() )
            {
                $data = $form->getData();
                unset( $data['submit'] );
                
                $tenant = new \Application\Entity\TeTenants();
                $pklot = new \Application\Entity\PkParkinglots();
                
                $tmp = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teName' => $data['teName'] ] );
                if( $tmp )
                {
                    $form->get( 'teName' )->setMessages( [ '{t}This name already in use{/t}' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                
                $tmp = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teCode' => $data['teCode'] ] );
                if( $tmp )
                {    
                    $form->get( 'teCode' )->setMessages( [ '{t}This code already in use{/t}' ] );
                    return $this->finalise( [ 'form' => $form ] );
                }
                
                foreach( $data['settings'] as $key => $value )
                {
                    if( substr( $key, 0, 8 ) == "limited_" )
                    {	
                        if( $value == "false" )
                            $data['teMax'.substr( $key, 8 )] = -1;
                        else
                            $data['teMax'.substr( $key, 8 )] = $data['settings']['teMax'.substr( $key, 8 )];
                    }
                }
                unset( $data['settings'] );
                
                $tzone = $this->getEManager()->getRepository( "Application\\Entity\\TzTimezones" )->findOneBy( [ 'tzId' => $data['teTimezone'] ] );
                $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $data['rpId'] ] );
                $clrate = $this->getEManager()->getRepository( "Application\\Entity\\ClClientrates" )->findOneBy( [ 'clId' => $data['clId'] ] );
                
                $tenant->updateFromArray( $data );                
                $tenant->setTeTimezone( $tzone ? $tzone->getTzName() : "" );
                $tenant->setRpRoutingprofile( $rprofile );
                $tenant->setClClientrate( $clrate );

                $pklot->updateFromArray( $data );
                $pklot->setPkName( $tenant->getTeName() );
                $pklot->setTeTenant( $tenant );
                
                $nodes = $this->getEManager()->getRepository( "Application\\Entity\\NoNodes" )->findAll();
                if( $nodes )
                {
                    $key = rand( 0, count( $nodes ) - 1 );
                    $pklot->setPkHosted( $nodes[$key]->getNoPeername() );
                }
                
                $dsettings = [ 'PARKTIMEOUT' => 120, 'MAXCALLDURATION'=> 7200, 'DIALTIMEOUT' => 60 ];
                foreach( $dsettings as $code => $value )
                {
                    $setting = new \Application\Entity\SeSettings();
                    $setting->setSeCode( $code );
                    $setting->setSeValue( $value );
                    $setting->setTeTenant( $tenant );
                    $this->getEManager()->persist( $setting );
                }
                
                try{
                    $this->getEManager()->persist( $pklot );
                    $this->getEManager()->persist( $tenant );
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "{t}Failed to add Tenant.{/t}@danger" );
                    $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "{t}Tenant was added successfully.{/t}@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id  %s added new tenant with id %s" , $this->getIdentity()->getUsId(), $tenant->getTeId() ) );
                $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
                return true;
            }
        }

        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function editAction()
    {
        if( !$this->isAuth( 1 ) || !( $tenant = $this->getRequestedTenant() ) )
            return false;

        $form = $this->resolveForm( $tenant );

        if( $this->getRequest()->isPost() )
        {
            $data = $this->getRequest()->getPost();
            $form->get( 'settings' )->setData( $data );
            $data['settings'] = $data;
            $form->setData( $data );
            if( $form->isValid() )
            {
                $data = $form->getData();
                
                if( $data['teName'] != $tenant->getTeName() )
                {
                    $tmp = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teName' => $data['teName'] ] );
                    if( $tmp )
                    {
                        $form->get( 'teName' )->setMessages( [ '{t}This name already in use{/t}' ] );
                        return $this->finalise( [ 'form' => $form ] );
                    }
                }
                
                foreach( $data['settings'] as $key => $value )
                {
                    if( substr( $key, 0, 8 ) == "limited_" )
                    {	
                        if( $value == "false" )
                            $data['teMax'.substr( $key, 8 )] = -1;
                        else
                            $data['teMax'.substr( $key, 8 )] = $data['settings']['teMax'.substr( $key, 8 )];
                    }
                }
                unset( $data['settings'] );
                
                $tzone = $this->getEManager()->getRepository( "Application\\Entity\\TzTimezones" )->findOneBy( [ 'tzId' => $data['teTimezone'] ] );
                
                $tenant->updateFromArray( $data );                
                $tenant->setTeTimezone( $tzone ? $tzone->getTzName() : "" );
                
                if( $data['rpId'] != $tenant->getRpRoutingprofile()->getRpId() )
                {
                    $rprofile = $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->findOneBy( [ 'rpId' => $data['rpId'] ] );
                    $tenant->setRpRoutingprofile( $rprofile );
                }
                
                if( $data['clId'] != $tenant->getClClientrate() )
                {
                    $clrate = $this->getEManager()->getRepository( "Application\\Entity\\ClClientrates" )->findOneBy( [ 'clId' => $data['clId'] ] );
                    $tenant->setClClientrate( $clrate );
                }

                $tenant->getPkParkinglot()->updateFromArray( $data );
                
                
                try{
                    $this->getEManager()->flush();
                }
                catch( Exception $e )
                {
                    $this->flashmessenger()->addMessage( "{t}Failed to edit Tenant.{/t}@danger" );
                    $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
                    return false;
                }
                
                $this->flashmessenger()->addMessage( "{t}Tenant was edited successfully.{/t}@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s edited tenant with id %s" , $this->getIdentity()->getUsId(), $tenant->getTeId() ) );
                $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
                return true;
            }
        }

        return $this->finalise( [ 'form' => $form ] );
        
    }
    
    public function removeAction()
    {    
        if( !$this->isAuth( 1 ) || !( $tenant = $this->getRequestedTenant() ) )
            return false;

        try{
            $this->getEManager()->remove( $tenant );
            $this->getEManager()->flush();
        }
        catch( Exception $e )
        {
            $this->flashmessenger()->addMessage( "{t}Failed to remove Tenant.{/t}@danger" );
            $this->redirect()->toRoute( 'admin_tenents', [ 'action'=> 'list' ] );
            return false;
        }
                
        $this->flashmessenger()->addMessage( "{t}Tenant was removed successfully.{/t}@success" );
        $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "User with id %s removed tenant with id %s" , $this->getIdentity()->getUsId(), $this->params( 'te_id'  ) ) );
        $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
        
        return true; 
    }
    
    protected function getRequestedTenant()
    {
        $tenant = $this->getEManager()->getRepository( "Application\\Entity\\TeTenants" )->findOneBy( [ 'teId' => $this->params( 'te_id' ) ] );
        if( !$tenant )
        {
            $this->flashmessenger()->addMessage( "{t}Failed to retrieve Tenant.{/t}@danger" );
            $this->redirect()->toRoute( 'admin_tenants', [ 'action'=> 'list' ] );
            return false;
        }
        
        return $tenant;
    }
        
    private function resolveForm( $tenant = false )
    {
        $mtenant = new Tenant(); 
        $settings = new TenantSettings();
        $builder = new AnnotationBuilder();
        $form    = $builder->createForm( $mtenant );
        $sform   = $builder->createForm( $settings );
        $sform->setName( "settings" );
        $sform->remove("submit_data");
        
        $form->setAttribute( 'method', "post" );
        $form->setAttribute( 'class', "form-horizontal" );
        $form->setAttribute( 'action', "/admin/tenants/" . ( $tenant ? "edit/{$tenant->getTeId()}" : "add" ) );
        $form->add( $sform );
        
        $form->get( 'clId' )->setValueOptions( [ '' => "{t}Do not apply call rate{/t}" ] + $this->getEManager()->getRepository( "Application\\Entity\\ClClientrates" )->getNamesIdsList() );
        $form->get( 'teTimezone' )->setValueOptions( [ '' => "{t}User server Default{/t}"] + $this->getEManager()->getRepository( "Application\\Entity\\TzTimezones" )->getNamesIdsList() );
        $form->get( 'rpId' )->setValueOptions( $this->getEManager()->getRepository( "Application\\Entity\\RpRoutingprofiles" )->getNamesIdsList() );
        
        if( $tenant )
        {
            $data = $tenant->toArray();
            $form->setData( $data );
            $form->get( 'settings' )->setData( $data );
            $form->get( 'teCode' )->setAttribute( "readonly", "readonly" );
            $form->get( 'pkStart' )->setValue( $tenant->getPkParkinglot()->getPkStart() );
            $form->get( 'pkEnd' )->setValue( $tenant->getPkParkinglot()->getPkEnd() );
            
            if( $tenant->getTeTimezone() )
            {
                $tzone = $this->getEManager()->getRepository( "Application\\Entity\\TzTimezones" )->findOneBy( ['tzName' => $tenant->getTeTimezone() ] );
                $form->get( 'teTimezone' )->setValue( $tzone ? $tzone->getTzId() : "" );
            }
        }
        
        return $form;
    }    
}