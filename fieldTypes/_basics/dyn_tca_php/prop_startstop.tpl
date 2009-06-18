		'starttime' => Array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.starttime',
			'config' => Array(
				'type' => 'input',
				'size' => 8,
				'max' => 20,
{if $table.datetimeStartStop}
				'eval' => 'datetime',
{else}
				'eval' => 'date',
{/if}
				'checkbox' => '0',
				'default' => '0',
			),
		),
		'endtime' => Array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.endtime',
			'config' => Array(
				'type' => 'input',
				'size' => 8,
				'max' => 20,
{if $table.datetimeStartStop}
				'eval' => 'datetime',
{else}
				'eval' => 'date',
{/if}
				'checkbox' => '0',
				'default' => '0',
			),
		),

