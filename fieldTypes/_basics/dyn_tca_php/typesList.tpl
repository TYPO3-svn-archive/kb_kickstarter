		'{$currentType}' => Array('showitem' => '{strip}
{if $table.enableHide}
hidden, 
{/if}
{if $table.enableLocalization}
l18n_parent,sys_language_uid,
{/if}
{assign var='printComma' value=0}
{foreach from=$table.fieldRows key=property_key item=property name=types_Iter}
	{assign var='isTypeField' value=0}
	{foreach from=$table.typeConfig key=configIndex item=typeConfig}
		{foreach from=$typeConfig.fieldRows key=typeFieldIndex item=typeField}
			{if (($property.uid == $typeField.uid) && (!$isTypeField || ($typeConfig.typeFieldValue == $currentType)))}
				{assign var='isTypeField' value="`$typeConfig.typeFieldValue`"}
			{/if}
		{/foreach}
	{/foreach}
	{if (!$isTypeField) || ($currentType == $isTypeField)}
		{if $printComma || $table.enableHide}, {/if}
		{if "tab" == $property.type}
			{assign var='printComma' value=1}
			--div--;{include file="_basics/ll_label.tpl"}
		{else}
			{assign var='printComma' value=1}
			{$property.full_alias}
		{/if}
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

