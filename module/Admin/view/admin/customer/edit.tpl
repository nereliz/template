{$title = 'Edit Customer'}
{$this->headTitle( $title )}

<div class="page-header">
	<h1>
		<div class="pull-right">
			<a class="btn btn-default btn-sm have-tooltip" title="Go back" href="{$this->url( 'customer', [ 'action'=> 'list' ] )}"><span class="glyphicon glyphicon-arrow-left"></span></a>
		</div>
		{$this->escapeHtml( $title )}
	</h1>
</div>


{include file=$config['template']['layout/messages'] }

{$form = $this->form}
{$this->form()->openTag( $form )}

<div class="row">
<div class="col-md-6">

<legend >Customer Information</legend>

{include file=$config['template']['form/element'] element=$form->get( 'name' )}
{include file=$config['template']['form/element'] element=$form->get( 'type' )}
{include file=$config['template']['form/element'] element=$form->get( 'contact' )}
{include file=$config['template']['form/element'] element=$form->get( 'email' )}

</div>
<div class="col-md-6">

<legend>Customer Address</legend>

{include file=$config['template']['form/element'] element=$form->get( 'address_line1' )}
{include file=$config['template']['form/element'] element=$form->get( 'address_line2' )}
{include file=$config['template']['form/element'] element=$form->get( 'city' )}
{include file=$config['template']['form/element'] element=$form->get( 'state' )}
{include file=$config['template']['form/element'] element=$form->get( 'country' )}

</div>

</div>

<div class="row">
<div class="col-md-12">
	{include file=$config['template']['form/element'] element=$form->get( 'submit' )}
</div>


</div>

{$this->form()->closeTag()} 