{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'inline',
				'foreign_table' => '{$property.config.table}',

{if $property.config.parentPointer}
				'foreign_field' => '{$property.config.parentPointer}',
{else}
				'foreign_field' => '{$table.full_alias}__{$property.full_alias}__parent',
{/if}

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
					'enabledControls' => array('info'=>false, 'sort'=>false),
					'showSynchronizationLink' => {if $property.config.showSynchronizationLink}true{else}false{/if},
					'showAllLocalizationLink' => {if $property.config.showAllLocalizationLink}true{else}false{/if},
				),
    			'behaviour' => array (
{if $property.config.useLocalization}
                    'localizationMode' => 'select', // use localization
{/if}
{if $property.config.localizeChildrenAtParentLocalization}
                    'localizeChildrenAtParentLocalization' => true,
{/if}
    			),
    			
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

