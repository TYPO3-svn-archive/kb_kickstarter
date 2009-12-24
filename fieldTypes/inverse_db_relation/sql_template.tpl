	{strip}
{if $property.config.useMM}
	`{$property.full_alias}` int(11) DEFAULT '0' NOT NULL,
{else}
	{if $property.config.maxitems==1}
		`{$property.full_alias}` int(11) DEFAULT '0' NOT NULL,
	{else}
		`{$property.full_alias}` text,
	{/if}
{/if}{/strip}

