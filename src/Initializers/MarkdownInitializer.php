<?php

namespace Starless\Initializers;

use Tempest\Container\{Container, Initializer, Singleton};
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\{CommonMark\CommonMarkCoreExtension,
	CommonMark\Node\Block\FencedCode,
	FrontMatter\FrontMatterExtension,
	Strikethrough\StrikethroughExtension
};

use League\CommonMark\MarkdownConverter;
use Starless\Support\Markdown\CodeBlockRenderer;

class MarkdownInitializer implements Initializer {
	#[Singleton]
	public function initialize(Container $container): MarkdownConverter {
		$environment = new Environment()
			->addExtension(new CommonMarkCoreExtension)
			->addExtension(new StrikethroughExtension)
			->addExtension(new FrontMatterExtension)
			->addRenderer(FencedCode::class, $container->get(CodeBlockRenderer::class));

		return new MarkdownConverter($environment);
	}
}
