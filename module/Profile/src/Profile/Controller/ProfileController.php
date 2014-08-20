<?php

namespace Profile\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Profile\Form\ProfileDataForm;
use Profile\Form\ChangePasswordForm;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;  

class ProfileController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;

    public function indexAction()
    {
        if( !$this->getServiceLocator()->get( 'AuthService' )->hasIdentity() )
            return $this->redirect()->toRoute( 'login' );
        
        $dataForm = $this->resolveProfileDataForm();
        
        $pwdForm = new ChangePasswordForm();
        $pwdForm->setAttribute( 'action', '/profile/index' );
        
        $dataForm->prepare();
        $pwdForm->prepare();
        
        if( $this->getRequest()->isPost() )
        {
            if( isset( $_POST['submit_data'] ) )
            {
                $dataForm->setData( $this->getRequest()->getPost() );
                if( $dataForm->isValid() )
                {
                    if( !$this->updateProfile( $dataForm->getData() ) )
                    {
                       if( $this->getPest()->lastStatus() == 406 )
                       {
                           $dataForm->get( 'username' )->setMessages( [ 'This user name already in use' ] );
                           return $this->finalise( [ 'dataForm' => $dataForm, 'pwdForm' => $pwdForm ] );
                       }
                       else
                           return false;
                    }
                    else 
                        return true;
                
                }
                else
                    $dataForm->get( 'conf_password' )->setValue( "" );
                    
            }
            
            if( isset( $_POST['submit_pwd'] ) )
            {
                $pwdForm->setData( $this->getRequest()->getPost() );
                if( $pwdForm->isValid() )
                {
                    if( $pwdForm->get( 'password' )->getValue() != $pwdForm->get( 'ret_password' )->getValue() )
                    {
                        $pwdForm->get( 'password' )->setMessages( [ "Passwords doesn't match" ] );
                        $pwdForm->get( 'ret_password' )->setMessages( [ "Password doesn't match" ] );
                        $pwdForm->get( 'conf_password' )->setValue( "" );
                    }
                    else
                    {
                        return $this->changePassword( $pwdForm->getData() );
                    }
                }
                else
                    $pwdForm->get( 'conf_password' )->setValue( "" );
            }
        }
        
        return $this->finalise( [ 'dataForm' => $dataForm, 'pwdForm' => $pwdForm ] );
        
    }
    
    private function resolveProfileDataForm()
    {
        $form = new ProfileDataForm();
        $form->setAttribute( 'action', '/profile/index' );
        $form->get( 'name' )->setValue( $this->identity()['name'] );
        $form->get( 'username' )->setValue( $this->identity()['username'] );
        $form->get( 'email' )->setValue( $this->identity()['email'] );
        
        return $form;
    }    
    
    /**
     * Changes profile information.
     * 
     * Validates current password against API and updates profile data in API.
     *
     * @param array $data Data form Profile\Form\ChangePasswordForm.
     * @return void
     */
    private function updateProfile( $data )
    {
        if( !$this->validPassword( $data['conf_password'] ) )
            return;
        
        $password = $data['conf_password'];
        unset( $data['submit_data'] );
        unset( $data['conf_password'] );    
        
        if( !$this->updateProfileData( $data, 'Profile information' ) )
            return;                
          
        $this->getSessionStorage()->forgetMe(); 
        $this->getAuthService()->clearIdentity();      

        $this->getAuthService()->getAdapter()
            ->setIdentity( $data['username'] )   
            ->setCredential( $password );
                                                                                                                  
        $result = $this->getAuthService()->authenticate();                                                                                                                                          
                
        return;
    }
    
    /**
     * Changes user passwrod.
     * 
     * Validates current password against API and updates profile data in API.
     *
     * @param array $data Data form Profile\Form\ChangePasswordForm.
     * @return void
     */
    private function changePassword( $data )
    {
        if( !$this->validPassword( $data['conf_password'] ) )
            return;
                
        unset( $data['submit_pwd'] );
        unset( $data['ret_password'] );
        unset( $data['conf_password'] );
        
        if( !$this->updateProfileData( $data, 'Password' ) )
            return;
        //Additional acctions if password changes succsfully
            
        return;             
    }
    
    /**
     * Verifies password against API for updating profile.
     *
     * Tries to call authentication again and if result is OK then it return true else false
     *
     * @param string $password Users password.
     * @return bool
     */
    private function validPassword( $password )
    {
        $this->callAPIGet( $success, "auth/username/" . $this->identity()['username'] . "/password/" . $password );
        if( !$success )
        {
            $this->flashmessenger()->addMessage( "Password provided is incorect@danger" );
            $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
            return false;
        }
        return true;
    }
    
    /**
     * Sends update profile request.
     *
     * @param array  $data Data to post to API for updating profile.
     * @param string $name Name off data package, like password or profile information.
     * @return bool
     */
    private function updateProfileData( $data, $name )
    {
        $result = $this->callAPIPost( $success, "profile", $data );
        if( !$success )
        {
            if( $result['code'] == 406 )
                return false;
            
            $this->flashmessenger()->addMessage( "Failed to update your " . lcfirst( $name ) . ". Plese try again later.@danger" );
            $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
            return false;
        }
                
        $this->flashmessenger()->addMessage( ucfirst( $name ) . " updated succesfully@success" );
        $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
        return true;
    }
    
}