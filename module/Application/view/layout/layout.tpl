{$this->doctype()}
{$identity = $this->identity()}
<html lang="en">
  <head>
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
					->appendStylesheet( "`$basePath`/css/chosen.min.css" )
                    ->appendStylesheet( "`$basePath`/css/style.css" )}

    <!-- Scripts -->
    {$this->headScript()->appendFile( "`$basePath`/js/html5.js", 'text/javascript', [ 'conditional' => 'lt IE 9' ] )
                                  ->appendFile( "`$basePath`/js/jquery-1.11.1.min.js")
								  ->appendFile( "`$basePath`/js/bootstrap.min.js" )
								  ->appendFile( "`$basePath`/js/bootbox.min.js" )
								  ->appendFile( "`$basePath`/js/chosen.jquery.min.js" )
								  ->appendFile( "`$basePath`/js/ngn.js" )}

  </head>

  <body>
	{if !isset( $config )}
   		<div class="navbar navbar-default navbar-fixed-top">
      	  <div class="container">
				 <div class="navbar-header">
             		<a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" type="button">
                	<span class="icon-bar"></span>
                		<span class="icon-bar"></span>
                		<span class="icon-bar"></span>
            		</a>
		  		</div>
          		<div class="collapse navbar-collapse">
            		<ul class="nav navbar-nav">
	              		<li ><a href="{$this->url( 'home' )}">{$this->translate( 'Home' )}</a></li>
            		</ul>
          		</div><!--/.nav-collapse -->
        	</div>
    	</div>
	{else}
		{include file=$config['template']['layout/topmenu']}
	{/if}

    <div class="container">
	
	<div class="page-content">
      {$this->content}

    </div>
		
	<br/>
	<br/>
    <footer>
		<p>&copy; 2013 - {date('Y')} by Nerijus Barauskas. All rights reserved.</p>
    </footer>

    </div> <!-- /container -->

  </body>
</html>
