<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Feature;

use Illuminate\Contracts\Config\Repository;
use Pajak\Core\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class CoreServiceProviderTest extends TestCase
{
    #[Test]
    public function mergesThePackageConfiguration(): void
    {
        $config = $this->app->make(Repository::class);

        self::assertTrue($config->has('pajak-core'));
        self::assertIsArray($config->get('pajak-core.modules'));
        self::assertIsArray($config->get('pajak-core.features'));
    }
}
