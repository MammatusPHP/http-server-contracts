# Contracts for the HTTP server

![Continuous Integration](https://github.com/mammatusphp/http-server-contracts/workflows/Continuous%20Integration/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/mammatus/http-server-contracts/v/stable.png)](https://packagist.org/packages/mammatus/http-server-contracts)
[![Total Downloads](https://poser.pugx.org/mammatus/http-server-contracts/downloads.png)](https://packagist.org/packages/mammatus/http-server-contracts/stats)
[![Type Coverage](https://shepherd.dev/github/mammatusphp/http-server-contracts/coverage.svg)](https://shepherd.dev/github/mammatusphp/http-server-contracts)
[![License](https://poser.pugx.org/mammatus/http-server-contracts/license.png)](https://packagist.org/packages/mammatus/http-server-contracts)

PHP interfaces for virtual hosts, static webroots, handler input DTOs, and realm names. [mammatus/http-server](https://github.com/MammatusPHP/http-server) discovers classes that implement these contracts when Composer autoload is dumped and generates ReactPHP server lifecycle code. Route and probe metadata live in [mammatus/http-server-attributes](https://github.com/MammatusPHP/http-server-attributes).

# Install

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require mammatus/http-server-contracts
```

# Contracts

This package provides the following interfaces:

## Vhost

Implemented by a class that defines one listening HTTP server (port, name, webroot, concurrency limit, and per-vhost middleware). The server plugin collects every `Vhost` implementation in the dependency tree and emits a `LifeCycleHandler` per vhost.

```php
use Mammatus\Http\Server\Configuration\Vhost;
use Mammatus\Http\Server\Configuration\Webroot;
use Mammatus\Http\Server\Webroot\NoWebroot;
use Psr\Http\Server\MiddlewareInterface;

final class FrontendVhost implements Vhost
{
    public static function port(): int
    {
        return 1337;
    }

    public static function name(): string
    {
        return 'frontend';
    }

    public static function webroot(): Webroot
    {
        return new NoWebroot();
    }

    public static function maxConcurrentRequests(): int|null
    {
        return null;
    }

    /** @return iterable<MiddlewareInterface> */
    public function middleware(): iterable
    {
        yield from [];
    }
}
```

Examples: [FrontendVhost](https://github.com/MammatusPHP/http-server/blob/main/etc/dev-app/FrontendVhost.php), [HealthCheckVhost](https://github.com/MammatusPHP/healthz-vhost/blob/main/src/HealthCheckVhost.php).

## Webroot

Marker interface for static file serving on a vhost. [mammatus/http-server-webroot](https://github.com/MammatusPHP/http-server-webroot) ships `NoWebroot` (no static files) and `WebrootPath` (filesystem directory). The plugin passes a directory path to generated servers only when `webroot()` returns a `WebrootPath`.

```php
use Mammatus\Http\Server\Configuration\Webroot;
use Mammatus\Http\Server\Webroot\WebrootPath;

public static function webroot(): WebrootPath
{
    return new WebrootPath(__DIR__ . '/public');
}
```

## Input

Implemented by readonly (or immutable) DTO classes that are the single parameter to an HTTP handler method. Generated routing code calls `Input::create()` with the PSR-7 request and FastRoute path parameters before invoking the handler.

```php
use Mammatus\Http\Server\Handler\Input;
use Psr\Http\Message\ServerRequestInterface;

final readonly class Ping implements Input
{
    public function __construct(public string $name)
    {
    }

    /** @param array{name: string} $params */
    public static function create(ServerRequestInterface $request, array $params): self
    {
        return new self($params['name']);
    }
}
```

Used with a handler such as [PingHandler](https://github.com/MammatusPHP/http-server/blob/main/etc/dev-app/PingHandler.php) and [Ping](https://github.com/MammatusPHP/http-server/blob/main/etc/dev-app/Ping.php). See generated wiring in [Frontend](https://github.com/MammatusPHP/http-server/blob/main/src/Server/Frontend.php).

## Realm

Contract for a named realm string (for example HTTP or WebSocket authentication). Implement `name()` to return the realm identifier.

```php
use Mammatus\Http\Server\Configuration\Realm;

final readonly class ApiRealm implements Realm
{
    public function name(): string
    {
        return 'api';
    }
}
```

# License

The MIT License (MIT)

Copyright (c) 2026 Cees-Jan Kiewiet

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
