
{if $element->getAttribute( 'type' ) != 'checkbox' && $element->getAttribute( 'type' ) != 'hidden' && $element->getAttribute( 'type' ) != 'radio'}

<div class="form-group {if $this->formElementErrors( $element )}has-error{/if}">
    <label class="control-label col-lg-4">{include file="eval:{$element->getLabel()}"}</label>
    <div class="col-lg-8">
        {include file="eval:{$this->formElement( $element )}"}
        {if $this->formElementErrors( $element )} 
            <span class="help-inline text-danger">
                <ul class="list-unstyled">
                    {foreach $element->getMessages() as $error }
                        <li>{include file="eval:{$error}"}</li>
                    {/foreach}
                </ul>
            </span>
        {/if}
    </div>
</div>

{elseif $element->getAttribute( 'type' ) == 'checkbox'}

<div class="form-group">
	<label class="control-label col-lg-4"></label>
    <div class="col-lg-8">
        <div class="checkbox">
            <label>
                {include file="eval:{$this->formElement( $element )}"}{include file="eval:{$element->getLabel()}"}
            </label>
            {if $this->formElementErrors( $element )} 
                <span class="help-inline text-danger">
                    <ul class="list-unstyled">
                    {foreach $element->getMessages() as $error }
                        <li>{include file="eval:{$error}"}</li>
                    {/foreach}
                    </ul>
                </span>
            {/if}
        </div>
    </div>
</div>

{elseif $element->getAttribute( 'type' ) == 'radio'}

<div class="form-group">
    <label class="control-label col-lg-4">{include file="eval:{$element->getLabel()}"}</label>
    <div class="col-lg-8">
        {include file="eval:{$this->formElement( $element )}"}
        {if $this->formElementErrors( $element )} 
           <span class="help-inline text-danger">
                <ul class="list-unstyled">
                {foreach $element->getMessages() as $error }
                   <li>{include file="eval:{$error}"}</li>
                {/foreach}
                </ul>
            </span>
        {/if}
    </div>
</div>
{elseif $element->getAttribute( 'type' ) == 'multicheckbox'}

<div class="form-group">
	<label class="control-label col-lg-4">{include file="eval:{$element->getLabel()}"}</label>
    <div class="col-lg-8">
        {include file="eval:{$this->formElement( $element )}"}
        {if $this->formElementErrors( $element )} 
           <span class="help-inline text-danger">
                <ul class="list-unstyled">
                {foreach $element->getMessages() as $error }
                   <li>{include file="eval:{$error}"}</li>
                {/foreach}
                </ul>
            </span>
        {/if}
    </div>
</div>
{elseif $element->getAttribute( 'type' ) == 'hidden'}
    {$this->formElement( $element )}

{/if}
