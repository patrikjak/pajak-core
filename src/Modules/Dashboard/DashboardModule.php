<?php

declare(strict_types=1);

namespace Pajak\Core\Modules\Dashboard;

use Pajak\Core\Modules\Module;
use Pajak\Core\Modules\ModuleRoutes;
use Pajak\Core\Navigation\Dto\NavigationItem;

final class DashboardModule extends Module
{
    public function key(): string
    {
        return 'dashboard';
    }

    public function routes(): ModuleRoutes
    {
        return ModuleRoutes::make(__DIR__ . '/routes/web.php');
    }

    /**
     * @return array<int, NavigationItem>
     */
    public function navigation(): array
    {
        return [
            new NavigationItem(
                key: 'dashboard',
                label: 'pajak-core::navigation.dashboard',
                route: 'pajak-core.dashboard.index',
                group: 'main',
                icon: 'heroicon-o-home',
                order: 10,
            ),
        ];
    }
}
