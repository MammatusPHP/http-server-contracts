<?php declare(strict_types=1);

namespace Mammatus\Http\Server\Configuration;

interface Vhost
{
    public function port(): int;

    public function name(): string;

    public function webroot(): Webroot;

    /**
     * @return iterable<Realm>
     */
    public function webSocketRealms(): iterable;
}
