
{include file="_basics/dyn_tca_php/prop_header.tpl"} 

	'form_type' => 'user',
	'userFunc' => 'EXT:dam/lib/class.tx_dam_tcefunc.php:&tx_dam_tceFunc->getSingleField_typeMedia',

	'userProcessClass' => 'EXT:mmforeign/class.tx_mmforeign_tce.php:tx_mmforeign_tce',
	'type' => 'group',
	'internal_type' => 'db',
	'allowed' => 'tx_dam',
	'prepend_tname' => 1,
	'MM' => 'tx_dam_mm_ref',
	'MM_foreign_select' => 1, // obsolete in 4.1
	'MM_opposite_field' => 'file_usage',
	'MM_match_fields' => array('ident' => '{$property.full_alias}'),

	'size' => '{$property.config.size}',
	
	{if $property.config.allowed}
					'allowed_types' => '{$property.config.allowed}',
	{else}
					'allowed_types' => '*',
	{/if}
	{if $property.config.disallowed}
					'disallowed_types' => '{$property.config.disallowed}',
	{else}
					'disallowed_types' => '*',
	{/if}
	{if $property.config.max_size}
					'max_size' => '{$property.config.max_size}',
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
	{if $property.config.autoSizeMax}
					'autoSizeMax' => '{$property.config.autoSizeMax}',
	{/if}

{include file="_basics/dyn_tca_php/prop_footer.tpl"}
