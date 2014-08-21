{$title = 'Profile'}
{$this->headTitle( $title )}


<div class="page-header">
	<div clas="container-fluid">
		<h1>{$this->escapeHtml( $title )}</h1>
	</div>
</div>

<div class="page-contnet">
<div class="container-fluid">

	{include file=$config['template']['layout/messages'] }
	<div class="row">
		<div class="col-md-6">
			<legend>Profle Information</legend>
			{$form = $this->dataForm}
			{$this->form()->openTag( $form )}

			{foreach $form as $element }
				{include file=$config['template']['form/element'] element=$element}
			{/foreach}
			{$this->form()->closeTag()} 
		</div>
		<div class="col-md-6">
			<legend>Change Password</legend>
			{$form = $this->pwdForm}
			{$this->form()->openTag( $form )}

			{foreach $form as $element }
				{include file=$config['template']['form/element'] element=$element}
			{/foreach}
			{$this->form()->closeTag()} 
		</div>
	</div>
</div>
</div>