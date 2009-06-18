<tr>
	<td colspan="3">
	</td>
	<td class="no-padding">
		{if $out_of_date__TCA}
			<a class="block-link" href="{$links.TCA.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update TCA</a>
		{else}
			<a class="block-link" href="{$links.TCA.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update TCA</a>
		{/if}
	</td>
	<td class="no-padding">
		{if $out_of_date__extTables}
			<a class="block-link" href="{$links.extTables.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update extTables</a>
		{else}
			<a class="block-link" href="{$links.extTables.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update extTables</a>
		{/if}
	</td>
	<td class="no-padding">
		{if $out_of_date__SQL}
			<a class="block-link" href="{$links.SQL.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update SQL</a>
		{else}
			<a class="block-link" href="{$links.SQL.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update SQL</a>
		{/if}
	</td>
	<td class="no-padding">
		{if $out_of_date__LLL}
			<a class="block-link" href="{$links.LLL.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update LLL</a>
		{else}
			<a class="block-link" href="{$links.LLL.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update LLL</a>
		{/if}
	</td>
	<td class="no-padding">
		{if $out_of_date__all}
			<a class="block-link" href="{$links.all.update}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Update all tables</a>
		{else}
			<a class="block-link" href="{$links.all.update_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force update all tables</a>
		{/if}
	</td>
</tr>


