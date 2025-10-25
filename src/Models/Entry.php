<?php

namespace Starless\Models;

use DateTimeImmutable;
use Tempest\DateTime\DateTime;
use Tempest\Router\Bindable;
use function Tempest\Router\uri;
use Starless\Controllers\EntryController;

final class Entry implements Bindable {
	public ?DateTime $modified = null;

	public function __construct(
		public string $slug,
		public string $title,
		public string $content,
		public string $excerpt,
		public DateTime $published,
		public array $amendments,
		public string $source,
	) {}

	public string $uri {
		get => uri([ EntryController::class, 'read' ], slug: $this->slug);
	}

	public function publishedDate(): string {
		return new DateTimeImmutable($this->published->toString())->format('jS F, Y');
	}

	public function modifiedDate(): ?string {
		if (null === $this->modified) {
			return null;
		}

		return new DateTimeImmutable($this->modified->toString())->format('jS F, Y');
	}

	public static function resolve(string $input): Bindable {}
}
