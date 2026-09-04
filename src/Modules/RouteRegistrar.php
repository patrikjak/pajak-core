<?php

declare(strict_types=1);

namespace Pajak\Core\Modules;

use Illuminate\Routing\Router;
use Pajak\Core\Support\CoreConfig;

final readonly class RouteRegistrar
{
    private const array MIDDLEWARE_GROUPS = ['web', 'auth', 'guest', 'api'];

    public function __construct(private Router $router, private CoreConfig $coreConfig)
    {
    }

    public function registerMiddlewareGroups(): void
    {
        foreach (self::MIDDLEWARE_GROUPS as $group) {
            $this->router->middlewareGroup(
                sprintf('pajak-core.%s', $group),
                $this->coreConfig->middleware($group),
            );
        }
    }

    public function register(Module $module): void
    {
        $routes = $module->routes();

        if ($routes === null) {
            return;
        }

        $prefix = $this->coreConfig->routePrefix();
        $domain = $this->coreConfig->routeDomain();

        if ($routes->web !== null) {
            $this->router->group(
                $this->attributes($prefix, $domain, ['pajak-core.web'], $module->routeNamePrefix()),
                $routes->web,
            );
        }

        if ($routes->api !== null) {
            $this->router->group(
                $this->attributes(
                    sprintf('%s/api', $prefix),
                    $domain,
                    ['pajak-core.web', 'pajak-core.api'],
                    sprintf('%sapi.', $module->routeNamePrefix()),
                ),
                $routes->api,
            );
        }
    }

    /**
     * @param array<int, string> $middleware
     *
     * @return array<string, mixed>
     */
    private function attributes(string $prefix, ?string $domain, array $middleware, string $as): array
    {
        $attributes = [
            'prefix' => $prefix,
            'as' => $as,
            'middleware' => $middleware,
        ];

        if ($domain !== null) {
            $attributes['domain'] = $domain;
        }

        return $attributes;
    }
}
