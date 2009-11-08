		'0' => Array('showitem' => '{strip}
{if $table.enableHide}
hidden, 
{/if}
{foreach from=$table.fieldRows key=property_key item=property name=types_Iter}
	{if (!$smarty.foreach.types_Iter.first) || $table.enableHide}, {/if}
	{if "tab" == $property.type}
		--div--;{include file="_basics/ll_label.tpl"}
	{else}
		{$property.full_alias}
	{/if}
{/foreach}
{if $table.enableStartStop}
	, starttime;;;;98-98-98, endtime
{/if}
{if $table.enableAccessControl}
	{if $table.enableStartStop}
		, fe_group
	{else}
		, fe_group;;;;98-98-98
	{/if}
{/if}
{/strip}'),

