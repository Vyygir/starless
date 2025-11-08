<?php

use Starless\Controllers\EntryController;
use function Tempest\Router\uri;

?>

<x-primary>
	<div class="grid grid-cols-1 sm:grid-cols-1 gap-8">
        <x-entry :foreach="$entries as $entry" :entry="$entry" />
	</div>

    <x-pagination :prev="uri([ EntryController::class, 'paginated' ], page: $page - 1)" :next="uri([ EntryController::class, 'paginated' ], page: $page + 1)" :page="$page" :maxPages="$maxPages" />
</x-primary>
