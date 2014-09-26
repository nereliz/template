<?php

namespace Application\Smarty;

class Plugins {

    public static function do_translation( $params, $content, $smarty, &$repeat, $template = false )
    {
        if( isset( $content ) )
        {   
            $translator = $smarty->getRegisteredObject( 'translator' );
            $lang = isset( $params["lang"] ) && $params["lang"] ? $params["lang"] : false;
            $domain = isset( $params["domain"] ) && $params["domain"] ? $params["domain"] : 'default';
            // do some translation with $content

            return $translator->translate( $content, $domain, $lang );
        }
    }
}