<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        if( $this->identity() )
            $this->redirect()->toRoute( 'profile', [ 'action' => 'index' ] );
        else
            $this->redirect()->toRoute( 'auth', [ 'action' => 'index' ] );
    }

}
