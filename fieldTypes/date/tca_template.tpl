{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'input',
				'size' => '12',
				'max' => '20',
{if $property.config.required}
				'eval' => 'date,required',
{else}
				'eval' => 'date',
{/if}
{if $property.config.default}
				'default' => '{$property.config.default}',
				'checkbox' => '{$property.config.default}',
{else}
				'default' => '0',
				'checkbox' => '0',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

