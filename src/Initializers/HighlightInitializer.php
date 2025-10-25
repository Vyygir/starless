<?php

namespace Starless\Initializers;

use Tempest\Container\Container;
use Tempest\Container\Initializer;
use Tempest\Container\Singleton;
use Tempest\Highlight\Highlighter;

final readonly class HighlightInitializer implements Initializer
{
	#[Singleton]
	public function initialize(Container $container): Highlighter {
		return new Highlighter();
	}
}
