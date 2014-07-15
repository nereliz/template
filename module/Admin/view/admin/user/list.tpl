{$identity = $this->identity()}
{$title = 'Administrators'}
{$this->headTitle( $title )}

<div class="page-header">
	<h1>{$this->escapeHtml( $title )}</h1>
</div>

{include file=$config['template']['layout/messages'] }

<table class="table">
	<theader>
		<tr>
			<th>Name</th>
			{if $identity['type'] == 'operator' }
				<th>Company</th>
			{/if}
			<th>Username</th>
			<th>Email</th>
			<th>Write access</th>
			<th>{if !$identity['read_only']}<a class="btn btn-default btn-xs have-tooltip" title="Add Administrator" href="{$this->url( 'administrator',[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a>{/if}</th>
		</tr>
	</theader>
	<tbody>
		{foreach $users as $user}
			<tr>
				<td>{$user['name']}</td>
				{if $identity['type'] == 'operator'}
					<td>{$user['company']}</td>
				{/if}
				<td>{$user['username']}</td>
				<td>{$user['email']}</td>
				<td>
					{if !$user['read_only']}
						<span class="glyphicon glyphicon-ok"></span>
					{else}
						<span class="glyphicon glyphicon-remove"></span>
					{/if}
				</td>				
				<td>
					<div class="btn-group btn-group-xs">
						{if !$identity['read_only'] && $identity['username'] != $user['username'] }
							<a class="btn btn-default have-tooltip" title="Edit" href="{$this->url( 'administrator', [ 'action' => 'edit', 'username' => $user['username'] ] )}"><span class="glyphicon glyphicon-pencil"></span></a>
							<a id="list-remove-{$user@index}"class="btn btn-default have-tooltip" title="Remove" href="{$this->url( 'administrator', [ 'action' => 'remove', 'username' => $user['username'] ] )}"><span class="glyphicon glyphicon-trash"></span></a>
						{elseif $identity['username'] == $user['username']}
							<a class="btn btn-default have-tooltip" title="Edit Profile" href="{$this->url('profile', [ 'action' => 'index' ] )}"><span class="glyphicon glyphicon-pencil"></span></a>
						{/if}
					</div>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table> 

<script type="text/javascript">
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