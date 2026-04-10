---
title: "StarFighter: Per aspera ad astra"
slug: 'starfighter-per-aspera-ad-astra'
published: "2026-04-10"
excerpt: "The story and ultimate outcomes from a seven month wait for something that would change how I work and bring joy to programming again"
tags: ['hardware', 'linux', 'engineering']
---

I ordered my StarFighter from [Star Labs Systems](https://starlabs.systems) on the **19th June, 2025**.

**237 days** later, it finally arrived, on the **10th February, 2026**.

I won't lie, the entire wait plus the experience of potentially ever-shifting landmark dates was incredibly unsettling. There were periods of time where I'd tell friends and they were convinced that I was being scammed.

I knew I wasn't. An old colleague had a Star Labs machine previously, so I knew things were above board. It was just a long and frustrating waiting game with no real end in sight.

The latter half of 2025 was incredibly disappointing. Inconvenience, after stress-factor, after issue, after emergency. By the time February actually came, I wasn't holding out much hope. Until, one morning, I was sat working on a refactor on my old Ubuntu machine and I just had a feeling. I picked up my phone and glanced at it.

>A shipment from StarLabs is on the way

I'd dreamed of this moment. Literally. I really did have dreams about my StarFighter arriving. It was _always_ in the back of my mind. The next day was monumental. I unboxed it. I enjoyed staring at it. I set it aside for the evening.

Come the evening, I was at a loss on where to start. I'd already made some early decisions that I'd tested on older hardware, not nearly as capable:

1. I wanted Void Linux
2. Hyprland was my preferred compositor
3. It needed to be minimal and sensible
4. Eventually, I wanted to build most of it myself

For anyone who's already familiar with the Linux ecosystem, especially Hyprland, there are immediate and obvious problems. But we won't dive into those yet.

Before we divert from the hardware itself, let's just take a moment to enjoy it. And many thanks to the team at Star Labs for the work they've put into it, with what I can only assume would be an incredibly stressful set of events and scenarios.

![StarFighter reflecting on a gloss table in a dark space](/static/media/starfighter.jpg)

The StarFighter, visually, isn't really anything that remarkable or special. It's everything you'd expect from a coreboot laptop. But it is absolutely everything I need it to be.

Let's look at the specification of my machine in particular:

- 16" LED-backlit matte display
- 2560x1600 resolution (16:10, 184 pixels per inch)
- Intel Core Ultra 125H (Intel Arc)
- 1TB PCIe boot drive
- 32GB (DDR5) RAM

That's it. Nothing special. But that's not the point of it. The major point that Star Labs themselves focus on is that they're producing Linux-focused hardware, coreboot included. The firmware is custom - and it works.

The physical machine itself doesn't do anything ultimately special, other than boot, and that's where the real experience begins.

-----

## The unpleasant part

Before diving into anything fanciful, there are a few points that I want to address where I've had issues or think there's room for improvement.

Fortunately, there's nothing intrinsically that makes me dislike the machine and I like to get the negative points out of the way early.

### Lid hinge

This is a big thing for me with laptops. I can't use a machine if the screen is shaking violently while I'm typing. And I'm a heavy-handed typist - I used an IBM Model M for 12 months straight in the past. My current main system keyboard has 70g actuation switches.

I've not noticed any issues with that though, so I'm quite happy. **But**: could the hinge be a bit *firmer*?

It absolutely could. There's a tiny amount of wobble if you put your finger on top and move it. If the hinge were more rigid, say more like a MacBook's, then it wouldn't have taken me five attempts to get the photo above without the laptop closing mid-photo.

### Keyboard

I'm definitely an eccentric when it comes to keyboards. I like them hard to type on, both in terms of pressure and visuality. As I mentioned, I use **heavy** switches and blank caps.

The StarFighter's keyboard is... fine. That's about it.

The depth is quite nice but I do occasionally catch the edge of a key and worry I'm going to dismount it, occasionally. The keys are very firm though; almost no wobble which is actually impressive.

I do also have a slight issue with key-press debouncing. I'll press a key and it'll double up, which is definitely more noticeable in _some_ keys over others. I don't know if this is a configuration issue over anything else though and I've not looked into it yet.

### Sound

Unfortunately, the speakers on the StarFighter are quite focused on the highs and mids, with not a lot of presence. They sound okay, but it's nothing to write home about. If you're a bit of an audiophile, then I'd definitely recommend a pair of earphones.

The placement of them is very nice but the quality just isn't there. I am coming away from a pair of Edifiers on my main machine though, in the spirit of full transparency.

Similarly, I've not had much of a chance to test the microphone yet, but I did try quickly in a call today and it did not receive positive feedback. This is actually something I'd expect, in honesty, so I probably will invest in a pair of solid earphones with voice capture.

### Daily usage

It's not really a problem that's caused any issue, but the machine can run quite hot to the touch on the bottom. This is just a risk with all laptops though, as far as I'm concerned, but it's rare I'm ever actually going to be using it in my lap.

The rubber riser on the bottom of the machine is also just a touch uncomfortable and quite jarring. It sticks out further than you'd expect, clearly for clearance to dissipate heat - which makes sense. My main concern is that, one day, that's going to be the piece that inevitably gums up or peels away.

I also do occasionally hear a very mild... _click_. Or a _pop_. It happens on boot and it happens very occasionally when using the machine. I have no idea what it is and there don't seem to be any effects from it, so I'm opting to cheerfully ignore it. For now.

-----

## Movement through anxiety

Once I'd actually gotten around to focusing on how I wanted to set the StarFighter up, things couldn't have been less than clear. Typically, I can start a project with _some_ movement but this was different. It was a whole new ecosystem of tools and systems that I'd need to figure out how to use.

I knew the time-investment was likely to be heavy. And I knew that I'd set myself limitations within my own requirements, which meant I'd have to either think creatively, accept alternates, or come up with my own solutions.

Whilst, eventually, I absolutely would love to dedicate some time to writing utility software like Waybar or ashell, I just don't have the time to commit right now. Amongst work and other side-projects, along with my own mental wellbeing, that set of goals is very much on the backburner for the time being.

### A weak start

On the first run through, I got Void installed - easy. I've installed operating systems hundreds of times.

Then I moved into preferences, software, and their vast limitations:

- **Hyprland**: Wayland only
- **Void:** many packages not in the repositories and no direct support from a lot of packages
- **runit:** less common than systemd and definitely not as widely thought about by developers

A lot of this was fine. There's [a known conflict between the Void and Hyprland developers](https://www.reddit.com/r/voidlinux/comments/1eb3ivp/on_hyprland/), and not one that I care to dive into. Fortunately, there's [a very helpful package](https://github.com/Encoded14/void-extra) that I could use which includes Hyprland.

runit, specifically, caused some headache, in that most packages I'd found had native support for systemd, and no way to either configure the commands directly or required a lot of effort to maintain.

At first, I tried [ashell](https://github.com/MalpenZibo/ashell) which, unfortunately, proved to be problematic. Then I looked at [HyprPanel](https://hyprpanel.com), which had its own issues and is being re-built as [Wayle](https://github.com/wayle-rs/wayle) anyway.

It was dawning on me, more and more, that I may actually be pursuing other routes: picking up another distribution entirely, finding something with less built into it, or attempting to build my own.

Fortunately, I then accidentally mis-entered a command which deleted the entirety of my `/usr/bin` directory. It didn't break the installation, by any means. But it did give me an opportunity to do a fresh install and start again, which was simpler than manually repairing.

### Post-deletion acceleration

After setting up again and installing the necessary elements, I stumbled onto [Noctalia](https://noctalia.dev/). It was a starting point but it got me somewhere and, after a few hours of fixing commands, creating small scripts, or just re-theming, I'd finally found something that clicked.

Noctalia is, by no means, a be-all and end-all for me. There are definitely trade-offs and caveats - but, importantly, ones that I'm happy to sit with, for now.

With the desktop shell and utilities mostly out of the way, I could focus on other things. This was my first time using Hyprland, which has been far simpler to configure and use than I'd hoped - but that's the point. I'd had experience with [sway](https://swaywm.org/) but, ultimately, I wanted something that felt a bit _shinier_, which is exactly what Hyprland's marketing pushes for.

I chose [kitty](https://sw.kovidgoyal.net/kitty/) for my terminal and then set about working on everything else.

To this day, I only have _five_ actual applications installed on my machine: kitty, Firefox, Spotify, Vesktop, and OBS.

I'm sure that's going to change but, for now, it's all I need.

![The Hyprland compositor running three kitty shells with btop, helix, and fastfetch](/static/media/void-hypr-rice.png)

### Continued momentum

The beauty of an environment like this is that there are, despite my own limitations, almost no arbitrary boundaries set. I can change nearly everything down to my personal preferences, and that's what I've been doing. Sometimes, with purpose; other times, picking slowly over time.

For work, I'm regularly using [Helix](https://helix-editor.com/), which needs a good amount of configuration and patience. Using a modal editor is inherently different, coming from a JetBrains IDE background, but it's enjoyable. The learning curve is fairly steep but the pay-off feels great. I've written almost no code in anything other than Helix for over a week, and I'm still just as productive - albeit, I did start using it six months ago, but less so for full-time development.

![Helix editor whilst editing PHP](/static/media/helix-php.png)

Nearly everything I'm doing is falling back into the terminal and common workflows. I was stuck using Local to run WordPress environments on my Ubuntu machine with no real reason to want to change, given I was waiting on the StarFighter. Now that it's here, I've switched to [DDEV](https://ddev.com), moving some of our projects - which is something we've been meaning to do at work for _years_.

It's odd that a side-effect of my newly-founded limitations (and, frankly, complete avoidance of tools like Local) have caused a minor shift for the wider team as well.

The momentum really is continuous and, past configuring LSPs for a plethora of languages, I'm still finding myself modifying things every day. It may only take a minute or two but these are the important last steps, where things start to slowly click.

My eagerness for side-projects has picked up as well, to the point that I'm focusing more on learning Zig and re-focusing back on Rust, with both [Ziglings](https://github.com/ratfactor/ziglings) and [Rustlings](https://rustlings.rust-lang.org).

Occasionally, between learning sessions, I'm architecting something using [SolidStart](https://start.solidjs.com), purely just to write code that I enjoy again. This, plus another side-project that I want to keep to myself for a while until it comes closer to fruition.

Right now, I'm still not technically done with tinkering and modifying. Things are very consistent and I'm changing less and less. But I don't think I'm going to bother publishing the configurations and documenting everything until it's all mostly stable. And that's the beauty of these kinds of configurations - you _can_ share them and other people can just use them.

-----

## Back to hardware

In summary, the root entry point for all of this was having a laptop that I was confident enough with and wouldn't cause issues. Whilst I don't _mind_ hacking around some things, I don't necessarily want to all of the time. I just wanted something that would work, cleanly, and mostly out-of-the-box with pretty much any Linux distribution.

For my uses, Star Labs have done exactly that, at a reasonable cost. Unfortunately, the price has gone up somewhat since I bought mine due to the current hardware markets being consumed, but that's unavoidable right now.

Should _everyone_ buy a StarFighter? Probably not. There are alternatives, like the [StarBook Horizon](https://starlabs.systems/pages/starbook-horizon) but it's all dependent on your requirements. For me, a Linux-oriented laptop that boots was enough.

If you're interested in Linux or something that isn't Windows or OS X, go ahead and install VirtualBox, or wipe an old laptop and try a distribution out on there. I couldn't recommend it enough and the number of choices is exceptional these days.

_Side-note: Star Labs, I won't complain if a StarBook happens to fall into a box and turn up at my house._
