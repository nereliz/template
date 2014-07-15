{if $element->getAttribute( 'type' ) != 'checkbox' && $element->getAttribute( 'type' ) != 'hidden'}

<div class="form-group {if $this->formElementErrors( $element )}has-error{/if}">
    <label class="control-label col-lg-4">{$element->getLabel()}</label>
    <div class="col-lg-8">
        {$this->formElement( $element )}
            {if $this->formElementErrors( $element )} 
                <span class="help-inline text-danger">
                    <ul class="list-unstyled">
                    {foreach $element->getMessages() as $error }
                        <li>{$error}</li>
                    {/foreach}
                    </ul>
                </span>
            {/if}
    </div>
</div>

{elseif $element->getAttribute( 'type' ) == 'checkbox'}

<div class="form-group">
    <div class="col-lg-offset-4 col-lg-8">
        <div class="checkbox">
            <label>
                {$this->formElement( $element )}{$element->getLabel()}
            </label>
            {if $this->formElementErrors( $element )} 
                <span class="help-inline text-danger">
                    <ul class="list-unstyled">
                    {foreach $element->getMessages() as $error }
                        <li>{$error}</li>
                    {/foreach}
                    </ul>
                </span>
            {/if}
        </div>
    </div>
</div>

{elseif $element->getAttribute( 'type' ) == 'hidden'}

    {$this->formElement( $element )}

{/if}
