<?php

namespace Starless\Repositories;

use Starless\Models\Tag;
use Tempest\Container\Singleton;
use Tempest\Support\Arr\ImmutableArray;
use Starless\Config\StarlessConfig;

use function Tempest\Support\arr;

#[Singleton]
class TagRepository {
	private ImmutableArray $tags;

	public function __construct(
		private readonly StarlessConfig $config,
	) {
		if (!empty($this->config->availableTags)) {
			$this->tags = arr($this->config->availableTags)->mapTo(Tag::class);
		}
	}

	public function all(): ImmutableArray {
		return $this->tags;
	}

	public function find(string $slug): ?Tag {
		return $this->all()->first(fn (Tag $tag) => $tag->slug === $slug);
	}

	/**
	 * @param array<string> $postTags
	 *
	 * @return ImmutableArray<Tag>
	 */
	public function getEntryTags(array $postTags): ImmutableArray {
		return arr($postTags)
			->map(fn (string $slug) => $this->find($slug))
			->filter();
	}
}