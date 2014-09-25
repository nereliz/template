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
            <th><a class="btn btn-default btn-xs have-tooltip" title="{t}Add New{/t}" href="{$this->url( $main_route,[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a></th>
        </tr>
    </thead>
    <tbody>
    {foreach $objects as $object}
    <tr>
        <td>{$object->getTeName()}</td>
        <td>{$object->getTeCode()}</td>
        <td>{$object->getTeMaxchannels()}</td>
        <td>{count( $object->getExExtensions() )} / {if $object->getTeMaxExtensions() >= 0}{$object->getTeMaxExtensions()}{else}{t}Unlimited{/t}{/if}</td>
        <td>{count( $object->getDiDids() )} / {if $object->getTeMaxDids() >= 0}{$object->getTeMaxDids()}{else}{t}Unlimited{/t}{/if}</td>
        <td>{$object->getTeAlertemail()}</td>
        <td>
           <div class="btn-group btn-group-xs">
                <a class="btn btn-default have-tooltip" title="{t}Edit{/t}" href="{$this->url( $main_route, [ 'action' => 'edit', 'te_id' => $object->getTeId()] )}"><span class="glyphicon glyphicon-pencil"></span></a>
                {* <a id="list-remove-{$object@index}"class="btn btn-default have-tooltip" title="{t}Remove{/t}" href="{$this->url( $main_route, [ 'action' => 'remove', 'te_id' => $object->getTeId()] )}"><span class="glyphicon glyphicon-trash"></span></a> *}
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

{if count($objects) }
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

</script>

{include file=$config['template']['list/actions'] }