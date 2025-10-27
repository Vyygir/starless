<?php

namespace Starless\DataProviders;

use Generator;
use Tempest\Router\DataProvider;
use Starless\Repositories\EntryRepository;

class EntryDataProvider implements DataProvider {
	public function __construct(
		private EntryRepository $repository,
	) {}

	public function provide(): Generator {
		foreach ($this->repository->all()->toArray() as $entry) {
			yield [
				'slug' => $entry->slug,
			];
		}
	}
}
