{include file="_basics/dyn_tca_php/prop_header.tpl"}
{if $property.config.relationType=="group"}
				'type' => 'group',
				'internal_type' => 'db',
{if $property.config.allowed}
				'allowed' => '{$property.config.allowed}',
{/if}
{else}
				'type' => 'select',
				'foreign_table' => '{$property.config.allowed}',
{if ($property.config.same_page) || ($property.config.pages|regex_replace:"/[^0-9,]/":"") || $property.config.fieldMatching || $property.config.fieldSorting}
				'foreign_table_where' => '{if $property.config.same_page} AND ###REC_FIELD_pid###={$property.config.allowed}.pid{/if}{if ($property.config.pages|regex_replace:"/[^0-9,]/":"")} AND {$property.config.allowed}.pid IN ({$property.config.pages|regex_replace:"/[^0-9,]/":""}){/if}{if $property.config.fieldSorting} ORDER BY {$property.config.fieldSorting}{/if}',
{/if}
{/if}
				'size' => '{$property.config.size}',
{if $property.config.autoSizeMax}
				'autoSizeMax' => '{$property.config.autoSizeMax}',
{/if}
{if $property.config.show_thumbs}
				'show_thumbs' => '{$property.config.show_thumbs}',
{/if}
{if $property.config.maxitems}
				'maxitems' => '{$property.config.maxitems}',
{/if}
{if $property.config.minitems}
				'minitems' => '{$property.config.minitems}',
{/if}
{if $property.config.useMM}
				'MM' => '{$property.config.allowed}__{$property.config.fieldMatching|regex_replace:"/^tx_kbks_/":""}__MM',
				'MM_opposite_field' => '{$property.config.fieldMatching}',
{/if}
{if $property.config.styleSelected}
				'selectedListStyle' => '{$property.config.styleSelected}',
{/if}
{if $property.config.styleAvailable}
				'itemListStyle' => '{$property.config.styleAvailable}',
{/if}
{if (strpos($property.config.allowed, ',')!==false) && (!$property.config.useMM)}
				'prepend_tname' => true,
{/if}
{if $property.config.multiple}
				'multiple' => true,
{/if}
{if $property.config.itemsProcFunc}
				'itemsProcFunc' => '{$property.config.itemsProcFunc}',
{/if}
{if $property.config.extraElements}
				'items' => array(
{foreach from=$property.config.extraElements item=extraElement}
					array(
						'{$extraElement.label}',
						'{$extraElement.value}',
					),
{/foreach}
				),
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

