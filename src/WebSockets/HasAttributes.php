<?php

declare(strict_types=1);

namespace Mammatus\Http\Server\WebSockets;

use JsonSerializable;

interface HasAttributes
{
    public function has(string $attribute): bool;

    /**
     * @throws \RuntimeException On attempting get a non-existing attribute
     *
     * @return mixed
     */
    public function get(string $attribute);
}
