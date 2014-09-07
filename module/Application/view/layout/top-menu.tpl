    <div class="navbar-header">
           <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" type="button">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
           </a>
           {if isset( $config ) }
               <a class="navbar-brand" href="{$this->url('home')}">{$config['site']['name']}</a>
	    {/if}
       </div>
       <div class="collapse navbar-collapse">
           <ul class="nav navbar-nav">
               {if !$auth->hasIdentity()}
                    <li>
						<a href="{$this->url('home')}" data-toggle="tooltip" title="{$this->translate( 'Home' )}"><span class="glyphicon glyphicon-home"></span></a>
					</li>
               {else}
					{if $idty->getUpUserprofile()->getUpid() == 1}
						<li>
							<a href="{$this->url('home')}">{$this->translate( 'Administrator' )}</span></a>
						</li>	
					{/if}
               {/if}
           </ul>
			
            {if $auth->hasIdentity()}
               <ul class="nav navbar-nav navbar-right">
                   <li {if $this->ngnview()->getController() == 'Profile\Controller\Profile' }class="active"{/if}>
				       <a href="{$this->url( 'profile', [ 'action'=>'index' ] )}" data-toggle="tooltip" title="{$this->translate( 'Profile' )}"><span class="glyphicon glyphicon-user"></span></a>
				   </li>
                   <li>
					   <a href="{$this->url( 'auth', [ 'action' => 'logout'] )}" data-toggle="tooltip" title="{$this->translate( 'Log out' )}"><span class="glyphicon glyphicon-off"></span></a>
				   </li>
               </ul>
			{/if}
			{if $auth->hasIdentity() && count( $idty->getTeTenants() )}
				<form class="navbar-form navbar-right" style="margin-right: 0px;">
					<div class="form-group">
						<select class="form-control" id="main_te">
							{foreach $idty->getTeTenants() as $tenant}
								<option value="{$tenant->getTeId()}">{$tenant->getTeName()}</option>
							{/foreach}
						</select>
					</div>
				</form>
			{/if}
				
        </div><!--/.nav-collapse -->

<script type="text/javascript">
	$( "#main_te" ).chosen();
	console.log( "done" );
</script>