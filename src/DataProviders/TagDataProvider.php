<?php

namespace Starless\DataProviders;

use Generator;
use Tempest\Router\DataProvider;
use Starless\Repositories\TagRepository;

final readonly class TagDataProvider implements DataProvider {
	public function __construct(
		private TagRepository $repository,
	) {}

	public function provide(): Generator {
		foreach ($this->repository->all() as $tag) {
			yield [
				'slug' => $tag->slug,
			];
		}
	}
}