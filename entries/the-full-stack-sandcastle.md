---
title: "The Full-Stack Sandcastle"
slug: 'the-full-stack-sandcastle'
published: "2025-12-04"
excerpt: "Beautiful from afar; unstable up close. Issues with skills or consensus hater?"
tags: [ 'engineering', 'javascript', 'typescript' ]
---

JavaScript. The web foundation that's leading modern... ahem, _programming_, for better, or for worse.

Unfortunately, I'm not going to be able to cover the things that people _want_ to see. No, this wouldn't be a Starless
entry if I fed the machine. This entry is fueled by the slowly-dawning realisation that's taken years to solidify: I'm
very much over JavaScript.

-----

### Foundational decay

There are an exceptional amount of posts praising the language in recent days, and nearly as many slandering it. I
don't want to be yet another hollow voice in the void, so my coverage will differ as best as I can.

The grim reality is that, as much as I've used JavaScript over the years &mdash; you could even surmise that it's
responsible for a large part of my career &mdash; I just struggle to enjoy it these days. Every time I open a file
with the dreaded extension, it's almost like a pit opens in my stomach. Quite frankly, it's pure chance whether there's
going to be something marginally tolerable inside, or a cesspit of unadulterated slop.

Even if I am writing from scratch, the experience is still disheartening. Almost nothing about the language brings me
any joy.

There are clear, historical and newly-implemented problems that could turn into a week's long discussion &mdash; but
we won't. There's no need because a thousand other people have already done so in the past week alone, most likely.
Ignoring these entirely, let's take a look at something that really doesn't sit right:

```js
class Example {
    #parameter = null;

    constructor(parameter) {
        this.parameter = parameter;
    }

    getParameter() {
        return this.#parameter;
    }

    setParameter(parameter) {
        this.#parameter = parameter;
    }
}
```

To whomever decided that a hash (`#`) was, ultimately, the best choice for denoting privacy in native class syntax:
**fuck you**. You were vehemently wrong and have only achieved making something that was already unappealing, far less
tolerable.

And if you even _dare_ ask why I've used a typical pattern for the getter/setter here, I'd ask you to consider why you
stand by and tolerate the current implementation?

```js
class Valuable {
    #value = 0;

    get value() {
        return this.#value;
    }

    set value(value) {
        this.#value = value;
    }
}
```

Let's take a look at how PHP does something similar:

```php
class Valuable {
    private int $value = 0 {
        get {
            return $this->value;
        }
        set (int $value) {
            $this->value = $value;
        }
    };
}
```

PHP's [property hooks](https://www.php.net/manual/en/language.oop5.property-hooks.php) implementation has a
much cleaner syntax, in my opinion. It's encapsulated alongside the definition.

None of this even remotely covers the other issues I have with [the sheer and insurmountable abundance of APIs] that
seem to lack a severe amount of consistency. I'm also not going to lean on the widely-moot point that there's no native
typing because TypeScript already has its own section.

Let's cobble together another example:

```js
let count = 0;

function increment(event) {
    event.target.innerText = ++count;
}

export default function () {
    document.querySelector("#counter").addEventListener("click", increment);
}
```

I just severely struggle to enjoy this. Maybe because it's bound in interactivity, instead of something I actually
enjoy doing. But I couldn't see myself maintaining with a language and avoiding at least half of it.

-----

### Iteration hell via opinion-ism

Frameworks. How many are there now? Perhaps, too many.

Ask any one who works fundamentally with client-side frameworks and they'll have an opinion &mdash; React, Vue, Svelte,
Next, Nuxt, Angular. So on, so forth.

```js
export function Counter() {
    const [count, setCount] = useState(0);

    return <button onClick={() => setCount(count + 1)}>{count}</button>
}
```
```html
<script>
let count = 0;
</script>

<button on:click={ ()=> count++ }>{ count }</button>
```
```html
<script setup>
    import { ref } from "vue";
    const count = ref(0);
</script>

<template>
    <button @click="count++">{{ count }}</button>
</template>
```

These are, quite literally, different ways of doing the exact same thing. But really it all boils down to preference.

You may prefer once syntax; your colleague prefers another; yet your friend prefers another. And it's all just 
redundant noise, isn't it?

