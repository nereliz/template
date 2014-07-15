<div class="jumbotron">
<div class="container">

<h1>{$this->translate( 'A 404 error occurred' )}</h1>
<h2>{$this->message}</h2>

{if $this->reason }
	{if $this->reason == 'error-controller-cannot-dispatch'}
    	{$reasonMessage = $this->translate( 'The requested controller was unable to dispatch the request.' )}
	{elseif $this->reason == 'error-controller-not-found'}
    	{$reasonMessage = $this->translate( 'The requested controller could not be mapped to an existing controller class.' )}
	{elseif $this->reason == 'error-controller-invalid'}
    	{$reasonMessage = $this->translate( 'The requested controller was not dispatchable.' )}
	{elseif $this->reason == 'error-router-no-match'}
    	{$reasonMessage = $this->translate( 'The requested URL could not be matched by routing.' )}
	{else}
    	{$reasonMessage = $this->translate( 'We cannot determine at this time why a 404 was generated.' )}
	{/if}
	<p>{$reasonMessage}</p>
{/if}

{if $this->controller }
<dl>
    <dt>{$this->translate( 'Controller' )}:</dt>
    <dd>{$this->escapeHtml( $this->controller )}

{if  isset( $this->controller_class ) && $this->controller_class && $this->controller_class != $this->controller} 
   ({sprintf( $this->translate( 'resolves to %s' ), $this->escapeHtml( $this->controller_class ) )})
{/if}
</dd>
</dl>

{/if}

{if $this->exception }

<h2>{$this->translate( 'Exception' )}:</h2>

<p><b>{$this->escapeHtml( $this->exception->getMessage() )}></b></p>

<h3>{$this->translate( 'Stack trace' )}:</h3>

<pre>
{$this->exception->getTraceAsString()}
</pre>

{/if}
</div>
</div>
