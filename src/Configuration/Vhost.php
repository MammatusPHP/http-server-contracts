<?php

declare(strict_types=1);

namespace Mammatus\Http\Server\Configuration;

use Psr\Http\Server\MiddlewareInterface;

interface Vhost
{
    public static function port(): int;

    public static function name(): string;

    public static function webroot(): Webroot;

    public static function maxConcurrentRequests(): int|null;

    /** @return iterable<MiddlewareInterface> */
    public function middleware(): iterable;
}
