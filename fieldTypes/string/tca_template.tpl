{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'input',
{if $property.config.size}
				'size' => '{$property.config.size}',
{/if}
{if $property.config.max}
				'max' => '{$property.config.max}',
{/if}
{if $property.config.default}
				'default' => '{$property.config.default}',
{/if}
{if $property.config.eval}
				'eval' => '{$property.config.eval}',
{/if}
{if $property.config.is_in}
				'is_in' => '{$property.config.is_in}',
{/if}
{if $property.config.wizard}
				'wizards' => array(
{include file="`$property.type`/wizard_`$property.config.wizard`.tpl"}
				),
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

