		'{$property.full_alias}' => Array (
{if $property.exclude_field}
			'exclude' => 1,
{/if}
{if $property.prop_l10n_mode}
			'l10n_mode' => '{$property.prop_l10n_mode}',
{/if}
			'label' => '{include file="_basics/ll_label.tpl"}',
			'config' => Array (

