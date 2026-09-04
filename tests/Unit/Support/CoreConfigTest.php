<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Illuminate\Config\Repository;
use Pajak\Core\Modules\Dashboard\DashboardModule;
use Pajak\Core\Support\CoreConfig;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CoreConfigTest extends TestCase
{
    #[Test]
    public function exposesTypedAccessors(): void
    {
        $coreConfig = new CoreConfig(new Repository([
            'pajak-core' => [
                'app_name' => 'Acme',
                'modules' => [DashboardModule::class],
                'route' => ['prefix' => '/panel/', 'domain' => null],
                'middleware' => ['auth' => ['a', 'b']],
                'locales' => ['en', 'sk'],
                'authorization' => ['superadmin_role' => 'root'],
                'auth' => ['invitations' => ['expires_days' => 14]],
            ],
        ]));

        self::assertSame('Acme', $coreConfig->appName());
        self::assertSame([DashboardModule::class], $coreConfig->modules());
        self::assertSame('panel', $coreConfig->routePrefix());
        self::assertNull($coreConfig->routeDomain());
        self::assertSame(['a', 'b'], $coreConfig->middleware('auth'));
        self::assertSame(['en', 'sk'], $coreConfig->locales());
        self::assertSame('root', $coreConfig->superadminRoleSlug());
        self::assertSame(14, $coreConfig->invitationExpiresDays());
    }

    #[Test]
    public function fallsBackToDefaults(): void
    {
        $coreConfig = new CoreConfig(new Repository(['pajak-core' => []]));

        self::assertSame('App', $coreConfig->appName());
        self::assertSame('admin', $coreConfig->routePrefix());
        self::assertSame([], $coreConfig->modules());
        self::assertSame(['en'], $coreConfig->locales());
    }
}
