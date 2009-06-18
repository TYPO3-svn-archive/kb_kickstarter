<tr>
	<td>
		{$extData.name}
	</td>
{if $extData.installed}
	<td class="green-cell center bold spaced">
		Is installed
	</td>
{else}
	<td class="red-cell no-padding">
		<p class="red-cell">Not installed</p>
		<a class="block-link full-width center" href="{$extData.installLink}">Install Extension</a>
	</td>
{/if}
{if $extData.current}
	<td class="green-cell">
		<input type="radio" name="activeConfigExt" value="{$extData.name}" checked="checked" />
		Active
	</td>
{else}
	<td class="red-cell">
		<input type="radio" name="activeConfigExt" value="{$extData.name}" />
		Not active
	</td>
{/if}
</tr>
