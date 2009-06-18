{if $property.config.useMM}
CREATE TABLE `{$table.full_alias}__{$property.alias}__MM` (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign varchar(100) DEFAULT '' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

{/if}
