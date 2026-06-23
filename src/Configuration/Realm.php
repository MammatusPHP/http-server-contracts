<?php

declare(strict_types=1);

namespace Mammatus\Http\Server\Configuration;

/** @api */
interface Realm
{
    public function name(): string;
}
