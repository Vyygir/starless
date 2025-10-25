<x-slot name="meta">
	<meta property="og:title" content="Starless" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://starle.sh" />
	<meta property="og:description" content="Entries from the dark side of engineering" />
	<meta property="og:image" content="https://starle.sh/static/meta/image.png" />
</x-slot>

<x-definition>
	<div class="grid grid-cols-1 sm:grid-cols-1 gap-8">
		<article :foreach="$entries as $entry" class="group bg-white/2 p-6 rounded-lg border border-white/5 transition-colors duration-500 hover:border-white/15 relative">
			<a href="{{ $entry->uri }}" class="block absolute w-full h-full"></a>
			<div class="sm:flex sm:justify-between">
				<time datetime="{{ $entry->published }}" class="block text-sm text-neutral-500">{{ $entry->publishedDate() }}</time>
				<time datetime="{{ $entry->modified }}" class="block text-sm text-neutral-700" :if="$entry->modified">Amended, {{ $entry->modifiedDate() }}</time>
			</div>

			<h3 class="mt-2 mb-3 text-3xl font-serif text-white/75 transition-colors duration-350 group-hover:text-white/100">{{ $entry->title }}</h3>
			<p class="text-md leading-7 font-light text-white/60">{{ $entry->excerpt }}</p>
		</article>
	</div>

	<nav class="mt-8 text-center" :if="$maxPages > 1">
		<a href="/page/{{ max($page - 1, 1) }}" :if="$page > 1" class="font-serif italic border-b-2 border-b-white/10 text-white/70 text-2xl transition-colors duration-500 hover:text-white hover:border-b-white/40">
			<span :if="$page < $maxPages">Return to the surface</span>
			<span :else>Return to the surface?</span>
		</a>
		<span class="font-serif italic text-white/60 text-2xl" :if="$page > 1 && $page < $maxPages"> or </span>
		<a href="/page/{{ min($page + 1, $maxPages) }}" :if="$page < $maxPages" class="font-serif italic border-b-2 border-b-white/10 text-white/70 text-2xl transition-all duration-500 hover:text-white hover:border-b-white/40">
			<span :if="$page < $maxPages && $page > 1">dive deeper into the abyss?</span>
			<span :else>Dive deeper into the abyss?</span>
		</a>
	</nav>
</x-definition>
