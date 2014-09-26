<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\ConfigAwareInterface;
use Application\Traits\HelperTrait;

class IndexController extends AbstractActionController
    implements ConfigAwareInterface
{
    use HelperTrait;
    public function indexAction()
    {
        if( $this->getAuth()->hasIdentity() )
        {
            $defaults = $this->getSessionDefaults();
            if( isset( $defaults->prev_url ) && $defaults->prev_url )
                return $this->redirect()->toUrl( $defaults->prev_url );
            else                                                
                $this->redirect()->toRoute( 'config_ivrs', [ 'action' => 'index' ] );
        }
        else
            $this->redirect()->toRoute( 'auth', [ 'action' => 'login' ] );
    }

}
