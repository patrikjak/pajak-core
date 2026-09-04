<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Modules;

use Illuminate\Routing\Router;
use Pajak\Core\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class RouteRegistrarTest extends TestCase
{
    #[Test]
    public function registersModuleWebRoutesUnderThePrefixAndNamePrefix(): void
    {
        $route = $this->app->make(Router::class)->getRoutes()->getByName('pajak-core.dashboard.index');

        self::assertNotNull($route);
        self::assertSame('admin', $route->uri());
        self::assertContains('pajak-core.web', $route->gatherMiddleware());
    }

    #[Test]
    public function registersTheFourMiddlewareGroups(): void
    {
        $groups = $this->app->make(Router::class)->getMiddlewareGroups();

        self::assertArrayHasKey('pajak-core.web', $groups);
        self::assertArrayHasKey('pajak-core.auth', $groups);
        self::assertArrayHasKey('pajak-core.guest', $groups);
        self::assertArrayHasKey('pajak-core.api', $groups);
    }
}
