<?php

declare(strict_types=1);

namespace Pajak\Core\Modules;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Pajak\Core\Authorization\Dto\PermissionDefinition;
use Pajak\Core\Dashboard\Contracts\DashboardWidget;
use Pajak\Core\Navigation\Dto\NavigationItem;
use Pajak\Core\Settings\Dto\SettingDefinition;

abstract class Module
{
    abstract public function key(): string;

    public function routeNamePrefix(): string
    {
        return 'pajak-core.';
    }

    public function register(Container $container): void
    {
        // Overridden by modules that need to bind their own services into the container.
    }

    public function routes(): ?ModuleRoutes
    {
        return null;
    }

    /**
     * @return array<int, PermissionDefinition>
     */
    public function permissions(): array
    {
        return [];
    }

    /**
     * @return array<int, NavigationItem>
     */
    public function navigation(): array
    {
        return [];
    }

    /**
     * @return array<class-string<Model>, class-string>
     */
    public function policies(): array
    {
        return [];
    }

    public function migrationsPath(): ?string
    {
        return null;
    }

    /**
     * @return array<int, class-string<DashboardWidget>>
     */
    public function dashboardWidgets(): array
    {
        return [];
    }

    /**
     * @return array<int, SettingDefinition>
     */
    public function settings(): array
    {
        return [];
    }

    /**
     * @return array<int, class-string<Command>>
     */
    public function commands(): array
    {
        return [];
    }
}
