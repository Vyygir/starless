---
title: "Tempest: The Journey Thus Far"
slug: 'tempest-the-journey-thus-far'
published: "2025-10-26"
excerpt: "Tempest is definitely unique. After spending some time with it, I kind of need to get some pain points off my chest."
---

Let's start positively, purely so I can demonstrate that I'm not here to shit on someone's hard work.

1. The concept and the minimalism of the framework alone are astoundingly impressive
2. There's also proven points of success that demonstrate its strengths
3. Set up, especially once you've found your ideal working pattern, is incredibly straightforward
4. The syntax is genuinely beautiful and PHP 8.4 should be honoured to be its first target language version
5. Things that you'd worry about being cumbersome, like asset handling, are made to be simple
6. The overheads are seriously impressive in comparison to other frameworks
7. The point of usage-for-reason is just entirely unblocked by the concept of the framwork alone
8. The documentation website is genuinely beautiful and lovely to look at

There. I've done the positive bits. Now I can be ~~negative~~ provide my thoughts on my own experiences without feeling 
bad.

-----

### The Structure

I know this doesn't sound very open-minded but the build-your-whatever mindset that exists with Tempest, I feel, 
presents the same problem that I currently have with React: if you don't know how to actually build software that can 
scale well, then you're going to build something painfully unmaintainable that you'll hate in a few months.

I've experienced this far too often. Sometimes, you dive into code too early, before really thinking about the big 
picture and planning everything out. And, on occasion, that's warranted. But, in my experience, the vast majority of 
the time, what happens is that you end up with something that hasn't scaled well, is hard to maintain, and you end up 
wanting to refactor or, worse, re-build.

Shipping with some expected structures, even if it's a templated setup option, feels as though it'd offer more guidance 
and denote a structure from the offset, with expectancy. I think we're all pretty familiar with the two examples below:

```shell
# Layered
src/
├── Controllers/
│   ├── UserController.php
│   ├── PostController.php
│   └── CommentController.php
├── Entities/
│   ├── User.php
│   ├── Post.php
│   └── Comment.php
├── Repositories/
│   ├── UserRepository.php
│   ├── PostRepository.php
│   └── CommentRepository.php
└── Services/
    ├── AuthService.php
    └── NotificationService.php
```
```shell
# Domain-driven
src/
├── User/
│   ├── UserController.php
│   ├── User.php
│   ├── UserRepository.php
│   └── UserService.php
├── Post/
│   ├── PostController.php
│   ├── Post.php
│   ├── PostRepository.php
│   └── PostService.php
└── Comment/
    ├── CommentController.php
    ├── Comment.php
    ├── CommentRepository.php
    └── CommentService.php
```

Your choice of layering might not _specifically_ match either of the above but I do feel as though everyone has a 
preference that can _vaguely_ resemble one of these two. So an option to install a pre-designated set of directories 
with placeholder files wouldn't go amiss.

-----

### Discovery

Let me start with this: I **love** the idea of Discovery. Composer takes us part-way there but Tempest's Discovery 
implementation absolutely nailed the execution.

I know it got a some flak when Tempest was first being spoken about publicly and some people hate the idea of the 
micro-performance losses they might take from it. But, quite frankly, grow the fuck up. Caching is a thing. If you want 
to be upset about something at that scale, then go be upset at the amount of fucking bandwidth that's consumed, hourly, 
specifically so morons can browse Truth Social.

That being said... I definitely missed the scope of what Discovery can do. When I first looked at the documentation, I 
had two key takeaways.

1. It can find and appropriately contain classes registered in your code
2. It can can do the exact same thing... for **files**

