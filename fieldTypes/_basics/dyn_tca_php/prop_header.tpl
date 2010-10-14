		'{$property.full_alias}' => Array (
{if $property.exclude_field}
			'exclude' => 1,
{/if}
{if $property.config.prop_l10n_mode}
			'l10n_mode' => '{$property.config.prop_l10n_mode}',
{/if}
{if $property.config.prop_l10n_display}
			'l10n_display' => '{$property.config.prop_l10n_display}',
{/if}
			'label' => '{include file="_basics/ll_label.tpl"}',
			'config' => Array (
