{if $property.config.readOnly}
				'readOnly' => true,
{/if}
			),
{if "rte" == $property.type}
			'defaultExtras' => '{$property.config.rte_config}',
{/if}
		),

