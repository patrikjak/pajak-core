<?php

declare(strict_types=1);

namespace Pajak\Core\Modules;

use Illuminate\Contracts\Auth\Access\Gate;
use Pajak\Core\Authorization\PermissionRegistry;
use Pajak\Core\Dashboard\DashboardWidgetRegistry;
use Pajak\Core\Navigation\NavigationRegistry;
use Pajak\Core\Settings\SettingsRegistry;

final readonly class ModuleBooter
{
    public function __construct(
        private ModuleRegistry $moduleRegistry,
        private Gate $gate,
        private PermissionRegistry $permissionRegistry,
        private NavigationRegistry $navigationRegistry,
        private DashboardWidgetRegistry $dashboardWidgetRegistry,
        private SettingsRegistry $settingsRegistry,
        private RouteRegistrar $routeRegistrar,
    ) {
    }

    public function boot(bool $routesAreCached): void
    {
        $this->routeRegistrar->registerMiddlewareGroups();

        foreach ($this->moduleRegistry->all() as $module) {
            $this->registerPolicies($module);

            $this->permissionRegistry->addMany($module->permissions());
            $this->navigationRegistry->addMany($module->navigation());
            $this->dashboardWidgetRegistry->addMany($module->dashboardWidgets());
            $this->settingsRegistry->addMany($module->settings());

            if (!$routesAreCached) {
                $this->routeRegistrar->register($module);
            }
        }
    }

    private function registerPolicies(Module $module): void
    {
        foreach ($module->policies() as $modelClass => $policyClass) {
            $this->gate->policy($modelClass, $policyClass);
        }
    }
}
