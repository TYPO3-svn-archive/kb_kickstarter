{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'check',
{if $property.config.default}
				'default' => '{$property.config.default}'
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

