<?php

namespace Starless\DataProviders;

use Generator;
use Tempest\Router\DataProvider;
use Starless\Repositories\{EntryRepository, TagRepository};

final readonly class TaggedPaginatedEntryDataProvider implements DataProvider {
	public function __construct(
		private TagRepository $tagRepository,
		private EntryRepository $entryRepository,
	) {}

	public function provide(): Generator {
		foreach ($this->tagRepository->all() as $tag) {
			foreach (range(1, $this->entryRepository->getTotalPages($tag)) as $page) {
				yield [
					'slug' => $tag->slug,
					'page' => $page,
				];
			}
		}
	}
}
