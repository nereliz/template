{$title = 'Tenants'}
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
			<th>Name</th>
			<th>Code</th>
			<th># Channels</th>
			<th># Extensions</th>
			<th># Dids</th>
			<th>Alerts</th>
			<th><a class="btn btn-default btn-xs have-tooltip" title="Add Tenant" href="{$this->url( 'admin_tenants',[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a></th>
		</tr>
	</thead>
	<tbody>
		{foreach $tenants as $tenant}
			<tr>
				<td>{$tenant->getTeName()}</td>
				<td>{$tenant->getTeCode()}</td>
				<td>{$tenant->getTeMaxchannels()}</td>
				<td>{count( $tenant->getExExtensions() )} / {$tenant->getTeMaxExtensions()}</td>
				<td>{count( $tenant->getDiDids() )} / {$tenant->getTeMaxDids()}</td>
				<td>{$tenant->getTeAlertemail()}</td>
				<td>
					<div class="btn-group btn-group-xs">
						<a class="btn btn-default have-tooltip" title="Edit" href="{$this->url( 'admin_tenants', [ 'action' => 'edit', 'te_id' => $tenant->getTeId()] )}"><span class="glyphicon glyphicon-pencil"></span></a>
						<a id="list-remove-{$tenant@index}"class="btn btn-default have-tooltip" title="Remove" href="{$this->url( 'admin_tenants', [ 'action' => 'remove', 'te_id' => $tenant->getTeId()] )}"><span class="glyphicon glyphicon-trash"></span></a>
					</div>
				</td>
			</tr>
		{foreachelse}
            <tr>
                <td colspan="7" style="align: center">Where are no records to show</td>
            </tr>
		{/foreach}
	</tbody>
</table> 

</div>
</div>
<script type="text/javascript">

{if count($tenants) }
$( document ).ready( function() {
	$( ".datatable" ).DataTable({
		"order": [[ 0, "asc" ]],
		'aoColumns': [
    	    null,
        	null,
			null,
			null,
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
