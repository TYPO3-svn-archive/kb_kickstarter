<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3locallang>
	<meta type="array">
		<description>Table labels for kb_kickstarter table "{$table.LLL_name}"</description>
		<type>database</type>
		<csh_table></csh_table>
		<fileId>EXT:kb_config/{$table._LLL.relFile}</fileId>
		<labelContext type="array">
			<label index="{$table.alias}"></label>
{foreach from=$table.fieldRows key=property_key item=property}
{include file="_basics/llxml_xml/llxml_context_xml.tpl"}
{/foreach}
		</labelContext>
<!--
Question: Shall translated llxml files get stored separate in the appropriate csh_XX extension or shall those labels get all together stored in this extension
		<ext_filename_template>EXT:csh_###LANGKEY###/kb_kickstarter/###LANGKEY###.locallang_db_fields.xml</ext_filename_template>
-->
		<keep_original_text type="integer">1</keep_original_text>
	</meta>
	<data type="array">
		<languageKey index="default" type="array">
			<label index="{$table.alias}">{$table.LLL_name}</label>
{foreach from=$table.fieldRows key=property_key item=property}
{include file="_basics/llxml_xml/llxml_value_xml.tpl"}
{/foreach}
		</languageKey>
	</data>
</T3locallang>
