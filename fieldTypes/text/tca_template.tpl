{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'text',
{if $property.config.cols}
				'cols' => '{$property.config.cols}',
{/if}
{if $property.config.rows}
				'rows' => '{$property.config.rows}',
{/if}
{if $property.config.default}
				'default' => '{$property.config.default}',
{/if}
{if $property.config.nowrap}
				'wrap' => 'off',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

