<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Navigation;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Routing\UrlGenerator;
use Pajak\Core\Navigation\Dto\NavigationGroup;
use Pajak\Core\Navigation\Dto\NavigationItem;
use Pajak\Core\Navigation\NavigationRegistry;
use Pajak\Core\Navigation\NavigationResolver;
use Pajak\Core\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class NavigationResolverTest extends TestCase
{
    #[Test]
    public function filtersItemsByPermissionAndOrdersThem(): void
    {
        $this->fakeGate(['reports.view']);

        $registry = $this->freshNavigation();
        $registry->group(new NavigationGroup('main', order: 10));
        $registry->add(new NavigationItem(
            'reports',
            'Reports',
            'reports.index',
            'main',
            permission: 'reports.view',
            order: 20,
        ));
        $registry->add(new NavigationItem(
            'billing',
            'Billing',
            'billing.index',
            'main',
            permission: 'billing.view',
            order: 10,
        ));
        $registry->add(new NavigationItem('home', 'Home', 'home', 'main', order: 5));

        $groups = $this->app->make(NavigationResolver::class)->resolve()->groups();

        self::assertCount(1, $groups);
        self::assertSame(
            ['home', 'reports'],
            array_map(static fn (object $item): string => $item->key, $groups[0]->items),
        );
    }

    #[Test]
    public function dropsEmptyGroups(): void
    {
        $this->fakeGate([]);

        $registry = $this->freshNavigation();
        $registry->group(new NavigationGroup('main', order: 10));
        $registry->group(new NavigationGroup('system', 'System', 100));
        $registry->add(new NavigationItem('home', 'Home', 'home', 'main'));
        $registry->add(new NavigationItem('secret', 'Secret', 'secret.index', 'system', permission: 'secret.view'));

        $resolved = $this->app->make(NavigationResolver::class)->resolve();

        self::assertCount(1, $resolved->groups());
        self::assertSame('main', $resolved->groups()[0]->key);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeUrls();
    }

    private function fakeUrls(): void
    {
        $urlGenerator = $this->createStub(UrlGenerator::class);
        $urlGenerator->method('route')->willReturnCallback(
            static fn (string $name): string => sprintf('/%s', $name),
        );

        $this->app->instance(UrlGenerator::class, $urlGenerator);
    }

    private function freshNavigation(): NavigationRegistry
    {
        $registry = new NavigationRegistry();
        $this->app->instance(NavigationRegistry::class, $registry);

        return $registry;
    }

    /**
     * @param array<int, string> $allowed
     */
    private function fakeGate(array $allowed): void
    {
        $gate = $this->createStub(Gate::class);
        $gate->method('allows')->willReturnCallback(
            static fn (string $ability): bool => in_array($ability, $allowed, true),
        );

        $this->app->instance(Gate::class, $gate);
    }
}
