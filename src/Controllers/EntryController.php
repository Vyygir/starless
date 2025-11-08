<?php

namespace Starless\Controllers;

use Tempest\Http\Responses\Redirect;
use Tempest\Router\Get;
use Tempest\Router\StaticPage;
use Tempest\View\View;
use Tempest\Http\Response;
use Starless\Repositories\EntryRepository;
use Starless\DataProviders\{EntryDataProvider, PaginatedEntryDataProvider};

use function Tempest\root_path;
use function Tempest\view;

final readonly class EntryController {
	public function __construct(
		private EntryRepository $repository
	) {}

	#[StaticPage]
	#[Get('/')]
	public function index(): Response|View {
		return $this->list();
	}

	#[StaticPage(PaginatedEntryDataProvider::class)]
	#[Get('/page/{page}')]
	public function paginated(int $page): Response|View {
		return $this->list($page);
	}

	private function list(int $page = 1): Response|View {
		$paginated = $this->repository->paginate($page - 1);

		if ($page > $paginated['maxPages']) {
			return new Redirect('nevermore');
		}

		return view(
			// I don't know what the fuck has happened here or why this is required, but here we are
			root_path('views/pages/home.view.php'),
			entries: $paginated['entries'],
			page: $page,
			maxPages: $paginated['maxPages'],
		);
	}

	#[StaticPage(EntryDataProvider::class)]
	#[Get('/{slug}')]
	public function read(string $slug): Response|View {
		$entry = $this->repository->find($slug);

		if (!$entry) {
			return new Redirect('nevermore');
		}

		return view('views/pages/entry.view.php', entry: $entry);
	}

	#[Get('/nevermore')]
	public function nevermore(): View {
		return view(root_path('views/pages/not-found.view.php'));
	}
}
