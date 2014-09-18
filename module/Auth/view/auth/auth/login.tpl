
<div class="page-header">
    <h1>{t}Login{/t}</h1>
    {$this->headTitle( $this->translate('Login') )}
</div>

{include file=$config['template']['layout/messages']}

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6">

{$form = $this->form}
{$this->form()->openTag( $form )}
{foreach $form->getElements() as $element}
    {include file=$config['template']['form/element'] element=$element}
{/foreach}

{$this->form()->closeTag()}

</div>
<div class="col-md-3"></div>
</div>

