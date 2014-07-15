<?php

namespace Application\Traits;

trait APITrait{
    /** 
     * Pest object
     * @var Pest
     */
    protected $pest;
    
    /**
     * Returns pest object if its not set creates new one   
     *
     * @var bool $oauth Oauth flag. If it setted to true then identity token is set as OAuth secret.
     * @return Pest
     */ 
    private function getPest( $oauth = true )
    {
        if( !$this->pest )
        {
            $this->pest = new \PestJSON( $this->config['ngn_api']['url'] );
            if( $oauth )
                $this->pest->curl_opts[ CURLOPT_HTTPHEADER ][]= 'Authorization: OAuth '. $this->identity()['token'];
        }
        return $this->pest;
    }
    
    private function callAPIGet( &$success, $uri, $data = [], $headers = [] )
    {
        try{
            $result = $this->getPest()->get( $uri . ".json", $data, $headers );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }
        
        if( isset( $result['meta'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return $result;
        }
    }
    
    private function callAPIPost( &$success, $uri, $data, $headers = [] )
    {
        try{
            $result = $this->getPest()->post( $uri . ".json", $data, $headers );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }

        if( isset( $result['meta']['result'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return false;
        }
    }
    
    private function callAPIPut( &$success, $uri, $data, $headers = [] )
    {
        try{
            $result = $this->getPest()->put( $uri . ".json", $data, $headers );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }
        
        if( isset( $result['meta'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return false;
        }
    }
    
    private function callAPIPatch( &$success, $uri, $data, $headers = [] )
    {
        try{
            $result = $this->getPest()->patch( $uri . ".json", $data, $headers );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }
        
        if( isset( $result['meta'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return false;
        }
    }
    
    private function callAPIDelete( &$success, $uri, $data, $headers = [] )
    {	
        $uri .= '.json?' . http_build_query( $data );
        try{
            $result = $this->getPest()->delete( $uri, $headers );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }
        
        if( isset( $result['meta'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return false;
        }
    } 
    
    private function callAPIHead( &$success, $uri )
    {
        try{
            $result = $this->getPest()->head( $uri . ".json" );
            $success = true;
        }
        catch( \Exception $e ) 
        {
            $success = false;
            $error = json_decode( $e->getMessage(), true );
            return [ 'code' => $this->getPest()->lastStatus(), 'message' => isset( $error['errors'][0]['message'] ) ? $error['errors'][0]['message'] : $e->getMessage() ];
        }
        
        if( isset( $result['meta'] ) &&  substr( $result['meta']['result'], 0, 2 ) == "OK" )
            return $result['content'];
        else
        {
            $success = false;
            return false;
        }
    }
    
    
}