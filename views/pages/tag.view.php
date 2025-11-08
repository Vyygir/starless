<?php

use Starless\Controllers\TagController;
use function Tempest\Router\uri;

?>

<x-secondary>
    <x-slot name="meta">
        <meta property="og:title" content="Starless &mdash; {{ $tag->name }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $tag->uri }}">
        <meta property="og:description" content="Peruse the {{ $tag->getCommonName() }} collections">
        <meta property="og:image" content="https://starle.sh/static/meta/image.png">
    </x-slot>

    <h2 class="-mt-2 mb-10 font-serif italic text-3xl text-center text-white/80">Peruse the {{ $tag->getCommonName() }} collections</h2>

	<div class="grid grid-cols-1 sm:grid-cols-1 gap-8">
        <x-entry :foreach="$entries as $entry" :entry="$entry" />
	</div>

    <x-pagination :prev="uri([ TagController::class, 'paginated' ], slug: $tag->slug, page: $page - 1)" :next="uri([ TagController::class, 'paginated' ], slug: $tag->slug, page: $page + 1)" :page="$page" :maxPages="$maxPages" />
</x-secondary>
