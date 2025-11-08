<x-secondary :title="$entry->title">
    <x-slot name="meta">
        <meta property="og:title" content="Read &#8220;{{ $entry->title }}&#8221; on Starless">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ $entry->uri }}">
        <meta property="og:description" content="{{ $entry->excerpt }}">
        <meta property="og:image" content="https://starle.sh/static/meta/image.png">
    </x-slot>

	<div class="bg-white/2 p-6 rounded-lg border border-white/5">
		<article class="prose prose-white min-w-full">
			<div :if="$entry->modified" class="bg-yellow-400/5 mt-[calc(var(--spacing)*-6)] mx-[calc(var(--spacing)*-6)] mb-4 px-[calc(var(--spacing)*6)] py-3 border-1 border-white/5 rounded-t-lg">
				<span class="font-light text-yellow-100">
					This entry was last <a href="#amendments" class="text-yellow-100" :if="!empty($entry->amendments)">amended</a><span :else>amended</span> on the {{ $entry->modifiedDate() }}
				</span>
			</div>

            <div :if="!empty($entry->tags)" class="flex flex-wrap gap-2 mb-3">
                <a
                    :foreach="$entry->tags as $tag"
                    href="{{ $tag->uri }}"
                    class="block px-3 rounded-2xl border-1 border-white/10 font-semibold leading-6 tracking-wide no-underline text-sm {{ $tag->style->getClass() }}">
                    {{ $tag->name }}
                </a>
            </div>

			<time datetime="{{ $entry->published }}" class="block text-neutral-500">{{ $entry->publishedDate() }}</time>
			<h1>{{ $entry->title }}</h1>

			{!! $entry->content !!}

			<footer :if="$entry->modified && !empty($entry->amendments)" id="amendments">
				<hr />
				<h3>Amendments</h3>
				<ol>
					<li :foreach="$entry->amendments as $amendment">{{ $amendment }}</li>
				</ol>
			</footer>
		</article>
	</div>
</x-secondary>