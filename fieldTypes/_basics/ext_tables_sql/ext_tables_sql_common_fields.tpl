	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
{if !$table._sortFields}
	sorting int(10) unsigned DEFAULT '0' NOT NULL,
{/if}{if !$table.realDelete}
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
{/if}{if $table.enableHide}
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
{/if}{if $table.enableStartStop}
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
{/if}{if $table.enableAccessControl}
	fe_group varchar(100) DEFAULT '0' NOT NULL,
{/if}

