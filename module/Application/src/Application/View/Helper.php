<?php 

namespace Application\View;

use Zend\View\Helper\AbstractHelper;

class Helper extends AbstractHelper
{

    protected $route;

    public function __construct( $route )
    {
        $this->route = $route;
    }

    public function getController()
    {
        $controller = $this->route->getParam( 'controller', 'index' );
        return $controller;
    }
    
    public function getAction()
    {
        $controller = $this->route->getParam( 'action', 'index' );
        return $controller;
    }
}