{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'input',
				'size' => '15',
				'max' => '10',
				'check' => 0,
				'eval' => 'timesec',
{if $property.prop_default}
				'default' => '{$property.prop_default}',
				'checkbox' => '{$property.prop_default}',
{else}
				'default' => '0',
				'checkbox' => '0',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

