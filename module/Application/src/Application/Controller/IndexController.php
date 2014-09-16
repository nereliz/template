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
            $this->redirect()->toRoute( 'config_ivrs', [ 'action' => 'index' ] );
        else
            $this->redirect()->toRoute( 'auth', [ 'action' => 'login' ] );
    }

}
