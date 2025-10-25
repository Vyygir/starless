<html lang="en">
	<head>
		<title :if="isset($title)">"{{ $title }}" &mdash; Starless</title>
		<title :else>Starless</title>

		<x-slot name="meta" />

		<x-vite-tags />

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=IBM+Plex+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
	</head>

	<body class="bg-neutral-950 text-white">
		<div class="max-w-3xl mx-auto px-6 py-12 sm:px-8">
			<x-slot />
		</div>
	</body>
</html>