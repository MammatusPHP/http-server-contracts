<?php declare(strict_types=1);

namespace Mammatus\Http\Server\Configuration;

interface Realm
{
    public function name(): string;
}
