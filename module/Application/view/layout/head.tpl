
<meta charset="utf-8">
{if isset( $config ) }
   {$this->headTitle( {$config['site']['name']}  )->setSeparator(' - ')->setAutoEscape(false)}
{else}
    {$this->headTitle( 'Error'  )->setSeparator(' - ')->setAutoEscape(false)}
{/if}
{$basePath = $this->basePath}

{$this->headMeta()->appendName( 'viewport', 'width=device-width, initial-scale=1.0' )}

<!-- Le styles -->
{$this->headLink( [ 'rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => "`$basePath`/images/favicon.ico" ] )
    ->appendStylesheet( "`$basePath`/css/bootstrap.min.css" )
    ->appendStylesheet( "`$basePath`/css/bootstrap-theme.min.css" )
	->appendStylesheet( "`$basePath`/css/bootstrap-sticky-footer.css" )
    ->appendStylesheet( "`$basePath`/css/chosen.min.css" )
	->appendStylesheet( "`$basePath`/css/jquery-ui.min.css" )
	->appendStylesheet( "`$basePath`/css/jquery-ui.theme.min.css" )
	->appendStylesheet( "`$basePath`/css/jquery.dataTables.min.css" )
	->appendStylesheet( "`$basePath`/css/jquery.asmselect.css" )
    ->appendStylesheet( "`$basePath`/css/style.css" )}

<!-- Scripts -->
{$this->headScript()->appendFile( "`$basePath`/js/html5.js", 'text/javascript', [ 'conditional' => 'lt IE 9' ] )
    ->appendFile( "`$basePath`/js/jquery-1.11.1.min.js")
	->appendFile( "`$basePath`/js/jquery-migrate-1.2.1.min.js" )
	->appendFile( "`$basePath`/js/jquery-ui.min.js" )
    ->appendFile( "`$basePath`/js/bootstrap.min.js" )   
    ->appendFile( "`$basePath`/js/bootbox.min.js" )  
    ->appendFile( "`$basePath`/js/chosen.jquery.min.js" )
	->appendFile( "`$basePath`/js/jquery.dataTables.min.js" )
	->appendFile( "`$basePath`/js/jquery.asmselect.js" )
    ->appendFile( "`$basePath`/js/ngn.js" )}
