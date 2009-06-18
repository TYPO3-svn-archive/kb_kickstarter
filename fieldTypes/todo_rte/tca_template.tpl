		'{$property.alias}' => Array (
			{if $property.exclude_field}'exclude' => 1,{/if}
			'l10n_mode' => '{$property.prop_l10n_mode}',
			'label' => 'LLL:EXT:{$config.config_ext}/llxml/locallang_{$table.alias}_db.xml:{$table.alias}__{$property.alias}',
			'config' => Array	(
				'type' => 'input',
				'size' => '15',
				'max' => '10',
				'eval' => 'int',
				{if $property.prop_default}'default' => '{$property.prop_default}'{/if}
				{if $property.prop_min!=$property.prop_max}
				'range' => Array (
					'upper' => '{$property.prop_max}',
					'lower' => '{$property.prop_min}',
				),
				{/if}
			),
		),
