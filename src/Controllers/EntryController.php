<?php

namespace Starless\Controllers;

use Tempest\Http\Responses\Redirect;
use Tempest\Router\Get;
use Tempest\View\View;
use Tempest\Http\Response;
use Starless\Repositories\EntryRepository;

use function Tempest\view;

final readonly class EntryController {
	public function __construct(
		private EntryRepository $repository
	) {}

    #[Get('/')]
	#[Get('/page/{page}')]
    public function index(int $page = 1): Response|View {
		$paginated = $this->repository->paginate($page - 1, 5);

		if ($page > $paginated['maxPages']) {
			return new Redirect('nevermore');
		}

		return view(
			'pages/home.view.php',
			entries: $paginated['entries'],
			page: $page,
			maxPages: $paginated['maxPages'],
		);
    }

	#[Get('/{slug}')]
	public function read(string $slug): Response|View {
		$entry = $this->repository->find($slug);

		if (!$entry) {
			return new Redirect('nevermore');
		}

		return view('pages/entry.view.php', entry: $entry);
	}

	#[Get('/nevermore')]
	public function nevermore(): View {
		return view('pages/not-found.view.php');
	}
}