The examples above are primitive concepts, at best, that demonstrate a framework at the simplest level. The core has 
certainly changed but the outcome hasn't &mdash; and only at the expense of the user.

Other frameworks, like Nuxt or Next, took the primitive layers and ran with them to make their own structures, only 
with more opinions. And, quite honestly, there's nothing I really like about any of the opinions I've seen so far.

It's been a few years now and I still _cannot_ fucking stand the idea of nested routing via directories. I apologise 
to no one, it's purely something I don't like about "the modern ecosystem".

Whether it's the language-choice backing or the ecosystem itself, I can't say. I'm entirely uncertain why I've not been 
able to enjoy this side of web in recent years.

-----

### Dependence

This may well be the only section that has majority agreement, versus plain denial. The dependency situation of the 
JavaScript ecosystem has become disdainful.

There's been somewhat of an uptick in 
[supply-chain attack vectors](https://www.cisa.gov/news-events/alerts/2025/09/23/widespread-supply-chain-compromise-impacting-npm-ecosystem)
in the past few years, which is unfortunate. Despite the size and unmaintainability of some of the packages, the team 
over at npmjs really are serving a wonderful purpose and doing a fantastic job, at scale. Coming from WordPress, the  
lack of a real dependency management system and having to shoehorn Composer into most of our projects does make me 
appreciate people who do this kind of work, a lot more.

However, that being said, I'm struggling to find myself excusing package developers and maintainers. Granted, some 
packages [are](https://www.npmjs.com/package/is-ten-thousand) [clearly](https://www.npmjs.com/package/true) 
[humorous](https://www.npmjs.com/package/emoji-poop) and [trivial](https://www.npmjs.com/package/is-odd) 
[jokes](https://www.npmjs.com/package/is-even) &mdash; but not all of them are. And "developers" will use them, create 
a dependency on them, and then treat that as the norm.

**There's a package for everything.**

Ah, yes, the re-coined term used by people who typically don't know what a shared utility library is.

And do you know what people who arbitrarily install packages do? Simply put: they arbitrarily install packages. And do 
you know what presents a risk to users who install things without thinking?

Yes, that's right: [the npm garbage patch](https://blog.phylum.io/the-great-npm-garbage-patch/).

This is precisely why your operating system prevents you from doing things it doesn't think you should be doing, by 
yourself, unattended. Not because it wants to control your life or steal your data &mdash; but because you are a moron 
and need protecting from yourself.

Unfortunately, large package ecosystems can and will develop serious issues now and then: security violations; 
dependency chain attacks; bloatware; malware; all sorts of other extremely enjoyable and entertaining risks.

If you don't believe me, 
[something similar happened to OpenVSX](https://www.koi.ai/blog/glassworm-first-self-propagating-worm-using-invisible-code-hits-openvsx-marketplace#heading-5),
the open-source alternative to Visual Studio Code's marketplace, which is at a much smaller scale than npm.

Whilst JavaScript has made coding more accessible, npmjs has also made ease of exploit exceptionally higher for 
people who, despite learning to write code, aren't typically security-minded. And the barrier, unfortunately, is 
perpetually low in this environment, because the ramp-up of expertise is, frankly, optional.

-----

### TypeScript: The Phantom Compiler

Earlier, I wrote about JavaScript quite generally, and in a slightly vague way &mdash; for a reason. Because there's 
**always** a devoted scripter who thinks that being able to composite types over a language, that will never natively 
support them, makes them the next Linus fucking Torvalds.

I am, truthfully and emphatically, completely unimpressed and disappointed by TypeScript.

This is my genuine opinion and, mostly, I'm finding the dreary monotony of seeing two, recurring perceptions:

1. That someone dislikes TypeScript (or, ultimately, JavaScript) because they "jumped on the bandwagon"
2. "Skill issue"

I'm going to preface by saying this: I've been using TypeScript for a little over 5 years now, almost full-time. Ergo, 
it's safe to say that I have a solid amount of experience with it and have, logically, formed opinions of it. Though, 
unfortunately, what seems to be happening, is the complete denigration of people with differing opinions.

Plainly put, I do not like TypeScript for these reasons:

1. TypeScript typing is a complete fucking theatric performance &mdash; yes, at _compile_ time, you will likely catch 
   more errors. At runtime, this is all completely superfluous.
2. Types are **not** really types. They have no meta to be validly referenceable as utilities in-code, so their value 
   purely exists on the surface, if you suddenly need type-guarding.
3. Because of phantom typing, you will create a reliance on other packages to fill the gaps that usually exist in other 
   typed languages.
4. For some reason, TypeScript engineers _love_ over-complexity. Nearly every major project I've seen backed by it has 
   a layer of typing that is utterly monstrous.
5. For some reason, despite the fact that `any` is implemented and usable, nearly everyone recommends eschewing it
   entirely. Unfortunately, sometimes, these keywords do have a valid use-case; and yet this one is so widely despised.
6. TypeScript does not create a magical layer of safety, just by using it. You still have to understand how to write 
   real code, in a functional way. And yet, pure trite is still churned out by "engineers" who don't understand typical 
   software architecture.

Granted, the above is high-level. And a lot of the caveats I've mentioned are actually design decisions by the team 
building and maintaining the compiler.

However, the truth still stands, that I've spent my time with the compiler, the language, and the scene.

It wasn't for me.

I've made [attempts in learning C++](https://github.com/Vyygir/learner-quest) over time and, whilst this is the only 
project that was published to version control, I know I'm not _that_ skilled in it yet. But that hasn't stopped me 
actually enjoying principles of programming, that just don't exist in TypeScript, like method/function overloads:

```cpp
int add(int a, int b) {
    return a + b;
}

std::string add(std::string a, std::string b) {
    return a + " " + b;
}
```

Which can even be broadened further, with _real_ generics that are comparable:

```cpp
template<typename T>
T add(T a, T b) {
    if constexpr (std::is_same_v<T, int>) {
        return a + b;
    } else if constexpr (std::is_same_v<T, std::string>) {
        return a + " " + b;
    }
}
```

Granted, simple examples, but you see the point.

Unfortunately, TypeScript has _never_ scratched the proverbial itch for me that PHP, Rust, C++, and even other 
languages do.

-----

### Dreaming in client-side

I truly struggle to grasp the necessity of frameworks that want to contain _everything_ &mdash; both -sides. Next, for 
example, is a fairly popular framework built on React that touts server-side rendering. I have struggled to like the 
concept of this for two years now.

It's similar to the dislike of routing mentioned earlier; though at least I can write a fucking back-end service with 
whatever language I choose to, instead of the bottleneck of a framework-on-a-framework.

Again, I'll be honest: server-side in _JavaScript_, of all things, I just can't back. I don't understand what's wrong 
with this:

```rust
#[macro_use] extern crate rocket;

#[get("/hello/<name>/<age>")]
fn hello(name: &str, age: u8) -> String {
    format!("Hello, {} year old named {}!", age, name)
}

#[launch]
fn rocket() -> _ {
    rocket::build().mount("/", routes![hello])
}
```

Yes, I took the example straight from [the Rocket homepage](https://rocket.rs/). That's _their_ foundational example. I
really do prefer server-side to operate on an environment, a stack, and an ecosystem that I actually enjoy working with.

It seems as though we've dived into JavaScript, hard, and created a reliance on it to do _everything_, for some reason?

Even desktop applications. I'm sure most of us have heard of Electron by now and there are certainly degrees of
competency, much with any package. Discord is... fine, considering the bloat; whilst Slack, doing much less, is one of
the least performant pieces of software I've ever used. And, frankly, yes, I do blame Electron almost entirely.

-----

Everything being said, I don't hold people in disregard for preferring JavaScript or TypeScript, these days. They are 
the norm, after all. Unfortunately, though, I do hold them to a much higher set of standards.

I've explained _why_ I prefer system languages or more data-structured languages than what most people seem to enjoy. 
That's my personal preference which is entirely unlikely to change.

If there's anything I can take from this, it's that my consideration for requirements have shot up, drastically. A few 
years ago, it was simple enough to deem a project worthy of being written in React. Nowadays, with recent realisations, 
there's much more weight to that decision.

I won't dismiss client-side entirely; it has its place in the world. Similarly to WordPress, that place is just a while 
away from the place I'd like to be.
