<?php

namespace Starless\Config;

readonly class StarlessConfig {
	public function __construct(
		public int $entriesPerPage,
		public array $availableTags,
	) {}
}
