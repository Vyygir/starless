<?php

use Starless\Config\StarlessConfig;

const TOPIC_COLOUR = 'cyan';
const LANGUAGE_COLOUR = 'lime';
const FRAMEWORK_COLOUR = 'sky';

return new StarlessConfig(
	entriesPerPage: 5,
	availableTags: [
		[
			'name' => 'Starless',
			'colour' => 'neutral',
			'preserveCase' => true,
		],
		// Topic
		[
			'name' => 'Personal',
			'colour' => TOPIC_COLOUR,
		],
		[
			'name' => 'Engineering',
			'colour' => TOPIC_COLOUR,
		],
		// Modifier
		[
			'name' => 'Emotional',
			'colour' => 'pink',
		],
		[
			'name' => 'Fury',
			'colour' => 'red',
		],
		// Language
		[
			'name' => 'PHP',
			'colour' => LANGUAGE_COLOUR,
			'preserveCase' => true,
		],
		// Framework
		[
			'name' => 'Tempest',
			'colour' => FRAMEWORK_COLOUR,
			'preserveCase' => true,
		],
	],
);
