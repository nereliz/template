{$title = 'Users'}
{$this->headTitle( $title )}

<div class="page-header">
	<div class="container-fluid">
		<h2>{$this->escapeHtml( $title )}</h2>
	</div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">

{include file=$config['template']['layout/messages'] }

<table class="table table-responsive table-striped datatable" >
	<thead>
		<tr>
			<th>Username</th>
			<th>Profile</th>
			<th><a class="btn btn-default btn-xs have-tooltip" title="Add User" href="{$this->url( 'admin_users',[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a></th>
		</tr>
	</thead>
	<tbody>
		{foreach $users as $user}
			<tr>
				<td>{$user->getUsUsername()}</td>
				<td>{$user->getUpUserprofile()->getUpName()}</td>
				<td>
					<div class="btn-group btn-group-xs">
						{if $idty->getUsUsername() != $user->getUsUsername() }
							<a class="btn btn-default have-tooltip" title="Edit" href="{$this->url( 'admin_users', [ 'action' => 'edit', 'us_id' => $user->getUsId()] )}"><span class="glyphicon glyphicon-pencil"></span></a>
							<a id="list-remove-{$user@index}"class="btn btn-default have-tooltip" title="Remove" href="{$this->url( 'admin_users', [ 'action' => 'remove', 'us_id' => $user->getUsId()] )}"><span class="glyphicon glyphicon-trash"></span></a>
						{else}
							<a class="btn btn-default have-tooltip" title="Edit Profile" href="{$this->url('profile', [ 'action' => 'index' ] )}"><span class="glyphicon glyphicon-pencil"></span></a>
						{/if}
					</div>
				</td>
			</tr>
		{foreachelse }
			<tr>
				<td colspan="3" style="align: center">Where are no records to show</td>
			</tr>
		{/foreach}
	</tbody>
</table> 

</div>
</div>
<script type="text/javascript">

{if count( $users ) }
$(document).ready( function(){
	$( ".datatable" ).DataTable({
		"order": [[ 1, "asc" ]],
		'aoColumns': [
    	    null,
        	null,
	        { 'bSortable': false, "bSearchable": false }
    	]
	});
});
{/if}
$( "a[id|='list-remove']" ).on( 'click', function( event ){
	event.preventDefault();
	bootbox.dialog({
		message: "Are you shure you want to delete selected object",
		title: "Are you shure?",
		buttons: {
			danger: {
				label: "Remove",
				className: "btn-danger",
				callback: function() {
					window.location = $( event.delegateTarget ).attr( "href" );
				}
			},
			main: {
				label: "Cancel",
				className: "btn-default",
			}
		}
	});
});
</script>
