<br />
<h1>Generate / Initialize / Install / Activate configuration extensions</h1>

<form action="{$linkScript}" method="POST" target="_self" enctype="multipart/form-data">
<table class="status-info readable">
	<tr>
		<th>
			Extension name
		</th>	
		<th width="180">
			Installed
		</th>	
		<th>
			Currently active
		</th>	
	</tr>
	{foreach from=$configExtensions key=extName item=extData}
		{include file="configExt/configExt_row.tpl"}
	{/foreach}
	{include file="configExt/configExt_new.tpl"}
</table>
</form>
