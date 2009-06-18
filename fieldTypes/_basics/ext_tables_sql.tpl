#
# {$generatedComment}
#

{foreach from=$tables key=tableIdx item=table}
{include file="_basics/ext_tables_sql/ext_tables_sql_comment.tpl"}
CREATE TABLE `{$table.full_alias}` (
{include file="_basics/ext_tables_sql/ext_tables_sql_common_fields.tpl"}

{foreach from=$table.fieldRows key=fieldIdx item=property}
{include file="`$property.type`/sql_template.tpl"}
{/foreach}

{include file="_basics/ext_tables_sql/ext_tables_sql_common_keys.tpl"}
);


{/foreach}



{foreach from=$tables key=tableIdx item=table}

{foreach from=$table.fieldRows key=fieldIdx item=property}
{include file="`$property.type`/sql_extra.tpl"}
{/foreach}

{/foreach}

