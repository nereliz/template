<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
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
                {if !$this->identity()}
                     <li><a href="{$this->url('home')}">{$this->translate( 'Home' )}</a></li>
                {else}
                     <li class="dropdown {if $this->ngnview()->getController() == 'Admin\Controller\User' }active{/if}">
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                             Adminstration
                             <b class="caret"></b>
                         </a>
                         <ul class="dropdown-menu">
                            <li {if $this->ngnview()->getController() == 'Admin\Controller\User' }class="active"{/if}>
                                <a href="{$this->url( 'administrator', [ 'action', 'index' ] )}" >Administrators</a>
                            </li>
                            {if $identity['type'] == 'operator'}
                                 <li {if $this->ngnview()->getController() == 'Admin\Controller\Customer' }class="active"{/if}>
                                      <a href="{$this->url( 'customer', [ 'action', 'index' ] )}" >Customers</a>
                                 </li>
                            {/if}
                        </ul>
                    </li>
                    <li {if $this->ngnview()->getController() == 'Profile\Controller\Profile' }class="active"{/if}><a href="{$this->url( 'profile', [ 'action'=>'index' ] )}">{$this->translate( 'Profile' )}</a></li>
                {/if}
            </ul>
            {if $this->identity()}
                <ul class="nav navbar-nav navbar-right">
                    <li ><a href="{$this->url( 'auth', [ 'action' => 'logout'] )}">{$this->translate( 'Log out' )}</a></li>
                </ul>
			{/if}
				
        </div><!--/.nav-collapse -->
    </div>
</div>

