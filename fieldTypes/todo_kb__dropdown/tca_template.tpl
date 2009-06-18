		'{$property.alias}' => Array (
			{if $property.exclude_field}'exclude' => 1,{/if}
			'l10n_mode' => '{$property.prop_l10n_mode}',
			'label' => 'LLL:EXT:{$config.config_ext}/llxml/locallang_{$table.alias}_db.xml:{$table.alias}__{$property.alias}',
			'config' => Array	(
				'type' => 'input',
				{if $property.prop_size}'size' => '{$property.prop_size}'{/if}
				{if $property.prop_max}'max' => '{$property.prop_max}'{/if}
				{if $property.prop_default}'default' => '{$property.prop_default}'{/if}
				{if $property.prop_eval}'eval' => '{$property.prop_eval}'{/if}
				{if $property.prop_is_in}'is_in' => '{$property.prop_is_in}'{/if}
			),
		),
