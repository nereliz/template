<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2 col-md-1 sidebar">
			<ul class="nav nav-sidebar">
				<li {if $this->ngnview()->getController() == "Admin\\Controller\\Users"}class="active"{/if}>
					<a href="{$this->url( 'admin_users', [ 'action'=> 'list' ])}">Users</a>
				</li>
				<li {if $this->ngnview()->getController() == "Admin\\Controller\\Tenants"}class="active"{/if}>
					<a href="{$this->url( 'admin_tenants', [ 'action'=> 'list' ])}">Tenants</a>
				</li>
			</ul>
		</div>
		<div class="col-sm-10 col-sm-offset-2 col-md-11 col-md-offset-1 main">

