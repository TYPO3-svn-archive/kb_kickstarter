{include file="_basics/dyn_tca_php/prop_header.tpl"}
				'type' => 'group',
				'internal_type' => 'file',
				'size' => '{$property.config.size}',
				'uploadfolder' => 'uploads/ks_{$property.alias}_{$property.uid}',
				{createDirectory base="uploads/" directory="ks_`$property.alias`_`$property.uid`"}
{if $property.config.autoSizeMax}
				'autoSizeMax' => '{$property.config.autoSizeMax}',
{/if}
{if $property.config.allowed}
				'allowed' => '{$property.config.allowed}',
{else}
				'allowed' => '*',
{/if}
{if $property.config.disallowed}
				'disallowed' => '{$property.config.disallowed}',
{else}
				'disallowed' => '*',
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
{if $property.config.useMM}
				'MM' => '{$table.full_alias}__{$property.alias}__MM',
{/if}
{include file="_basics/dyn_tca_php/prop_footer.tpl"}

