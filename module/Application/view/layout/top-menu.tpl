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
					<li {if $module_name == 'Config' }class="active"{/if}>
						<a href="{$this->url( 'config_ivrs', [ 'action'=> 'list' ])}">{$this->translate( 'Configurations' )}</span></a>
					</li>
					{if $idty->getUpUserprofile()->getUpid() == 1}
						<li {if $module_name == 'Admin' }class="active"{/if}>
							<a href="{$this->url( 'admin_users', [ 'action'=> 'list' ])}">{$this->translate( 'Administrator' )}</span></a>
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
			{if isset( $aTenants ) && count( $aTenants ) > 1 }
				<form class="navbar-form navbar-right" method="post" action="{$this->url( 'auth', [ 'action' => 'default_tenant'] )}" id="top_menu_def_tenant" style="margin-right: 0px;">
					<div class="form-group">
						<select class="form-control chosen" id="def_te_id" name="te_id">
							{foreach $aTenants as $idx => $name}
								<option value="{$idx}" {if $idx == $dTenant->getTeId()}selected="selected"{/if}>{$name}</option>
							{/foreach}
						</select>
					</div>
				</form>
			{/if}
				
        </div><!--/.nav-collapse -->

<script type="text/javascript">
	$( '#def_te_id' ).on( "change", function( event ){
		$( '#top_menu_def_tenant' ).submit();
	});
</script>