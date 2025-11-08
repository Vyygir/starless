<?php

namespace Starless\Models;

use DateTimeImmutable;
use Tempest\DateTime\DateTime;
use Tempest\Mapper\MapFrom;
use Tempest\Router\Bindable;
use Tempest\Support\Arr\ImmutableArray;
use Starless\Controllers\EntryController;

use function Tempest\Router\uri;

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

		/** @var ImmutableArray<Tag>[] */
		public ?ImmutableArray $tags,
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
