<?php

declare(strict_types=1);

namespace Pajak\Core;

use Illuminate\Support\ServiceProvider;

final class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pajak-core.php', 'pajak-core');
    }

    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/pajak-core.php' => config_path('pajak-core.php'),
            ],
            'pajak-core-config',
        );

        $this->publishes(
            [
                __DIR__ . '/../public' => public_path('vendor/pajak/core'),
            ],
            'pajak-core-assets',
        );
    }
}
