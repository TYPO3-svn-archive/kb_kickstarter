{if $property.config.readOnly}
				'readOnly' => true,
{/if}
			),
{if "rte" == $property.type}
	{if $property.config.rte_config != $property.config.rte_config|replace:"###UPLOAD_PATH###":""}
		{php}
			$property = $this->get_template_vars('property');
			t3lib_div::mkdir_deep(PATH_site.'uploads/', 'ks_rte_'.$property['alias'].'_'.$property['uid']);
		{/php}
	{/if}
			'defaultExtras' => '{$property.config.rte_config|replace:"###UPLOAD_PATH###":"uploads/ks_rte_`$property.alias`_`$property.uid`"}',
{/if}
		),

