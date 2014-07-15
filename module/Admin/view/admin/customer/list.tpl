{$identity = $this->identity()}
{$title = 'Customers'}
{$this->headTitle( $title )}


<div class="page-header">
	<h1>{$this->escapeHtml( $title )}</h1>
</div>

{include file=$config['template']['layout/messages'] }

<table class="table">
	<theader>
		<tr>
			<th>Name</th>
			<th>Contact</th>
			<th>Email</th>
			<th>type</th>
			<th>{if !$identity['read_only']}<a class="btn btn-default btn-xs have-tooltip" title="Add Customer" href="{$this->url( 'customer', [ 'action' => 'add' ] )}"><span class="glyphicon glyphicon-plus"></span></a>{/if}</th>
		</tr>
	</theader>
	<tbody>
		{foreach $customers as $customer}
			<tr>
				<td>{$customer['name']}</td>
				<td>{$customer['contact']}</td>
				<td>{$customer['email']}</td>
				<td>{$customer['type']}</td>				
				<td>
					<div class="btn-group btn-group-xs">
						{if !$identity['read_only'] }
							<a class="btn btn-default have-tooltip" title="Edit" href="{$this->url( 'customer', [ 'action' => 'edit', 'customers_id' => $customer['id'] ] )}"><span class="glyphicon glyphicon-pencil"></span></a>
						{/if}
					</div>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table> 
