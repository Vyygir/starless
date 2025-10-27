<?php

namespace Starless\DataProviders;

use Generator;
use Tempest\Router\DataProvider;
use Starless\Repositories\EntryRepository;

class PaginationDataProvider implements DataProvider {
	public function __construct(
		private EntryRepository $repository,
	) {}

	public function provide(): Generator {
		foreach (range(1, $this->repository->getTotalPages()) as $page) {
			yield [
				'page' => $page,
			];
		}
	}
}
