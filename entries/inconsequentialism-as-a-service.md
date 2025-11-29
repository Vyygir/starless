---
title: "Inconsequentialism as a Service"
slug: 'inconsequentialism-as-a-service'
published: "2025-11-29"
excerpt: "The WordPress Chronicles; also known as Automattic's ventures into the maelstrom of engineering, or a swathe of hellspawn bred from relevance"
tags: ['engineering', 'wordpress']
---

From the title alone, it would be exceptionally easy to assume that I dislike, or even hate, WordPress. While I'm not 
one for brewing assumptions from the first few lines, I'm inclined to tell you that would absolutely be correct.

To be clear, I don't _hate_ WordPress itself, as such. I have severe contempt for several facets of it; I don't, in 
any semblance, believe that the current architecture is suitable; I hold a special disdain for people who dare to call 
themselves "developers" without so much as learning a line of code.

WordPress itself is an "open-source" (we'll come back to this later) content-management system that, by all accounts, 
is the best tool available. There are frequent and regular updates, thousands of plugins, regular compatibility reviews, 
and, of course, the golden child: *Gutenberg*.

Scratch the surface of anything with even a modicum of knowledge and you'll quickly find problems.

Below, I'll explore specifically _why_ WordPress isn't, likely, what you think it is and why you've been using it for 
the wrong purposes, all this time.

-----

## An ode to 4.x

Let's start with the major problem first: **PHP**.

WordPress' major backing technology is the language we all know and love. It was a fork of another system, and pursued 
a different direction. PHP in 2003 was completely different to what it was, even in 2013. We're now in 2025 and have 
since learned that, yes, we can create true programming form in it.

Yet, oddly, WordPress' entire underlying foundation is built as though it were 2015. Possibly earlier. There are 
still [decades old `@fixme` tags in core](https://github.com/WordPress/WordPress/blame/47f76234dae5407244c1333a6a23d5b92a3c3d5d/wp-admin/includes/class-wp-filesystem-direct.php#L252).

We're now in an era where PHP is more than capable, with a host of new paradigms:

- Dependency injection
- Service containers
- Native enumerations (...sort of)
- Stable and reliable dependency management
- Clearer type inference

And does WordPress core utilise any of these?

If you hadn't guessed by this point, or assumed otherwise, the correct answer is: no.

WordPress is severely lacking in the principles of modern-era programming which, for people like me, removes nearly all 
enjoyment out of working with it, emphatically.

To this day, I don't know if the plan is for the core team(s) to work on this or whether there even is a plan but, in 
truth, it seems unlikely. The block editor and the full-site editor seem to be the direction that the teams have 
adopted, which leaves one question in my mind: when will usage be enough for "classic" themes and "the old ways" to be 
abandoned entirely?

This obviously speculates a huge shift in the typical ecosystem but, quite earnestly, this is the only outcome that I 
can currently see happening.

-----

## Stigmatised by carelessness

In some senses, if a software engineer has heard of WordPress, there's usually one of two stances:

1. Believing, without a single doubt, that it does what it needs to do, purposefully and amazingly
2. Detests it with such a passion that they will think lesser of you for being near it

This could be expanded on, heavily, but we're focusing on the dichotomous viewpoints.

WordPress is extensively, at a surface level, stigmatised. Usually by phrases, such as "plethora of security issues", 
"poorly built", "_X_ is better", or "can be used for anything".

Frankly, the point that annoys me the most here is the fact these come from the surface, and nothing more. They're 
broad-strokes assumption without either knowing or word-of-mouth opinions. Having used WordPress extensively for over a 
decade, I can tell you, with complete precision, why it would or would not be suitable.

But the scale of WordPress is so large now that the narrative is almost impossible to change. Someone either loves or 
hates it. There's almost no in-between.

Humans develop opinions of their own free-will almost and, usually, believe a trusted source (meaning, a source that 
particular human trusts). Whilst mass-opinion is largely difficult to contain and subvert, it's much easier to speak 
from experience with something like this.

### "WordPress is insecure"

No. The plugin layer presents issues because, unfortunately, a lot of the people writing plugins don't really know how 
to do so, correctly, nor do they understand programming separately.

Lack of experience, understanding, and skill is where security holes open, not in the core stack.

There are also ways to work around the core issues. [Roots](https://roots.io/) presents various ways to improve the 
platform from a developer experience, as well as fixing issues by implementing itself alone.

### "WordPress is poorly built"

We have somewhat covered this, but I'll reiterate: yes and no.

WordPress exists and works, almost without security issues. But, as we've discussed, the foundations are old and the 
developer experience has long decayed.

Does it work, completely, from a purely vanilla installation? Yes. Is it enjoyable to build with? Absolutely not.

### "_X_ is better"

There is no argument to this. If you enjoy building with something, you build with it.

If you really are wasting time arguing with someone about why something like WordPress is _objectively_ better, then 
you don't deserve to be connected to the internet. It is _subjectively_ better, bottom-line.

### "WordPress can be used for anything"

Yes, similarly to how a toaster could also be used as an under-desk heater, **does not mean it should**.

At the end of the day, web presents fewer limitations than typical software engineering because the platform is so open.

Speaking from experience, WordPress is **not** a framework to build whatever you want on top of it. That's not the 
goal, nor should it be. If you find yourself running into walls with something, agnostically, then you're using the 
wrong framework.

Attempting to shoehorn a fucking CRM or a user-management system into WordPress have always be, and will forever be 
terrible ideas.

_**Note:** I say from experience as I spent 7+ years at an agency where WordPress was the **only** tool of use. That 
was it. There was zero accountability for poor programming, zero concept of attempting to use appropriate tools, and 
absolutely no learning opportunities. I do not recommend it._

-----

## The "developer" problem

There isn't a short or nice way of this being said, frankly, so we'll get it over with: developers who are exclusively 
experienced in WordPress can't really call themselves developers.

It may sound harsh but the reality is that WordPress' learning curve is so low, that it will let you get away with far 
too much. I've worked with people who barely knew functional programming, even at the most basic level, and refused to 
learn further because they didn't need to.

Perhaps I'm jaded, but I'm reserving the right to be after having to maintain codebases that look like this:
```php
<?php
$p = get_posts(array(...));
$fp = $p[0];
?>

<div ...>
    <?php echo get_the_title(get_the_ID($fp)); ?>
    <p><?php echo get_the_excerpt($fp); ?></p>
</div>
```

There's a cacophony of problems with the code, clearly, and this is what people usually expect when they look into a 
WordPress-backed project.

There are some exceptions. Roots, like I've mentioned, have hugely improved the developer experience overall, and you 
really can ignore a lot of what's going on, and write your own layers. But, unfortunately, we will forever be burdened 
with code like the above, solely because of the amount of people who rely on basics.

The other backed issue is the plugin ecosystem. I could leave this by just saying that Subversion still being a present 
day requirement for this is demotivational, at best. The grim reality is that there are **a lot** of plugins that are 
fucking awful; they pollute the ecosystem heavily, without most people knowing why it's a problem.

The npm package ecosystem has a similar issue. There's 
[a package for nearly everything](https://www.npmjs.com/package/if), unfortunately, and people will willingly use them. 
Similarly, there's [a plugin for nearly everything](https://wordpress.org/plugins/svg-support/) too. This let's people 
throw together a harrowed mess of a project with infinite dependencies, minimal code, and call it product ready.

Frankly, you'd be surprised how often these happen (or maybe not), when a good handful of hours could be spent building 
something idyllic and clean, that does all the heavy lifting without needing 38 plugins.

-----

## Johannes' dying legacy

Gutenberg &mdash; the German inventor, not the block editor &mdash; revolutionised printing technology, which gave way 
to breakthroughs of literature in Renaissance-era Europe.

Alternatively, Gutenberg &mdash; the block editor, not the German inventor &mdash; has created a haphazard editing 
experience that's still technically not finished, by solving problems that don't technically exist.

The _idea_ of the block editor was solid, even the principles. But the implementation? It leaves a lot to be desired. I 
don't even know what the goals are today because, whilst 
[the `NumberControl` field exists in perpetual experimentation](https://developer.wordpress.org/block-editor/reference-guides/components/number-control/), 
they're now planning to completely revitalise the back-end by expanding the full-site editor, as a replacement.

_What?_

I'm honestly confused by the state of the... block editor? Full-site editor? Back-end editor?

The reality is that the complexities of it are growing more and more, but the previous complexities haven't been 
resolved. So, what's actually being delivered is a product that isn't technically finished with an ever-growing list 
of unfinished implementations.

Given the wide landscape of modular editors that were already available for WordPress, whilst fucking awful by most 
metrics, they at least had features that supported responsive design. The block editor is now leading the way with less 
backing, less experience, and fewer features than others.

As someone who, again, has spent an extremely long time with WordPress, I do believe that the direction is changing 
beneath us. The entire platform is slowly shifting into site-building as an experience, rather than a framework of a 
content-management system.

Arguably, this is good. If this is correct, then WordPress has a tangible use case, which means people can stop trying 
to shoehorn things into it that don't fucking belong there. I can't say that I necessarily agree with the fully React 
backed implementation, and the data architecture is still weak &mdash; though, it's arguable that's because of the 
initial data model &mdash; but at least it becomes something slightly more purposeful than what it is right now.

### What's wrong with React?

Don't get me started. This is an entry of its own, that needs a lot of expansion, but the major problems with the 
paradigm the Gutenberg team are following are:

- Weak server-side backing leading to a poor data architecture
- Poorly implemented REST API layer without considerations for implementation
- Sudden technology-swap for existing developers
- Extremely high learning curve for new developers
- Community input is, effectively, negligible because it's often ignored

-----

## Leadership calamity

WordPress, similarly to PHP, is an open-source project, designed by committee.

But not really. It really operates with minimal technical governance, because of single-party ownership, under the 
[Benevolent Dictator for Life](https://en.wikipedia.org/wiki/Benevolent_dictator_for_life) model.

Companies do contribute, but the process to do so is... convoluted, at best. There's also a fairly serious risk of your 
contributions being vetoed entirely, if they don't align with ~~party~~ "committee" consensus.

Automattic offers the most contributions to WordPress(.org), by far. There are hundreds of contributions from other 
companies and teams, but it really is in their best interest to maintain it as well as they can. The ownership of 
`.org` is an entirely different story though. Whilst it is open to contributions, mostly, there's a very strong 
overhead of governance above it.

Somewhat of a... dark, looming presence...

### The Mullenweg Convolution

There's no two ways about this issue. You either idealise Matt Mullenweg, for some reason, or you've woken up and 
finally realised that he's just a petulant, egotistical narcissist with control issues, and absolutely no engineering 
skills.

If [the WPEngine debacle](https://techcrunch.com/2025/01/12/wordpress-vs-wp-engine-drama-explained/) wasn't enough to 
wake you up, then I'm afraid you're a lost cause. If you personally knew Charles Manson, you'd be the first on the 
ranch.

I'm not saying that he doesn't have some valid points on WPEngine's business model and practices. He did.

Until his decision was to forcibly take ownership of Advanced Custom Fields, entirely, and rename it to "Secure Custom 
Fields", potentially breaking dependency chains. We don't even use the plugin but the _audacity_ of it alone had me 
enraged. 

And let's not forget the major attempt to fuck over anyone who happened to have the majority of their projects on 
WPEngine, by preventing automatic security updates via the plugin directory &mdash; which, to give credit where it's 
due, led to the creation of the 
[FAIR Package Manager](https://www.linuxfoundation.org/press/linux-foundation-announces-the-fair-package-manager-project-for-open-source-content-management-system-stability).

Oh, or the site they made to track WPEngine losses, whilst publicly leaking fucking domains registered on WPEngine 
infrastructure, in a CSV file. And yes, that piece of shit [is still online](https://wordpressenginetracker.com/).

So, personally, from me to you, Matt, should you ever read this: fuck you, you degenerate cunt. The sooner you step 
back from the helm and seek therapy, the better. You are in no way fit to lead, manage, or otherwise represent an open 
source community. 

That really was a _fun_ few weeks at work. Especially when clients started noticing. It's a really fun conversation to 
have with the people who provide your income.

-----

## The ideal scenario

WordPress, in practice, is very easy to do right. But a lot of people don't, as has been mentioned.

At its heart, it's a content-management system. It doesn't claim to be anything more. The new layers that are being 
implemented now are really what's changing the direction of the platform.

The solution, then, is to build sites in WordPress that should really be implemented in it. Simple, content-driven 
sites that don't need a huge amount of complex logic or bespoke features.

Modern-era WordPress, backed by Gutenberg, will deliver a site that works and does what it has to, with very little 
code or customisation, if any. Unfortunately for engineers, the reality is that bespoke programming really isn't 
needed, unless it's at a higher-level in these scenarios.

If this is the way WordPress is leaning though, then it's ideal. I'm more than ready for the era of WordPress to shift 
into a more Webflow or Figma Sites like state. We just need to then stop pretending that engineers are actually 
required and accept the limitations as they come.

As an engineer, that finally gives me the chance to write software in the way it's supposed to be written. If it needs 
to become partnered with a content-driven site, then that's fine. But I do think the era has come to finally stop 
shoehorning things into WordPress, that it wasn't supposed to do, and let it form into what it now needs to become.

A **content**-management system.

### WooCommerce

I know someone will mention this. I just know it.

WooCommerce itself is a satchel of irony, sprinkled with hypocrisy.

For small businesses or new stores that need a quiet, simple marketplace; fine. WooCommerce might be the solution.

At scale though? You're destined to struggle. That isn't what it's made for. And, ignoring the fact that WordPress 
alone doesn't scale well, WooCommerce does even more poorly. Whilst they may use modern programming and actually write 
the software like it matters, the problem is, and will always be, that it's backed by a system that hasn't seen an 
architectural upgrade in roughly a decade.

There isn't a technical resolution to that. If your foundations are weak, then so is your product. This is the same 
problem that **a lot** of plugins will face.

I've hit similar limitations with systems in WordPress where my only two viable suggestions were:

- Create our own table schemas with appropriate indexing
- Move the complex part of the system out of WordPress entirely

I'd prefer the latter, clearly.

-----

## Let's breathe

There are a lot of words above and, if you've made it this far, then congratulations. There's no medal though. I won't 
enable your need for validation, just for reading an excessively long entry. You might be slightly more insane though.

To summarise, WordPress isn't something you can form an opinion on without using it and knowing the ecosystem. I don't 
believe that someone should dedicate ten years to something, for the outcome to match what they initially thought.

Alternatively, from experience, there's a lot of issues above and I do feel that I'm at the end of the line with 
WordPress now. I've handled other languages, developed other projects, and worked with other tools, all that gave me a 
much more enjoyable experience than it currently does.

It really is just a change of direction on both ends. WordPress isn't something that I necessarily want to spend my 
time working exclusively with for much longer. It doesn't spark the joy it once did when I was a young, eager coder.

But do I hate WordPress? No. Not necessarily. I think it has its place in the world but that place just happens to be a 
fairly long throwing-distance away from my place.

Should you hate WordPress? That's up to you entirely. It has _a_ purpose, surely, nothing exists without one. It's up 
to you to go and find the alignment.
