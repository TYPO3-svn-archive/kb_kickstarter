{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'radio',
{if $property.config.selectElements}
				'items' => array(
{foreach from=$property.config.selectElements item=selectElement}
					array(
						'{$selectElement.label}',
						'{$selectElement.value}',
					),
{/foreach}
				),
{/if}
{if $property.config.default}
				'default' => '{$property.config.default}',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}
