		'0' => Array('showitem' => '{strip}
{if $table.enableHide}
hidden, 
{/if}
{foreach from=$table.fieldRows key=property_key item=property name=types_Iter}
	{if (!$smarty.foreach.types_Iter.first) || $table.enableHide}, {/if}
	{$property.full_alias}
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

