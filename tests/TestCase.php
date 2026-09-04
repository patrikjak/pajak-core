<?php

declare(strict_types=1);

namespace Pajak\Core\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Pajak\Core\CoreServiceProvider;
use Pajak\Ui\UiServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            UiServiceProvider::class,
            CoreServiceProvider::class,
        ];
    }
}
