<?php

declare(strict_types=1);

namespace Pajak\Core;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pajak\Core\Authorization\PermissionRegistry;
use Pajak\Core\Dashboard\DashboardWidgetRegistry;
use Pajak\Core\Http\Middleware\EnsureFeatureEnabled;
use Pajak\Core\Modules\Module;
use Pajak\Core\Modules\ModuleBooter;
use Pajak\Core\Modules\ModuleRegistry;
use Pajak\Core\Modules\RouteRegistrar;
use Pajak\Core\Navigation\Dto\NavigationGroup;
use Pajak\Core\Navigation\NavigationRegistry;
use Pajak\Core\Settings\SettingsRegistry;
use Pajak\Core\Support\CoreConfig;
use Pajak\Core\Support\Features;
use Pajak\Core\Support\Models;

final class CoreServiceProvider extends ServiceProvider
{
    private const array SINGLETONS = [
        CoreConfig::class,
        Features::class,
        Models::class,
        PermissionRegistry::class,
        NavigationRegistry::class,
        DashboardWidgetRegistry::class,
        SettingsRegistry::class,
    ];

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pajak-core.php', 'pajak-core');

        foreach (self::SINGLETONS as $abstract) {
            $this->app->singleton($abstract);
        }

        $this->app->singleton(ModuleRegistry::class, fn (): ModuleRegistry => new ModuleRegistry($this->modules()));

        foreach ($this->app->make(ModuleRegistry::class)->all() as $module) {
            $module->register($this->app);
        }
    }

    public function boot(Router $router): void
    {
        $router->aliasMiddleware('feature', EnsureFeatureEnabled::class);

        Blade::componentNamespace('Pajak\\Core\\View', 'pajak-core');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pajak-core');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'pajak-core');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->registerNavigationGroups();
        $this->registerMorphMap();
        $this->registerFeatureDirective();
        $this->bootModules();
        $this->registerPublishing();
    }

    /**
     * @return array<int, Module>
     */
    private function modules(): array
    {
        return array_map(
            fn (string $moduleClass): Module => $this->app->make($moduleClass),
            $this->app->make(CoreConfig::class)->modules(),
        );
    }

    private function registerNavigationGroups(): void
    {
        $navigation = $this->app->make(NavigationRegistry::class);

        $navigation->group(new NavigationGroup('main', order: 10));
        $navigation->group(new NavigationGroup('system', 'pajak-core::navigation.groups.system', 100));
    }

    private function registerMorphMap(): void
    {
        Relation::morphMap($this->app->make(Models::class)->map());
    }

    private function registerFeatureDirective(): void
    {
        $features = $this->app->make(Features::class);

        Blade::if('feature', static fn (string $key): bool => $features->enabled($key));
    }

    /**
     * @throws BindingResolutionException
     */
    private function bootModules(): void
    {
        $moduleRegistry = $this->app->make(ModuleRegistry::class);

        new ModuleBooter(
            $moduleRegistry,
            $this->app->make(Gate::class),
            $this->app->make(PermissionRegistry::class),
            $this->app->make(NavigationRegistry::class),
            $this->app->make(DashboardWidgetRegistry::class),
            $this->app->make(SettingsRegistry::class),
            new RouteRegistrar($this->app->make(Router::class), $this->app->make(CoreConfig::class)),
        )->boot($this->app->routesAreCached());

        foreach ($moduleRegistry->all() as $module) {
            if ($module->migrationsPath() !== null) {
                $this->loadMigrationsFrom($module->migrationsPath());
            }

            if ($module->commands() !== []) {
                $this->commands($module->commands());
            }
        }
    }

    private function registerPublishing(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes(
            [__DIR__ . '/../config/pajak-core.php' => config_path('pajak-core.php')],
            'pajak-core-config',
        );
        $this->publishes(
            [__DIR__ . '/../public' => public_path('vendor/pajak/core')],
            'pajak-core-assets',
        );
        $this->publishes(
            [__DIR__ . '/../resources/assets' => resource_path('assets/vendor/pajak/core')],
            'pajak-core-sources',
        );
        $this->publishes(
            [__DIR__ . '/../resources/views' => resource_path('views/vendor/pajak-core')],
            'pajak-core-views',
        );
        $this->publishes(
            [__DIR__ . '/../lang' => lang_path('vendor/pajak-core')],
            'pajak-core-translations',
        );
        $this->publishes(
            [__DIR__ . '/../database/migrations' => database_path('migrations')],
            'pajak-core-migrations',
        );
    }
}
