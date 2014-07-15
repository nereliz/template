<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;
use Application\Traits\APITrait;
use Application\Model\Countries;

use Admin\Form\AddCustomerForm;
use Admin\Form\EditCustomerForm;

class CustomerController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    use APITrait;
    
    public function indexAction()
    {
        $this->redirect()->toRoute( 'customer', [ 'action' => 'list' ] );
    }

    public function listAction()
    {
        if( !$this->isAuth( 'operator' ) )
            return false;
        
        $customers = $this->callAPIGet( $success, "/admin/customers" );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Failed to get customers.@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return false;
        }

        return $this->finalise( [ 'customers' => $customers ] );
    }
    
    public function addAction()
    {
        if( !$this->isAuth( 'operator' ) )
            return false;
            
        $form = $this->resolveForm();
        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                $data['address'] = $data['address_line1'] . "," . $data['address_line2'];
                $data['country'] = Countries::getCountryName( $data['country'] );
                
                unset( $data['submit'] );
                unset( $data['address_line1'] );
                unset( $data['address_line2'] );
                                
                $result = $this->callAPIPost( $success, "/admin/customers", $data );
                if( !$success )
                {
                    $this->flashmessenger()->addMessage( "Failed to add customer.@danger" );
                    $this->redirect()->toRoute( 'customer', [ 'action'=> 'index' ] );
                    return false;
                }

                $this->flashmessenger()->addMessage( "Customer was added successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "Administrator %s add customer with name %s and id %d" , $this->identity()['username'], $data['name'], $result['customers_id'] ) );
                $this->redirect()->toRoute( 'customer', [ 'action'=> 'list' ] );
                return true;
            }
        }        
        
        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );     
    }
    
    public function editAction()
    {
        if( !$this->isAuth( 'operator' ) )
            return false;
            
        $customer = $this->callAPIGet( $success, "/admin/customers/" . $this->params( 'customers_id' ) );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Failed to get customer.@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return false;
        }
        
        $form = $this->resolveForm( $customer );
        
        if( $this->getRequest()->isPost() )
        {
            $form->setData( $this->getRequest()->getPost() );
            if( $form->isValid() )
            {
                $data = $form->getData();
                $data['address'] = $data['address_line1'] . "," . $data['address_line2'];
                $data['country'] = Countries::getCountryName( $data['country'] );
                                
                unset( $data['submit'] );
                unset( $data['address_line1'] );
                unset( $data['address_line2'] );
                
                $this->callAPIPost( $success, "/admin/customers/" . $this->params( 'customers_id' ), $data );
                if( !$success )
                {
                    $this->flashmessenger()->addMessage( "Failed to edit customer.@danger" );
                    $this->redirect()->toRoute( 'customer', [ 'action'=> 'index' ] );
                    return false;
                }

                $this->flashmessenger()->addMessage( "Customer was edited successfully.@success" );
                $this->getServiceLocator()->get( 'Logger' )->debug( sprintf( "Administrator %s edited customer with id %s" , $this->identity()['username'], $this->params( 'customers_id' ) ) );
                $this->redirect()->toRoute( 'customer', [ 'action'=> 'list' ] );
                return true;
            }
        }                                                
                
        $form->prepare();
        return $this->finalise( [ 'form' => $form ] );
    }
    
    /*public function removeAction()
    {
        if( !$this->isAuth() )
            return false;        
    }*/
    
    private function resolveForm( $customer = false )
    {
        if( !$customer)
        {
            $form = new AddCustomerForm();
            $form->setAttribute( 'action', '/admin/customer/add' );
            $form->get( 'country' )->setAttribute( 'options',  Countries::getCountriesArray() );
            $form->get( 'type' )->setAttribute( 'options', $this->config['defaults']['customer']['types'] );
            
            return $form;            
        }
        
        $form = new EditCustomerForm();
        $form->setAttribute( 'action', '/admin/customer/edit/' . $customer['id'] );
        $form->get( 'name' )->setValue( $customer['name'] );
        $form->get( 'type' )->setAttribute( 'options', $this->config['defaults']['customer']['types'] );
        $form->get( 'type' )->setValue( $customer['type'] );
        $form->get( 'contact' )->setValue( $customer['contact'] );
        $form->get( 'email' )->setValue( $customer['email'] );
        
        $address = explode( ',', $customer['address'] );
        $form->get( 'address_line1' )->setValue( $address[0] );
        if( isset( $address[1] ) )
            $form->get( 'address_line2' )->setValue( $address[1] );
        
        $form->get( 'city' )->setValue( $customer['city'] );
        $form->get( 'state' )->setValue( $customer['state'] );
        $form->get( 'country' )->setAttribute( 'options',  Countries::getCountriesArray() );
        $form->get( 'country' )->setValue( Countries::getCountryCode( $customer['country'] ) );
        
        return $form;
    }    
}