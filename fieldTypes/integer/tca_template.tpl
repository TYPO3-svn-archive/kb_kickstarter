{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'input',
				'size' => '15',
				'max' => '10',
				'eval' => 'int',
{if $property.config.default}
				'default' => '{$property.config.default}'
{/if}
{if $property.config.min!=$property.config.max}
				'range' => Array (
					'upper' => '{$property.config.max}',
					'lower' => '{$property.config.min}',
				),
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

