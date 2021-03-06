<div class="page-header">
    <div class="container-fluid">
    <h2>    
        <div class="pull-right">
            <a class="btn btn-default btn-sm have-tooltip" title="{t}Go back{/t}" href="{$this->url( $main_route, [ 'action'=> 'list' ] )}"><span class="glyphicon glyphicon-arrow-left"></span></a>
        </div>

        {t}Edit User{/t}
	{$this->headTitle( $this->translate( 'Edit User' ) )}
    </h2>
    </div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">

{include file=$config['template']['layout/messages'] }

<div class="row">
<div class="col-md-2"></div>
<div class="col-md-6">


{$form = $this->form}
{$this->form()->openTag( $form )}

{foreach $form as $element }
    {include file=$config['template']['form/element'] element=$element}
{/foreach}

{$this->form()->closeTag()} 

</div>
<div class="col-md-4"></div>
</div>

</div>
</div>

<script type="text/javascript">
    $( "#profile" ).chosen();
    $( "#tenants" ).chosen();
    $( "#routing_profiles" ).chosen();
    $( "#password" ).parent( ).addClass( 'has-feedback' );
    $( "#password" ).parent( ).append( '<span id="gen_password" class="glyphicon glyphicon-refresh form-control-feedback" style="cursor: pointer" ></span>' );

    $( "#gen_password" ).on( "click", function(){
        $( "#password" ).val( genPassword( 8 ) );
    });
</script>