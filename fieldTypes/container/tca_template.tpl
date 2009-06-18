{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'inline',
				'foreign_table' => '{$property.config.table}',
//				'foreign_field' => '{$table.full_alias}__{$property.full_alias}__parent',
				'foreign_field' => '{$property.config.parentPointer}',
{if $property.config.maxitems}
				'maxitems' => '{$property.config.maxitems}',
{/if}
{if $property.config.minitems}
				'minitems' => '{$property.config.minitems}',
{/if}
				'appearance' => array(
					'collapseAll' => {if $property.config.collapseAll}true{else}false{/if},
					'expandSingle' => {if $property.config.expandSingle}true{else}false{/if},
					'newRecordLinkAddTitle' => {if $property.config.addTitle}true{else}false{/if},
					'newRecordLinkPosition' => '{$property.config.linkPosition}',
					'useSortable' => '{$property.config.useSortable}',
				),
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

