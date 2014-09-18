<div class="page-header">
    <div class="container-fluid">
        <h2>{t}Tenants{/t}</h2>
	{$this->headTitle( $this->translate( 'Tenants' ) )}
     </div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">

{include file=$config['template']['layout/messages'] }

<table class="table table-responsive table-striped datatable" >
    <thead>
        <tr>
            <th>{t}Name{/t}</th>
            <th>{t}Code{/t}</th>
            <th>{t}# Channels{/t}</th>
            <th>{t}# Extensions{/t}</th>
            <th>{t}# Dids{/t}</th>
            <th>{t}Alerts{/t}</th>
            <th><a class="btn btn-default btn-xs have-tooltip" title="{t}Add New{/t}" href="{$this->url( 'admin_tenants',[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a></th>
        </tr>
    </thead>
    <tbody>
    {foreach $tenants as $tenant}
    <tr>
        <td>{$tenant->getTeName()}</td>
        <td>{$tenant->getTeCode()}</td>
        <td>{$tenant->getTeMaxchannels()}</td>
        <td>{count( $tenant->getExExtensions() )} / {if $tenant->getTeMaxExtensions() >= 0}{$tenant->getTeMaxExtensions()}{else}{t}Unlimited{/t}{/if}</td>
        <td>{count( $tenant->getDiDids() )} / {if $tenant->getTeMaxDids() >= 0}{$tenant->getTeMaxDids()}{else}{t}Unlimited{/t}{/if}</td>
        <td>{$tenant->getTeAlertemail()}</td>
        <td>
           <div class="btn-group btn-group-xs">
                <a class="btn btn-default have-tooltip" title="{t}Edit{/t}" href="{$this->url( 'admin_tenants', [ 'action' => 'edit', 'te_id' => $tenant->getTeId()] )}"><span class="glyphicon glyphicon-pencil"></span></a>
                {* <a id="list-remove-{$tenant@index}"class="btn btn-default have-tooltip" title="{t}Remove{/t}" href="{$this->url( 'admin_tenants', [ 'action' => 'remove', 'te_id' => $tenant->getTeId()] )}"><span class="glyphicon glyphicon-trash"></span></a> *}
            </div>
        </td>
    </tr>
    {foreachelse}
        <tr>
            <td colspan="7" style="align: center">{t}Where are no records to show{/t}</td>
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

/*$( "a[id|='list-remove']" ).on( 'click', function( event ){
    event.preventDefault();
    bootbox.dialog({
        message: "{t}Are you shure you want to delete selected object?{/t}",
        title: "{t}Are you shure?{/t}",
        buttons: {
            danger: {
                label: "{t}Remove{/t}",
                className: "btn-danger",
                callback: function() {
                    window.location = $( event.delegateTarget ).attr( "href" );
                }
            },
            main: {
                label: "{t}Cancel{/t}",
                className: "btn-default",
            }
        }
    });
});*/
</script>
