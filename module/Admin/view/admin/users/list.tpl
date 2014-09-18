<div class="page-header">
    <div class="container-fluid">
        <h2>{t}Users{/t}</h2>
	{$this->headTitle( $this->translate( 'Users' ) )}
    </div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">

{include file=$config['template']['layout/messages'] }

<table class="table table-responsive table-striped datatable" >
    <thead>
        <tr>
            <th>{t}Username{/t}</th>
            <th>{t}Profile{/t}</th>
            <th><a class="btn btn-default btn-xs have-tooltip" title="{t}Add New{/t}" href="{$this->url( 'admin_users',[ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a></th>
        </tr>
    </thead>
    <tbody>
        {foreach $users as $user}
            <tr>
                <td>{$user->getUsUsername()}</td>
                <td>{t}{$user->getUpUserprofile()->getUpName()}{/t}</td>
                <td>
                    <div class="btn-group btn-group-xs">
                        {if $idty->getUsUsername() != $user->getUsUsername() }
                            <a class="btn btn-default have-tooltip" title="{t}Edit{/t}" href="{$this->url( 'admin_users', [ 'action' => 'edit', 'us_id' => $user->getUsId()] )}"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a id="list-remove-{$user@index}"class="btn btn-default have-tooltip" title="{t}Remove{/t}" href="{$this->url( 'admin_users', [ 'action' => 'remove', 'us_id' => $user->getUsId()] )}"><span class="glyphicon glyphicon-trash"></span></a>
                        {else}
                            <a class="btn btn-default have-tooltip" title="{t}Edit Profile{/t}" href="{$this->url('profile', [ 'action' => 'index' ] )}"><span class="glyphicon glyphicon-pencil"></span></a>
                        {/if}
                    </div>
                </td>
            </tr>
        {foreachelse }
            <tr>
                <td colspan="3" style="align: center">{t}Where are no records to show{/t}</td>
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
});
</script>
