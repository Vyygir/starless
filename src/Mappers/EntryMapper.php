<?php

namespace Starless\Mappers;

use Tempest\Mapper\Mapper;
use Tempest\DateTime\DateTime;
use Starless\Models\Entry;
use Starless\Repositories\TagRepository;

final class EntryMapper implements Mapper {
	public function __construct(
		private readonly TagRepository $tagRepository,
	) {}

	public function canMap(mixed $from, mixed $to): bool {
		if (!is_array($from)) {
			return false;
		}

		$missingKeys = array_diff(
			[ 'title', 'slug', 'published', 'excerpt', 'content', 'source' ],
			array_keys($from)
		);

		if (!empty($missingKeys)) {
			return false;
		}

		return is_a($to, Entry::class);
	}

	public function map(mixed $from, mixed $to): mixed {
		$entry = new $to(
			slug: $from['slug'],
			title: $from['title'],
			content: $from['content'],
			excerpt: $from['excerpt'],
			published: DateTime::parse($from['published']),
			amendments: $from['amendments'] ?? [],
			source: $from['source'],
			tags: !empty($from['tags']) ? $this->tagRepository->getEntryTags($from['tags']) : null,
		);

		if (!empty($from['modified'])) {
			$entry->modified = DateTime::parse($from['modified']);
		}

		return $entry;
	}
}