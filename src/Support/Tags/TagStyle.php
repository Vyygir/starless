<?php

namespace Starless\Support\Tags;

enum TagStyle: string {
	case Red = 'red';
	case Orange = 'orange';
	case Amber = 'amber';
	case Yellow = 'yellow';
	case Lime = 'lime';
	case Green = 'green';
	case Emerald = 'emerald';
	case Teal = 'teal';
	case Cyan = 'cyan';
	case Sky = 'sky';
	case Blue = 'blue';
	case Indigo = 'indigo';
	case Violet = 'violet';
	case Purple = 'purple';
	case Pink = 'pink';
	case Rose = 'rose';
	case Neutral = 'neutral';

	public function getClass(): string {
		return match ($this) {
			self::Red => 'bg-red-950 text-white/50',
			self::Orange => 'bg-orange-950 text-white/50',
			self::Amber => 'bg-amber-950 text-white/50',
			self::Yellow => 'bg-yellow-950 text-white/50',
			self::Lime => 'bg-lime-950 text-lime-200/70',
			self::Green => 'bg-green-950 text-white/50',
			self::Emerald => 'bg-emerald-950 text-white/50',
			self::Teal => 'bg-teal-950 text-white/50',
			self::Cyan => 'bg-cyan-950 text-cyan-200/70',
			self::Sky => 'bg-sky-950 text-sky-200/70',
			self::Blue => 'bg-blue-950 text-white/50',
			self::Indigo => 'bg-indigo-950 text-white/50',
			self::Violet => 'bg-violet-950 text-white/50',
			self::Purple => 'bg-purple-950 text-white/50',
			self::Pink => 'bg-pink-950 text-pink-300/80',
			self::Rose => 'bg-rose-950 text-white/50',
			self::Neutral => 'bg-neutral-900 text-neutral-400',
		};
	}
}
