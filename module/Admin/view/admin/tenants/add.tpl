
{$title = 'Add Tenant'}
{$this->headTitle( $title )}

<div class="page-header">
<div class="container-fluid">
	<h1>
		<div class="pull-right">
        	<a class="btn btn-default btn-sm have-tooltip" title="Go back" href="{$this->url( 'admin_tenants', [ 'action'=> 'list' ] )}"><span class="glyphicon glyphicon-arrow-left"></span></a>
    	</div>
		{$this->escapeHtml( $title )}
	</h1>
</div>
</div>

<div class="page-contnet" style="padding-left: 20px; padding-right: 20px;">
<div class="container-fluid">


{include file=$config['template']['layout/messages'] }


{$form = $this->form}
{$this->form()->openTag( $form )}

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#home" role="tab" data-toggle="tab">General</a></li>
  <li><a href="#settings" role="tab" data-toggle="tab">Settings</a></li>
</ul>
<br/>
<div class="tab-content">
<div class="tab-pane active" id="home">
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">

{include file=$config['template']['form/element'] element=$form->get('teName')}
{include file=$config['template']['form/element'] element=$form->get('teCode')}
{include file=$config['template']['form/element'] element=$form->get('teTimezone')}
{include file=$config['template']['form/element'] element=$form->get('teDisabled')}
{include file=$config['template']['form/element'] element=$form->get('teAlertemail')}
{include file=$config['template']['form/element'] element=$form->get('pkStart')}
{include file=$config['template']['form/element'] element=$form->get('pkEnd')}


</div>

<div class="col-md-5">

{include file=$config['template']['form/element'] element=$form->get('teBillingcode')}
{include file=$config['template']['form/element'] element=$form->get('tePaymentType')}
{include file=$config['template']['form/element'] element=$form->get('clId')}
{include file=$config['template']['form/element'] element=$form->get('rpId')}
{include file=$config['template']['form/element'] element=$form->get('teAllowedip')}

</div>
<div class="col-md-1"></div>
</div>
</div>

<div class="tab-pane" id="settings">
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">

{$tmp = array( 'channels', 'ivrs', 'hunts', 'disas','conferences','queues','campaigns', 'phonebooks', 'provisioning', 'agiscripts', 'conduits' ) }

{foreach $tmp as $type }
	{$limit = $form->get('settings')->get("limited_`$type`")}
	{$max = $form->get('settings')->get("teMax`$type`")}
	{$opts = $limit->getValueOptions()}
	<div class="form-group ">
		<label class="control-label col-lg-4">{$max->getLabel()}</label>
		<div class="col-lg-8">
			<span style="float: left;">
			<label class="radio-inline">
				<input type="radio" id="{$type}_unlimited" value="false" name="{$limit->getName()}" "checked"="checked">
				{$opts['false']}
			</label>
			<label class="radio-inline">
				<input type="radio" id="{$type}_limited" value="true" name="{$limit->getName()}">
				{$opts['true']}
			</label>
			</span>
			<span class="col-xs-4"> <input id="max{$type}" class="form-control" type="text" value="{$max->getValue()}" name="{$max->getName()}" value="-1"></span>
		</div>			
	</div>
	    
{/foreach}

</div>

<div class="col-md-5">
{$tmp = array('extensions', 'voicemails', 'dids', 'mediafiles', 'conditions', 'pagings', 'flows', 'customs', 'features', 'shortnumbers', 'calleridblacklist')}
{foreach $tmp as $type }
	{$limit = $form->get('settings')->get("limited_`$type`")}
	{$max = $form->get('settings')->get("teMax`$type`")}
	{$opts = $limit->getValueOptions()}
	<div class="form-group ">
		<label class="control-label col-lg-4">{$max->getLabel()}</label>
		<div class="col-lg-8">
			<span style="float: left;">
			<label class="radio-inline">
				<input type="radio" id="{$type}_unlimited" value="false" name="{$limit->getName()}" "checked"="checked">
				{$opts['false']}
			</label>
			<label class="radio-inline">
				<input type="radio" id="{$type}_limited" value="true" name="{$limit->getName()}">
				{$opts['true']} 
			</label>
			</span>
			<span class="col-xs-4"> <input id="max{$type}" class="form-control" type="text" value="{$max->getValue()}" name="{$max->getName()}" value="-1"></span>
		</div>			
	</div>
	    
{/foreach}
</div>
<div class="col-md-1"></div>
</div>
</div>

<script type="text/javascript">

	var types = ['ivrs','hunts','disas', 'extensions', 'voicemails', 'dids', 'channels','conferences','queues','campaigns',
		'mediafiles', 'conditions', 'pagings', 'flows', 'customs', 'features', 'shortnumbers', 'calleridblacklist',
		'agiscripts', 'conduits', 'phonebooks', 'provisioning'
		];
                
    types.forEach( function( type ){
		if( $( '#max' + type ).val() && $( '#max' + type ).val() > -1  )
           $( '#' + type + '_limited' ).trigger( 'click' );
		else
		{
			$( '#' + type + '_unlimited' ).trigger( 'click' );
            $( '#max' + type ).val( '' );
		}

                        
        $( '#' + type + '_unlimited' ).on( 'click', function(){
           $( '#max' + type ).val( '' );
        });

		$( '#' + type + '_limited' ).on( 'change', function(){
		   $( '#max' + type ).trigger( 'focus' );
        });
          
        $( '#max' + type ).on( 'focus', function(){  
			if( !$('#' + type + '_limited').is(":checked") )
	            $( '#' + type + '_limited' ).trigger( 'click' );
        });
                    
        $( '#max' + type ).on( 'blur', function(){
            if( !$( '#max' + type ).val().match(/^[1-9][0-9]$/) && !$( '#max' + type ).val().match(/^[0-9]$/) && !$( '#max' + type ).val().match(/^[1-9][0-9][0-9]$/) )
		        $( '#' + type + '_unlimited' ).trigger( 'click' );
        } );
	});
</script>

</div>
<div class="row">
<div class="col-md-10"></div>
<div class="col-md-1">
	{$this->formElement( $form->get('submit_data') )}
</div>
<div class="col-md-1"></div>
</div>

{$this->form()->closeTag()} 


</div>
</div>