This was the big thing for me. I had an idea that I'd use Discovery to find my entries in `./entries/*.md` and then 
load them into a repository. I even tried it. But the major problem I was hitting was that my `EntryRepository` wasn't 
actually in the container at the point of discovery which, when you read through 
[the bootstrap steps](https://tempestphp.com/2.x/internals/bootstrap) actually makes a lot of sense.

Discovery is executed _early_, just after the bootstrap classes are loaded, so that it can find everything it needs to. 
So... yeah. Why the fuck _would_ my `EntryRepository` exist then?

Because Tempest is still fairly new, I didn't have much hope of finding anyone else who'd done this. Until about ten 
minutes later when I stumbled upon
[Brent's implementation for the Stithcer.io rewrite](https://github.com/brendt/stitcher.io/blob/main/app/Blog/BlogPostRepository.php#L75).

That's right. Assuming you're capable of reading code, you should've just read that **the creator of the fucking 
framework** has already done this &mdash; without using Discovery. Yeah, I wasn't going to continue to try and shoehorn 
it, just to look like an ass in front of the people building Tempest.

My biggest gripe here? I genuinely wish it moved outside the scope of just application code. I know it's sort of
ingrained with Composer's autoloading too so it's not a total deal-breaker for me. Just a nice-to-have, in my mind.

-----

### The Structure: Again but Different

I'll keep this fairly simple. Here's how I wanted the Starless repository root to look:

```shell
starless/
├── assets
│   ├── styles/
│   ├── scripts/
    └── media/
├── config/
│   ├── discovery.config.php
│   └── view.config.php
├── entries/
│   └── *.md
├── public/
│   └── index.php
├── src/
│   ├── Controllers/
│   ├── Exceptions/
│   ├── Initializers/
│   ├── Models/
│   └── Support/
└── views/
    ├── layouts/
    └── pages/
```

I will say, I got close. It's not exactly what I wanted and I had to make a last minute revision to the structure when 
I realised that `DiscoveryLocation` was not pleased with me trying to use a full cache strategy on views whilst having 
them outside of `src`. But I'm not far off.

Here's how it looks right now, as of the latest commit:

```shell
starless/
├── assets
│   ├── main.entrypoint.css
│   └── highlight.css
├── entries/
│   └── *.md
├── public/
│   └── index.php
└── src/
    ├── Controllers/
    ├── Exceptions/
    ├── Initializers/
    ├── Models/
    ├── Support/
    ├── Views/
    │   ├── layouts/
    │   └── pages/
    └── vite.config.php
```

Like I said, not far off. However, just different enough to where I'm not a big lover of it.

I don't love the idea of interspersing controllers, repositories, entities, and whatever else in the same directory. 
That doesn't feel very separation-of-concerns-y enough for me.

But adding views into the mix, too? That's just fucking insane.

-----

### What's wrong with abstractions?

I get the usage of interfaces in the degree they are. But my god, sometimes, finding a reference is _painful_.

I feel like nearly everything is pointing to a generic upper layer that only vaguely implies what might exist when 
you're trying to understand how a segment of functionality works to, you know, implement something. And, because of how 
new Tempest is, not everything is fully documented yet. And the public use cases are slim pickings.

Yeah. This one's oddly specific. But I don't understand what was wrong with abstractions. Sometimes, you just need a 
thing that's been extended with another thing. It can get messy but, like I've already said, so can totally free-basing 
a codebase without a plan.

Six of one, I guess.

-----

### View Syntax

I'm going to be honest, I just struggle to parse this mentally in comparison to something like Twig. This is almost 
definitely a problem unique to me (because my brain don't do the working right). I just wanted to mention it though.

It is much cleaner than some others I've used. I'd choose this over WordPress' `get_template_part` any fucking day of 
the week.

-----

### `DateTime` (no, not that one)

For a few minutes, this _threw_ me. I was out of the fucking loop. Until I scrolled up a few minutes later and saw this:

```php
use Tempest\DateTime\DateTime;
```

Then it dawned on me what the problem was. And why the `\DateTime` interface wasn't working. Because _it wasn't the 
one I was fucking expecting._

Great. We've figured that out. So, let's output a timestamp with this format: `jS F, Y`.

Oh. Tempest's `DateTime` uses... a whole other formatting structure that I'm totally unfamiliar with. Sigh. Do I want 
to spend the time to figure this out?

No. I'm lazy and writing a journal that will have low traffic. For a while, I had this beauty:

```php
use DateTimeImmutable as NativeDateTimeImmutable;
```

Fortunately, that got deleted pretty quick when I was actively checking which interfaces I was actually using.

-----

### In summary

Look, I've written a few pain points here that I ran into, but your mileage is obviously going to vary.

Don't think this, in any regard, means I dislike Tempest. I was really excited to try it out. I went in with high hopes 
and let myself down by misunderstanding it from minute one.

For now, I think a lot of my time is going to go into Symfony still. It's withstood a huge test of time, paid its dues, 
and remains reliable to this day. I've got a couple of potential projects coming up that are already theorised for it, 
so that'll be an interesting pivot. And, who knows? Maybe I'll come out the other side thinking, "Hey, Tempest can do 
_this_ better than Symfony can".

Regardless, I'm still going to continue building Starless in Tempest and push through. I genuinely can't wait to see 
how it develops over time. Plus, if you're anything like me, I bet you can't wait for table inheritance to come to 
Tempest's database layers too.

_Yes, I know I can use Doctrine, but that's not the fucking point, is it?_
