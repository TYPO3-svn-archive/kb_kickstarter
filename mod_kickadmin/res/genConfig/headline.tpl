<h1>Generate table-configuration-arrays (TCA)</h1>
<h2>There
{if $tables|@count>1}
are {$tables|@count} tables
{else}
is one table
{/if}
defined (
{if $hiddenTables|@count>1}
{$hiddenTables|@count} of them are
{else}
one of them is
{/if}
disabled )</h2>
