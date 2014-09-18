<div class="page-header">
    <div clas="container-fluid">
    	<h1>{t}Profile{/t}</h1>
	{$this->headTitle( $this->translate( 'Profile' ))}
    </div>
</div>

<div class="page-contnet">
<div class="container-fluid">

    {include file=$config['template']['layout/messages'] }
    <div class="row">
        <div class="col-md-6">
            <legend>{t}Profle Information{/t}</legend>
            {$form = $this->dataForm}
            {$this->form()->openTag( $form )}

            {foreach $form as $element }
                {include file=$config['template']['form/element'] element=$element}
            {/foreach}
            {$this->form()->closeTag()} 
        </div>
        <div class="col-md-6">
            <legend>{t}Change Password{/t}</legend>
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