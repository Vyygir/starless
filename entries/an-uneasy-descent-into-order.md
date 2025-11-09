---
title: "An uneasy descent into order"
slug: 'an-uneasy-descent-into-order'
published: "2025-11-09"
excerpt: "The most merciful thing in the world, I think, is the inability of the human mind to correlate all its contents."
tags: ['starless']
---

Ah, order.

Organised.

_Clean._

Starless now has tags that let me appropriately systematize both the lucid and fevered ramblings that I write.

This was something I've wanted to add since the initial (successful) deployment. It felt like a natural next step. I do 
have other plans but, for now, I'm focusing on building what I _want_ to build, instead of trying to force some sort of 
derived set of features out.

They're not difficult to spot, clearly. Observe the top of an entry and you'll see them. On individual articles, you 
can click a tag to be taken to an archive of posts with the same tag.

If you struggle with this, I cannot help you. To be clear, I probably can. But I won't.

-----

### And the rest

A great deal of other changes were made in the same 
[commit](https://github.com/Vyygir/starless/commit/31d12ff54c0c3c82b79f852de35cef1b6561049c#diff-25c9e3f4cefe5cbcc3ed7ee22c07418acf3822af66bc1fc3badb5d7e7db385e1) 
that the tag implementation was in. Granted, they're not nearly as obvious; mostly refactor work and minor improvements.

But if you're curious, read through the commit and review the summary:

1. `config` and `views` were finally moved to the root of the project (beside `src` instead of inside it)
2. The broken meta tag output for the header has been fixed
3. Views have been updated to only have two layers of nesting instead of three
4. Components are better utilised in views for non-unique elements
5. Tags are appropriately statically generated, [similarly to how entries are](/starless-now-with-less-mass/)
6. A manifest and site icons now actually exist, instead of the Tempest default
7. Use of `ImmutableArray` has been improved in the `EntryRepository` to stop clashing data when build processes happen
8. Entries are now mapped manually to make sure that tags are loaded through appropriately
9. Tempest has been updated to 2.7.0 (which means that some view paths now want to be wrapped in `root_path` for some reason?)
10. `readonly` has been applied to various places where it could be

A lot of changes for one commit but, once again, Starless isn't made under the guise of perfection. I'm usually 
[averse to large commits](https://www.conventionalcommits.org) but, given this stemmed from sitting down and writing 
code, I gave myself a break.
