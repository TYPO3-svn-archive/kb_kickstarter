
#
# Table structure for table 'tx_kbkickstarter_fields'
#
CREATE TABLE tx_kbkickstarter_fields (
	`uid` int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	`pid` int(11) unsigned DEFAULT '0' NOT NULL,
	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`cruser_id` int(11) unsigned DEFAULT '0' NOT NULL,
	`sorting` int(10) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(4) unsigned DEFAULT '0' NOT NULL,

	`name` varchar(200) DEFAULT '' NOT NULL,
	`alias` varchar(100) DEFAULT '' NOT NULL,
	`type` varchar(20) DEFAULT '' NOT NULL,
	`exclude_field` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`flexconfig` mediumtext,
	`flex_md5` varchar(40) DEFAULT '' NOT NULL,
	`flex_serialized` mediumtext,

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_kbkickstarter_tables'
#
CREATE TABLE tx_kbkickstarter_tables (
	`uid` int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	`pid` int(11) unsigned DEFAULT '0' NOT NULL,
	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`cruser_id` int(11) unsigned DEFAULT '0' NOT NULL,
	`sorting` int(10) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(4) unsigned DEFAULT '0' NOT NULL,

	`name` varchar(200) DEFAULT '' NOT NULL,
	`alias` varchar(100) DEFAULT '' NOT NULL,
	`labelFields` int(11) DEFAULT '0' NOT NULL,
	`allLabels` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`sortFields` int(11) DEFAULT '0' NOT NULL,
	`realDelete` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`enableHide` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`enableStartStop` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`enableAccessControl` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`enableLocalization` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`datetimeStartStop` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`no_prefix` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`rootLevel` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`standardPages` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`adminOnly` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`ownerField` int(11) unsigned DEFAULT '0' NOT NULL,
	`icon_default` text NOT NULL,
	`hasFields` int(11) unsigned DEFAULT '0' NOT NULL,
	`typeField` int(11) unsigned DEFAULT '0' NOT NULL,
	`typeConfig` int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);


#
# Table structure for table 'tx_kbkickstarter_typeconfig'
#
CREATE TABLE tx_kbkickstarter_typeconfig (
	`uid` int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	`pid` int(11) unsigned DEFAULT '0' NOT NULL,
	`tstamp` int(11) unsigned DEFAULT '0' NOT NULL,
	`crdate` int(11) unsigned DEFAULT '0' NOT NULL,
	`cruser_id` int(11) unsigned DEFAULT '0' NOT NULL,
	`sorting` int(10) unsigned DEFAULT '0' NOT NULL,
	`deleted` tinyint(4) unsigned DEFAULT '0' NOT NULL,
	`hidden` tinyint(4) unsigned DEFAULT '0' NOT NULL,

	`parentRecord` int(11) DEFAULT '0' NOT NULL,
	`typeFieldValue` varchar(100) DEFAULT '' NOT NULL,
	`hasFields` int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);


CREATE TABLE tx_kbkickstarter_tables_fields_mm (
  `uid_local` int(11) unsigned DEFAULT '0' NOT NULL,
  `uid_foreign` int(11) unsigned DEFAULT '0' NOT NULL,
  `tablenames` varchar(30) DEFAULT '' NOT NULL,
  `sorting` int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_kbkickstarter_typeconfig_fields_mm (
  `uid_local` int(11) unsigned DEFAULT '0' NOT NULL,
  `uid_foreign` int(11) unsigned DEFAULT '0' NOT NULL,
  `tablenames` varchar(30) DEFAULT '' NOT NULL,
  `sorting` int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);


CREATE TABLE tx_kbkickstarter_tables_labelFields_mm (
  `uid_local` int(11) unsigned DEFAULT '0' NOT NULL,
  `uid_foreign` int(11) unsigned DEFAULT '0' NOT NULL,
  `tablenames` varchar(30) DEFAULT '' NOT NULL,
  `sorting` int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);


CREATE TABLE tx_kbkickstarter_tables_sortFields_mm (
  `uid_local` int(11) unsigned DEFAULT '0' NOT NULL,
  `uid_foreign` int(11) DEFAULT '0' NOT NULL,
  `tablenames` varchar(30) DEFAULT '' NOT NULL,
  `sorting` int(11) unsigned DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);

