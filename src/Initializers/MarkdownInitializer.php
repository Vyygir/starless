<?php

namespace Starless\Initializers;

use Tempest\Container\{Container, Initializer, Singleton};
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\MarkdownConverter;
use Starless\Support\Markdown\{CodeBlockRenderer, ImageRenderer};

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
