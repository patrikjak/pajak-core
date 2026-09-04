<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Pajak\Core\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function rendersTheAdminShellAtTheConfiguredPrefix(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('pajak-sb', false);
        $response->assertSee('Dashboard');
        $response->assertSee('pajak-core-content', false);
    }

    #[Test]
    public function marksTheDashboardNavigationItemAsActive(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertSee('aria-current="page"', false);
    }

    #[Test]
    public function loadsBuiltAssetTagsWhenNoDevServerIsRunning(): void
    {
        $response = $this->get('/admin');

        $response->assertSee('vendor/pajak/core/assets/core.css', false);
        $response->assertSee('vendor/pajak/ui/assets/main.js', false);
    }
}
