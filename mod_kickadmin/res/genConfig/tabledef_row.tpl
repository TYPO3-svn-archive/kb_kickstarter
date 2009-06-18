<tr {if $table_data.hidden}class="disabled"{/if}>
	<td>
		{$table_data.uid}
		{if $table_data.hidden}
			(disabled)
		{/if}
	</td>
	<td>
		{$table_data.name}
	</td>
	<td>
		{$table_data.alias}
	</td>

	{if $table_data._TCA.new.md5 == $table_data._TCA.current.md5}
		<td class="green-cell">
			Up to date
		</td>
	{else}
		<td class="red-cell no-padding">
			<p class="red-cell">Outdated</p>
			<a class="block-link center" href="{$table_data._links._TCA.update}">Update TCA</a>
		</td>
	{/if}

	{if		$table_data._extTables.new.md5 == $table_data._extTables.current.md5 &&
				($table_data._extTablesMain.new.md5 == $table_data._extTablesMain.current.md5) }
		<td class="green-cell">
			Up to date
		</td>
	{else}
		<td class="red-cell no-padding">
			<p class="red-cell">Outdated</p>
			<a class="block-link center" href="{$table_data._links._extTables.update}">Update extTables</a>
		</td>
	{/if}

	{if $table_data._SQL.new.md5 == $table_data._SQL.current.md5}
		<td class="green-cell">
			Up to date
		</td>
	{else}
		<td class="red-cell no-padding">
			<p class="red-cell">Outdated</p>
			<a class="block-link center" href="{$table_data._links._SQL.update}">Update SQL</a>
		</td>
	{/if}

	{if $table_data._LLL.new.md5 == $table_data._LLL.current.md5}
		<td class="green-cell">
			Up to date
		</td>
	{else}
		<td class="red-cell no-padding">
			<p class="red-cell">Outdated</p>
			<a class="block-link center" href="{$table_data._links._LLL.update}">Update Labels</a>
		</td>
	{/if}

	<td class="no-padding">
		{if		($table_data._TCA.new.md5 == $table_data._TCA.current.md5) &&
					($table_data._extTables.new.md5 == $table_data._extTables.current.md5) &&
					($table_data._extTablesMain.new.md5 == $table_data._extTablesMain.current.md5) &&
					($table_data._SQL.new.md5 == $table_data._SQL.current.md5) &&
					($table_data._LLL.new.md5 == $table_data._LLL.current.md5) }
			<a class="block-link" href="{$table_data._links._all.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update table</a>
		{else}
			<a class="block-link" href="{$table_data._links._all.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update table</a>
		{/if}
	</td>
</tr>

