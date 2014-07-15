<?php

namespace Application\Traits;

trait HelperTrait{
    
    protected $config;
    
    public function setConfig( $config )
    {
        $this->config = $config;
    }
                        
    
    public function finalise( $data )
    {
        return $data + [ 'messages' => $this->flashmessenger()->getMessages(), 'config' => $this->config ];
    }
    
    /**
     * If auth neaded and users is not loged in redirects to login.
     *
     * @param string|bool $type Identity type should be as given.
     * @return booln
     */
    private function isAuth( $type = false )
    {
        if( !$this->identity() )
        {
            $this->flashmessenger()->addMessage( "You need to loign first@danger" );
            $this->redirect()->toRoute( 'auth', [ 'action'=> 'login' ] );
            return flase;
        }

        if( $type && $this->identity()['type'] != $type )
        {
            $this->flashmessenger()->addMessage( "You do not have permisions to do this action@danger" );
            $this->redirect()->toRoute( 'index', [ 'action'=> 'index' ] );
            return flase;
        }

        return true;
    }
                                                                                                                                                                                       
}