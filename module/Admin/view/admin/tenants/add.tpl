{$title = 'Add User'}
{$this->headTitle( $title )}

<div class="page-header">
<div class="container-fluid">
	<h1>
		<div class="pull-right">
        	<a class="btn btn-default btn-sm have-tooltip" title="Go back" href="{$this->url( 'admin_users', [ 'action'=> 'list' ] )}"><span class="glyphicon glyphicon-arrow-left"></span></a>
    	</div>
		{$this->escapeHtml( $title )}
	</h1>
</div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">


{include file=$config['template']['layout/messages'] }

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">

{$form = $this->form}
{$this->form()->openTag( $form )}

{foreach $form as $element }
	{include file=$config['template']['form/element'] element=$element}
{/foreach}

{$this->form()->closeTag()} 

</div>
<div class="col-md-3"></div>
</div>

</div>
</div>

<script type="text/javascript">
    $( "#profile" ).chosen();
    $( "#tenants" ).chosen();
    $( "#routing_profiles" ).chosen();

	$( "#password" ).val( genPassword( 8 ) );  
	$( "#password" ).parent( ).addClass( 'has-feedback' );
    $( "#password" ).parent( ).append( '<span id="gen_password" class="glyphicon glyphicon-refresh form-control-feedback" style="cursor: pointer" ></span>' );

    $( "#gen_password" ).on( "click", function(){
        $( "#password" ).val( genPassword( 8 ) );  
    });

</script>
