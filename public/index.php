<?php

declare(strict_types=1);

use Tempest\Router\HttpApplication;
use Tempest\Discovery\DiscoveryLocation;

require_once __DIR__ . '/../vendor/autoload.php';

HttpApplication::boot(
	root: __DIR__ . '/../',
	discoveryLocations: [
		new DiscoveryLocation(
			namespace: '',
			path: __DIR__ . '/../assets/'
		),
		new DiscoveryLocation(
			namespace: '',
			path: __DIR__ . '/../views/'
		),
	]
)->run();

exit();
