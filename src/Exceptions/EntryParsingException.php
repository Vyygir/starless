<?php

namespace Starless\Exceptions;

use Exception;
use Tempest\Discovery\SkipDiscovery;

#[SkipDiscovery]
class EntryParsingException extends Exception {}
