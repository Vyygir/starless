<?php

namespace Starless\Controllers;

use Tempest\Http\Responses\Redirect;
use Tempest\Router\Get;
use Tempest\Router\StaticPage;
use Tempest\View\View;
use Tempest\Http\Response;
use Starless\DataProviders\{TagDataProvider, TaggedPaginatedEntryDataProvider};
use Starless\Repositories\{EntryRepository, TagRepository};

use function Tempest\view;

final readonly class TagController {
	public function __construct(
		private TagRepository $repository,
		private EntryRepository $entryRepository,
	) {}

	#[StaticPage(TagDataProvider::class)]
	#[Get('/tag/{slug}')]
	public function index(string $slug): Response|View {
		return $this->list($slug);
	}

	#[StaticPage(TaggedPaginatedEntryDataProvider::class)]
	#[Get('/tag/{slug}/page/{page}')]
	public function paginated(string $slug, int $page): Response|View {
		return $this->list($slug, $page);
	}

	private function list(string $slug, int $page = 1): Response|View {
		$tag = $this->repository->find($slug);

		if (!$tag) {
			return new Redirect('/nevermore');
		}

		$paginated = $this->entryRepository->paginate($page - 1, $tag);

		if ($page > $paginated['maxPages'] || empty($paginated['entries'])) {
			return new Redirect('/nevermore');
		}

		return view(
			'views/pages/tag.view.php',
			tag: $tag,
			entries: $paginated['entries'],
			page: $page,
			maxPages: $paginated['maxPages'],
		);
	}
}
