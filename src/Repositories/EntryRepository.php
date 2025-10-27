<?php

namespace Starless\Repositories;

use DateException, DateTimeImmutable;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use Tempest\Container\Singleton;
use Tempest\Cache\Cache;
use Tempest\Support\Arr\MutableArray;
use Starless\Config\StarlessConfig;
use Starless\Models\Entry;
use Starless\Exceptions\EntryParsingException;

use function Tempest\map;
use function Tempest\root_path;
use function Tempest\Support\Str\strip_start;

#[Singleton]
class EntryRepository {
	public function __construct(
		private StarlessConfig $config,
		private MutableArray $entries,
		private MarkdownConverter $converter,

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

			$this->add($entry, $contents);
		}
	}

	public function find(string $slug): ?Entry {
		return $this->all()->first(fn (Entry $entry) => $entry->slug === $slug);
	}

	public function all(): MutableArray {
		return $this->entries
			->filter(fn (Entry $entry) => new DateTimeImmutable($entry->published) <= new DateTimeImmutable())
			->sortByCallback(fn (Entry $a, Entry $b) => $b->published <=> $a->published);
	}

	public function getTotalPages(): int {
		return ceil($this->all()->toImmutableArray()->count() / $this->config->entriesPerPage);
	}

	/** @return array [ entries: ?ImmutableArray, maxPages: int ] */
	public function paginate(int $offset): array {
		$entries = $this->all()->toImmutableArray();

		return [
			'entries' => $entries->slice($offset, $this->config->entriesPerPage),
			'maxPages' => $this->getTotalPages(),
		];
	}

	public function add(RenderedContentWithFrontMatter $entry, string $sourceContent): void {
		$this->entries->push(
			map([
				'content' => $entry->getContent(),
				'source' => $sourceContent,
				...$entry->getFrontMatter(),
			])->to(Entry::class)
		);
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