{if $property.config.useMM}
CREATE TABLE `{$property.config.allowed}__{$property.config.fieldMatching|regex_replace:"/^tx_kbks_/":""}__MM` (
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
);
{/if}
