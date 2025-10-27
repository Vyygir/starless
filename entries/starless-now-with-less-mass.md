---
title: "Starless: Now With Less Mass"
slug: 'starless-now-with-less-mass'
published: "2025-10-27"
excerpt: "The original amount of mass felt a bit too dense. Chances of spaghettification whilst reading have now been reduced to only around 14%."
---

I'll keep it brief but Starless is now using static generation to serve pages, instead of just serving directly through 
the `EntryRepository` in PHP every time.

Why? I'll tell you why. Because some degenerate, shithead of a script kiddy with a terminal and a "botnet" called 
`epic_bot.py` on their fucking desktop thought it'd be a wonderful idea to shoot a constant stream of requests to the 
site for a fixed period of a few hours.

Starless has been live for just under 48 hours and it already has more errors than views, thanks to this rock-brained 
gremlin.

You want to know the worst bit?

**It took under 24 fucking hours for me to see a request come through, attempting to enumerate users via the WP REST 
API. That is how prolific people trying to exploit WordPress are now. They just wing it with every new site that 
manifests.**

Sigh. It really isn't WordPress. I promise you.

And, don't get me wrong, whilst I _did_ want to implement static generation in, I wanted to do it on _my_ terms.

-----

### A brief glimpse into the expanse

Static generation in Tempest is actually wildly simplistic. Have a look at the route actions in the `EntryController`:

```php
#[StaticPage]
#[Get('/')]
public function index(): Response|View {
	return $this->list();
}

#[StaticPage(PaginationDataProvider::class)]
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
		'View/pages/home.view.php',
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

	return view('View/pages/entry.view.php', entry: $entry);
}
```

That's it.

You tell the framework you want a specific route to be static and you run `tempest static:generate`. And then it does 
it.

It's obviously just a touch more complex for two of our routes there. You can see, for `/page/{page}` and `/{slug}`, 
we're giving the attribute data provider classes. Similarly though, data providers aren't really that difficult once 
you read through the documentation:

```php
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
```

Grab the entries in the repository, iterate over them, and then yield the arguments that would be passed to 
each static call for specific iteration. Once you wrap your head around the point, it slots together nicely.

The data provider for the paginated structure is just as simple, frankly, but I'll let you go find one on the 
[repository](https://github.com/Vyygir/starless) yourself.

-----

### Final thoughts

Like I said, to whichever moron it is who thinks Python is a low-level fucking language, knock it off. Get a job. What 
are you _actively_ seeking inside of WordPress sites? Having maintained **a lot** them for over a decade, I can 
tell you, from experience, they're really not that interesting.

I _did_ want to add tagging to Starless today but I've had to focus on this, amongst other things. The View system is 
still causing some issues but, if I'm being entirely honest, broken markup is the least of my worries right now.
