<h1>{$this->translate( 'An error occurred' )}</h1>
<h2>{$this->message}</h2>

{if $this->display_exceptions }

{if $this->exception }
<hr/>
<h2>{$this->translate( 'Additional information' )}:</h2>
<h3>{get_class( $this->exception )}</h3>
<dl>
    <dt>{$this->translate( 'File' )}:</dt>
    <dd>
        <pre class="prettyprint linenums">{$this->exception->getFile()}:{$this->exception->getLine()}</pre>
    </dd>
    <dt>{$this->translate( 'Message' )}:</dt>
    <dd>
        <pre class="prettyprint linenums">{$this->exception->getMessage()}</pre>
    </dd>
    <dt>{$this->translate( 'Stack trace' )}:</dt>
    <dd>
        <pre class="prettyprint linenums">{$this->exception->getTraceAsString()}</pre>
    </dd>
</dl>

{$e = $this->exception->getPrevious()}
{if $e}
<hr/>
<h2>{$this->translate( 'Previous exceptions' )}:</h2>
<ul class="unstyled">
    {while $e}
    <li>
        <h3>{get_class( $e )}</h3>
        <dl>
            <dt>{$this->translate( 'File' )}:</dt>
            <dd>
                <pre class="prettyprint linenums">{$e->getFile()}:{$e->getLine()}</pre>
            </dd>
            <dt>{$this->translate( 'Message' )}:</dt>
            <dd>
                <pre class="prettyprint linenums">{$e->getMessage()}</pre>
            </dd>
            <dt>{$this->translate( 'Stack trace' )}:</dt>
            <dd>
                <pre class="prettyprint linenums">{$e->getTraceAsString()}</pre>
            </dd>
        </dl>
        {$e = $e->getPrevious()}
        {/while}
    </li>
</ul>
{/if}

{else}

<h3>{$this->translate( 'No Exception available ')}</h3>

{/if}

{/if}
