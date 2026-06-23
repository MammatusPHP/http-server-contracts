<?php

declare(strict_types=1);

namespace Mammatus\Http\Server\Handler;

use Psr\Http\Message\ServerRequestInterface;

/** @api */
interface Input
{
    /** @param array<string, mixed> $params */
    public static function create(ServerRequestInterface $request, array $params): self;
}
