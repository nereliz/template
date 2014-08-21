{$this->doctype()}
{if $auth && $auth->hasIdentity()}
	{include file="`$smarty.current_dir`/auth-layout.tpl"}
{else}
	{include file="`$smarty.current_dir`/unauth-layout.tpl"}
{/if}

