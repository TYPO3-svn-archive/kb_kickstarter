<div class="db-update-div">
{if $db_update.required}
<div class="red-div">
	<a class="block-link" href="{$db_update.link}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Database requires an update</a>
</div>
{else}
<div class="green-div">
	<a class="block-link" href="{$db_update.link_force}"><img src="{$icon_update}" style="margin-bottom: -4px;" /> Force database update</a>
</div>
{/if}
</div>
