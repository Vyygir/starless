<?php

use Tempest\Vite\ViteConfig;

use function Tempest\root_path;

return new ViteConfig(
	entrypoints: [
		root_path('assets/main.entrypoint.css'),
	],
);
