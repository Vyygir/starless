<article :isset="$entry" class="group bg-white/2 p-6 rounded-lg border border-white/5 transition-colors duration-500 hover:border-white/15 relative">
	<a href="{{ $entry->uri }}" class="block absolute w-full h-full top-0 bottom-0 right-0 left-0"></a>

	<div :if="!empty($entry->tags)" class="flex flex-wrap gap-2 mb-3">
                <span :foreach="$entry->tags as $tag" class="block px-2 pb-0.25 rounded-2xl border-1 border-white/10 font-semibold leading-5 tracking-wide text-xs {{ $tag->style->getClass() }}">
                    {{ $tag->name }}
                </span>
	</div>

	<div class="sm:flex sm:justify-between">
		<time datetime="{{ $entry->published }}" class="block text-sm text-neutral-500">{{ $entry->publishedDate() }}</time>
		<time datetime="{{ $entry->modified }}" class="block text-sm text-neutral-700" :if="$entry->modified">Amended, {{ $entry->modifiedDate() }}</time>
	</div>

	<h3 class="mt-2 mb-3 text-3xl font-serif text-white/75 transition-colors duration-350 group-hover:text-white/100">{{ $entry->title }}</h3>
	<p class="text-md leading-7 font-light text-white/60">{{ $entry->excerpt }}</p>
</article>