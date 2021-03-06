<html lang="en">
  <head>
	{include file="`$smarty.current_dir`/head.tpl"}
	{$this->headLink()->appendStylesheet( "`$this->basePath`/css/ua-style.css" )}
  </head>

  <body>
	<div class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            {if !isset( $config )}
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
            {else}
                {include file=$config['template']['layout/topmenu']}
            {/if}
        </div>
    </div>

    <div class="container">
	
	<div class="page-content">
      {$this->content}

    </div>
		
    </div> <!-- /container -->

	<div class="footer">
      <div class="container">
		<br />
        <p class="text-muted">
            &copy; 2014 - {date('Y')} by Nerijus Barauskas. All rights reserved.       
        </p>
      </div>
    </div>

  </body>
</html>
