<nav class="mt-8 text-center">
	<a
		:if="$page > 1"
		href="{{ $prev }}"
		class="font-serif italic border-b-2 border-b-white/10 text-white/70 text-2xl transition-colors duration-500 hover:text-white hover:border-b-white/40"
	>
		<span :if="$page < $maxPages">Return to the surface</span>
		<span :else>Return to the surface?</span>
	</a>

	<span class="font-serif italic text-white/60 text-2xl" :if="$page > 1 && $page < $maxPages"> or </span>

	<a
		:if="$page < $maxPages"
		href="{{ $next }}"
		class="font-serif italic border-b-2 border-b-white/10 text-white/70 text-2xl transition-all duration-500 hover:text-white hover:border-b-white/40"
	>
		<span :if="$page < $maxPages && $page > 1">dive deeper into the abyss?</span>
		<span :else>Dive deeper into the abyss?</span>
	</a>
</nav>