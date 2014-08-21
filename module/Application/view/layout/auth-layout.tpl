{$identity = $this->identity()}
<html lang="en">
  <head>
	{include file="`$smarty.current_dir`/head.tpl"}
  </head>

  <body>
   		<div class="navbar navbar-default navbar-fixed-top">
      	  <div class="container-fluid">
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

   {$this->content}


    </div> <!-- /container -->

	<div class="footer">
      <div class="container">
        <p class="text-muted">
			&copy; 2013 - {date('Y')} by Nerijus Barauskas. All rights reserved.
		</p>
      </div>
    </div>

  </body>
</html>
