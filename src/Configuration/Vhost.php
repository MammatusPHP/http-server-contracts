<?php declare(strict_types=1);

namespace Mammatus\Http\Server\Configuration;

use Psr\Http\Server\MiddlewareInterface;

interface Vhost
{
    public function port(): int;

    public function name(): string;

    public function webroot(): Webroot;

    /** @return iterable<MiddlewareInterface> */
    public function middleware(): iterable;
}
