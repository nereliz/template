<?php

namespace Profile\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

use Profile\Form\ChangePasswordForm;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;  

use Profile\Model\Profile;
use Profile\Model\ProfilePassword;

class ProfileController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    
    protected $storage;
    protected $authservice;
        
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

    public function indexAction()
    {
        $em = $this->getEManager();
        $conn = $em->getConnection();
        $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        
        if( !$this->getServiceLocator()->get( 'AuthService' )->hasIdentity() )
            return $this->redirect()->toRoute( 'login' );
        
        $dataForm = $this->resolveProfileDataForm();
        $pwdForm = $this->resolveProfilePasswordForm();
        
        $dataForm->prepare();
        $pwdForm->prepare();
        
        if( $this->getRequest()->isPost() )
        {
            if( isset( $_POST['submit_data'] ) )
            {
                $dataForm->setData( $this->getRequest()->getPost() );
                if( $dataForm->isValid() )
                {
                    $result = $this->updateProfile( $dataForm->getData() );
                    switch( $result )
                    {
                        case 1:
                            $this->flashmessenger()->addMessage( "Username updated successfully.@success" );
                            return $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
                            break;

                        case 2:
                            $dataForm->get( 'conf_password' )->setMessages( [ "Invalid Password." ] );
                            $dataForm->get( 'conf_password' )->setValue( "" );
                            break;

                        case 3:
                            $dataForm->get( 'us_username' )->setMessages( [ "This username is already in use." ] );
                            $dataForm->get( 'conf_password' )->setValue( "" );
                            break;

                        default:
                            $this->flashmessenger()->addMessage( "Unexpected erro occured please try again later.@danger" );
                            return $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
                            break;
                    }
                }
                else
                    $dataForm->get( 'conf_password' )->setValue( "" );
                    
            }
            
            if( isset( $_POST['submit_pwd'] ) )
            {
                $pwdForm->setData( $this->getRequest()->getPost() );
                if( $pwdForm->isValid() )
                {
                    $result = $this->changePassword( $pwdForm->getData() );
                    switch( $result )
                    {
                        case 1:
                            $this->flashmessenger()->addMessage( "Password updated successfully.@success" );
                            return $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
                            break;

                        case 2:
                            $pwdForm->get( 'conf_password' )->setMessages( [ "Invalid Password." ] );
                            $pwdForm->get( 'conf_password' )->setValue( "" );
                            $pwdForm->get( 'us_password' )->setValue( "" );
                            $pwdForm->get( 'ret_password' )->setValue( "" );
                            break;

                        case 3:
                            $pwdForm->get( 'us_password' )->setMessages( [ "Passwords doesn't match" ] );
                            $pwdForm->get( 'ret_password' )->setMessages( [ "Passwords doesn't match" ] );
                            $pwdForm->get( 'conf_password' )->setValue( "" );
                            $pwdForm->get( 'us_password' )->setValue( "" );
                            $pwdForm->get( 'ret_password' )->setValue( "" );
                            break;

                        default:
                            $this->flashmessenger()->addMessage( "Unexpected erro occured please try again later.@danger" );
                            return $this->redirect()->toRoute( 'profile', [ 'action'=> 'index' ] );
                            break;
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
        $profile = new Profile();
        $builder = new AnnotationBuilder();
        $form    = $builder->createForm( $profile );
        $form->setAttribute( 'method', 'post' );
        $form->setAttribute( 'class', 'form-horizontal' );
        $form->setAttribute( 'action', '/profile/index' );
        $form->get( 'us_username' )->setValue( $this->getIdentity()->getUsUsername() );

        return $form;                                                                                                         
    }
    
    private function resolveProfilePasswordForm()
    {
        $profilePwd = new ProfilePassword();
        $builder = new AnnotationBuilder();
        $form    = $builder->createForm( $profilePwd );
        $form->setAttribute( 'method', 'post' );
        $form->setAttribute( 'class', 'form-horizontal' );
        $form->setAttribute( 'action', '/profile/index' );

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
            return 2;
            
        if( $data['us_username'] == $this->getIdentity()->getUsUsername() )
            return 1;
            
        $em = $this->getEManager();
        $user = $em->getRepository( 'Application\\Entity\\UsUsers' )->findOneBy( [ 'usUsername' => $data['us_username'] ] );
        
        if( $user ) 
            return 3;
        else
            $user = $em->getRepository( 'Application\\Entity\\UsUsers' )->findOneBy( [ 'usUsername' => $this->getIdentity()->getUsUsername() ] );

        $user->setUsUsername( $data['us_username'] );
        $em->flush();
          
        $this->getAuthService()->getStorage()->write( $user );
        return 1;
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
            return 2;
            
        if( $data['us_password'] != $data['ret_password'] )
            return 3;
        
        $em = $this->getEManager();
        $user = $em->getRepository( 'Application\\Entity\\UsUsers' )->findOneBy( [ 'usUsername' => $this->getIdentity()->getUsUsername() ] );

        $user->setUsPassword( $user->hashPassword( $data['us_password'] ) );
        $em->flush();
          
        $this->getAuthService()->getStorage()->write( $user );
        return 1;                
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
        if( $this->getIdentity()->hashPassword( $password ) == $this->getIdentity()->getUsPassword() )
            return true;
        
        return false;
    }    
}