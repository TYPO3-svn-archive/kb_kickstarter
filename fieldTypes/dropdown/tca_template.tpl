{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'select',
				'size' => '{$property.config.size}',
{if $property.config.selectElements}
				'items' => array(
{foreach from=$property.config.selectElements item=selectElement}
					array(
						'{$selectElement.label}',
						'{$selectElement.value}',
{if $selectElement.icon}
						'../uploads/tx_kbkickstarter/{$selectElement.icon}',
{/if}
					),
{/foreach}
				),
{/if}
{if $property.config.autoSizeMax}
				'autoSizeMax' => '{$property.config.autoSizeMax}',
{/if}
{if $property.config.iconMode=="suppress"}
				'suppress_icons' => '1',
{elseif $property.config.iconMode=="selected"}
				'suppress_icons' => 'IF_VALUE_FALSE',
{elseif $property.config.iconMode=="current"}
				'suppress_icons' => 'ONLY_SELECTED',
{/if}
{if $property.config.iconsInOptionTags}
				'iconsInOptionTags' => 1,
{/if}
{if $property.config.maxitems}
				'maxitems' => '{$property.config.maxitems}',
{/if}
{if $property.config.minitems}
				'minitems' => '{$property.config.minitems}',
{/if}
{if $property.config.styleSelected}
				'selectedListStyle' => '{$property.config.styleSelected}',
{/if}
{if $property.config.styleAvailable}
				'itemListStyle' => '{$property.config.styleAvailable}',
{/if}
{if $property.config.multiple}
				'multiple' => true,
{/if}
{if $property.config.itemsProcFunc}
				'itemsProcFunc' => '{$property.config.itemsProcFunc}',
{/if}
{if $property.config.renderMode}
				'renderMode' => '{$property.config.renderMode}',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}
