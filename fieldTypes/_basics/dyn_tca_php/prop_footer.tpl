{if $property.config.readOnly}
				'readOnly' => true,
{/if}
			),
{if "rte" == $property.type}
	{if $property.config.rte_config != $property.config.rte_config|replace:"###UPLOAD_PATH###":""}
		{createDirectory base="uploads/" directory="ks_rte_`$property.alias`_`$property.uid`"}
	{/if}
			'defaultExtras' => '{$property.config.rte_config|replace:"###UPLOAD_PATH###":"uploads/ks_rte_`$property.alias`_`$property.uid`"}',
{/if}
		),

