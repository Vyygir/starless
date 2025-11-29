<?php

namespace Starless\Repositories;

use DateException, DateTimeImmutable;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use Tempest\Container\Singleton;
use Tempest\Cache\Cache;
use Tempest\Support\Arr\ImmutableArray;
use Starless\Config\StarlessConfig;
use Starless\Mappers\EntryMapper;
use Starless\Models\{Entry, Tag};
use Starless\Exceptions\EntryParsingException;

use function Tempest\map;
use function Tempest\root_path;
use function Tempest\Support\arr;
use function Tempest\Support\Str\strip_start;

#[Singleton]
class EntryRepository {
	public function __construct(
		private readonly StarlessConfig $config,
		private array $entries = [],
		private readonly MarkdownConverter $converter,

		/** @todo Yes, we need to implement caching, I know. */
        //private Cache $cache,
	) {
		$files = glob(root_path('/entries/*.md'));

		if (empty($files)) {
			return;
		}

		foreach ($files as $filepath) {
			try {
				$contents = file_get_contents($filepath);

				if (!$contents) {
					throw new EntryParsingException('No content in file: ' . strip_start($filepath, root_path()));
				}

				$entry = $this->processPotentialEntry($contents);
			} catch (EntryParsingException $e) {
				ll(sprintf('Markdown error: "%s" for "%s"', $e->getMessage(), strip_start($filepath, root_path())));
			}

			if (!$entry instanceof RenderedContentWithFrontMatter) {
				continue;
			}

			$this->entries[] = map([
				'content' => $entry->getContent(),
				'source' => $contents,
				...$entry->getFrontMatter(),
			])->with(EntryMapper::class)->to(Entry::class);
		}
	}

	public function find(string $slug): ?Entry {
		return $this->all()->first(fn (Entry $entry) => $entry->slug === $slug);
	}

	public function all(?Tag $tag = null, bool $output = false): ImmutableArray {
		return arr($this->entries)
			->filter(fn (Entry $entry) => new DateTimeImmutable($entry->published) <= new DateTimeImmutable())
			->filter(fn (Entry $entry) => is_null($tag) || $entry->tags->contains($tag))
			->sortByCallback(fn (Entry $a, Entry $b) => $b->published <=> $a->published);
	}

	public function getTotalPages(?Tag $tag = null): int {
		return max(ceil($this->all($tag)->count() / $this->config->entriesPerPage), 1);
	}

	/** @return array [ entries: ?ImmutableArray, maxPages: int ] */
	public function paginate(int $offset, ?Tag $tag = null): array {
		$entries = $this->all($tag);

		return [
			'entries' => $entries->slice($offset * $this->config->entriesPerPage, $this->config->entriesPerPage),
			'maxPages' => $this->getTotalPages($tag),
		];
	}

	private function processPotentialEntry(string $contents): RenderedContentWithFrontMatter {
		try {
			$document = $this->converter->convert($contents);
		} catch (CommonMarkException) {
			throw new EntryParsingException('Unable to parse markdown');
		}

		if (!$document instanceof RenderedContentWithFrontMatter) {
			throw new EntryParsingException('File did not have any front matter');
		}

		$content = $document->getContent();

		if (empty($content)) {
			throw new EntryParsingException('File is missing content');
		}

		$meta = $document->getFrontMatter();
		$missingKeys = array_diff([ 'title', 'slug', 'published', 'excerpt' ], array_keys($meta));

		if (!empty($missingKeys)) {
			throw new EntryParsingException('Front matter is missing required keys (title, slug, published, excerpt)');
		}

		try {
			new DateTimeImmutable($meta['published']);

			if (isset($meta['updated'])) {
				new DateTimeImmutable($meta['updated']);
			}
		} catch (DateException) {
			throw new EntryParsingException('File dates could not be parsed');
		}

		return $document;
	}
}