<?php

namespace Starless\Models;

use Tempest\Mapper\MapFrom;
use Tempest\Support\Str\ImmutableString;
use Starless\Controllers\TagController;
use Starless\Support\Tags\TagStyle;

use function Tempest\Router\uri;
use function Tempest\Support\str;

class Tag {
	#[MapFrom('colour')]
	public TagStyle $style;

	public bool $preserveCase = false;

	public function __construct(
		public readonly string $name,
	) {}

	public string $slug {
		get => new ImmutableString($this->name)->slug()->toString();
	}

	public string $uri {
		get => uri([ TagController::class, 'index' ], slug: $this->slug);
	}

	public function getCommonName(): string {
		if ($this->preserveCase) {
			return $this->name;
		}

		return str($this->name)->lower()->toString();
	}
}
