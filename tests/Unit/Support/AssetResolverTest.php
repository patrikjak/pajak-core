<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Pajak\Core\Support\AssetResolver;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AssetResolverTest extends TestCase
{
    private string $basePath;

    #[Test]
    public function emitsBuiltAssetTagsWhenNoDevServerIsRunning(): void
    {
        $tags = $this->resolver()->tags()->toHtml();

        self::assertStringContainsString('vendor/pajak/ui/assets/main.css', $tags);
        self::assertStringContainsString('vendor/pajak/core/assets/core.js', $tags);
        self::assertStringNotContainsString('@vite/client', $tags);
    }

    #[Test]
    public function emitsDevServerTagsWhenCoreHotFileExists(): void
    {
        file_put_contents(
            $this->basePath . '/vendor/pajak/core/public/hot',
            "https://vite.core.pajak.local\n",
        );

        $tags = $this->resolver()->tags()->toHtml();

        self::assertStringContainsString('https://vite.core.pajak.local/@vite/client', $tags);
        self::assertStringContainsString('https://vite.core.pajak.local/resources/assets/js/core.ts', $tags);
        self::assertStringContainsString('vendor/pajak/ui/assets/main.js', $tags);
        self::assertStringNotContainsString('vendor/pajak/core/assets/core.js', $tags);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->basePath = sys_get_temp_dir() . '/pajak-core-assets-' . uniqid('', true);
        mkdir($this->basePath . '/vendor/pajak/core/public', 0777, true);
        mkdir($this->basePath . '/vendor/pajak/ui/public', 0777, true);
    }

    protected function tearDown(): void
    {
        exec(sprintf('rm -rf %s', escapeshellarg($this->basePath)));

        parent::tearDown();
    }

    private function resolver(): AssetResolver
    {
        $application = $this->createStub(Application::class);
        $application->method('basePath')->willReturnCallback(
            fn (string $path = ''): string => rtrim($this->basePath . '/' . $path, '/'),
        );

        $urlGenerator = $this->createStub(UrlGenerator::class);
        $urlGenerator->method('asset')->willReturnCallback(
            static fn (string $path): string => sprintf('https://app.test/%s', $path),
        );

        return new AssetResolver($application, $urlGenerator);
    }
}
