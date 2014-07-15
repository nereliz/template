{$title = 'Edit Administartor'}
{$this->headTitle( $title )}

<div class="page-header">
	<h1>
		<div class="pull-right">
        	<a class="btn btn-default btn-sm have-tooltip" title="Go back" href="{$this->url( 'administrator', [ 'action'=> 'list' ] )}"><span class="glyphicon glyphicon-arrow-left"></span></a>
    	</div>

		{$this->escapeHtml( $title )}
	</h1>
</div>

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
