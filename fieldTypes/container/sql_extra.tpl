{if !$property.config.parentPointer}
CREATE TABLE `{$property.config.table}` (
	`{$table.full_alias}__{$property.full_alias}__parent` int(11) DEFAULT '0' NOT NULL,
);
{/if}

