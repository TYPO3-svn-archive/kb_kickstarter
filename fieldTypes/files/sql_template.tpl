{if $property.config.useMM}
	`{$property.full_alias}` int(11) DEFAULT '0' NOT NULL,
{else}
	`{$property.full_alias}` varchar(250) DEFAULT '' NOT NULL,
{/if}

