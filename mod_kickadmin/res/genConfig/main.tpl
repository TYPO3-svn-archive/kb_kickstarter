<br />
{include file="genConfig/headline.tpl"}
<table class="status-info">
	{include file="genConfig/tabledef_row_head.tpl"}
	{foreach from=$tables key=table_key item=table_data}
		{if	$table_data._TCA.new.md5 != $table_data._TCA.current.md5}
			{assign var='out_of_date__TCA' value='1'}
			{assign var='out_of_date__all' value='1'}
		{/if}
		{if	($table_data._extTables.new.md5 != $table_data._extTables.current.md5) || ($table_data._extTablesMain.new.md5 != $table_data._extTablesMain.current.md5)}
			{assign var='out_of_date__extTables' value='1'}
			{assign var='out_of_date__all' value='1'}
		{/if}
		{if $table_data._SQL.new.md5 != $table_data._SQL.current.md5}
			{assign var='out_of_date__SQL' value='1'}
			{assign var='out_of_date__all' value='1'}
		{/if}
		{if $table_data._LLL.new.md5 != $table_data._LLL.current.md5}
			{assign var='out_of_date__LLL' value='1'}
			{assign var='out_of_date__all' value='1'}
		{/if}
		{include file="genConfig/tabledef_row.tpl"}
	{/foreach}
	{include file="genConfig/tabledef_row_bottom.tpl"}
</table>

{include file="genConfig/db_update.tpl"}

{if $updateResults|@count}
<br /><br />
<h2>Update results</h2>
<ul class="log-list">
	{foreach from=$updateResults item=updateLine}
		<li>{$updateLine}</li>
	{/foreach}
</ul>
{/if}

