{if isset( $messages ) }
    {foreach $messages as $message}
        {$pos = strrpos( $message, "@" )}
        {$msg = substr( $message, 0, $pos )}
        {$type = substr( $message, $pos + 1 , strlen( $message ) )}

        <div class="alert alert-{$type}">
            {$msg}
            <a class="close" href="#" data-dismiss="alert">×</a>
        </div>
    {/foreach}
{/if}
