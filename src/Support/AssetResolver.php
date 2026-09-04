<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\HtmlString;

final readonly class AssetResolver
{
    // Per package: built asset basename + the vite dev-server JS entry (which imports its own CSS).
    private const array PACKAGES = [
        'ui' => ['built' => 'main', 'dev_js' => 'resources/assets/js/main.ts'],
        'core' => ['built' => 'core', 'dev_js' => 'resources/assets/js/core.ts'],
    ];

    public function __construct(private Application $application, private UrlGenerator $urlGenerator)
    {
    }

    public function tags(): HtmlString
    {
        $devServers = [
            'ui' => $this->devServer('ui'),
            'core' => $this->devServer('core'),
        ];

        $clientOrigin = $devServers['ui'] ?? $devServers['core'];
        $tags = $clientOrigin === null ? [] : [$this->module(sprintf('%s/@vite/client', $clientOrigin))];

        foreach (self::PACKAGES as $package => $entries) {
            $tags = [...$tags, ...$this->packageTags($package, $entries, $devServers[$package])];
        }

        return new HtmlString(implode("\n    ", $tags));
    }

    public function uiEmailCss(): string
    {
        $path = $this->application->basePath('vendor/pajak/ui/resources/assets/css/email/email-standalone.css');

        $contents = is_file($path) ? file_get_contents($path) : false;

        return $contents === false ? '' : $contents;
    }

    /**
     * @param array{built: string, dev_js: string} $entries
     *
     * @return array<int, string>
     */
    private function packageTags(string $package, array $entries, ?string $devServer): array
    {
        if ($devServer !== null) {
            return [$this->module(sprintf('%s/%s', $devServer, $entries['dev_js']))];
        }

        return [
            $this->stylesheet(
                $this->urlGenerator->asset(sprintf('vendor/pajak/%s/assets/%s.css', $package, $entries['built'])),
            ),
            $this->module(
                $this->urlGenerator->asset(sprintf('vendor/pajak/%s/assets/%s.js', $package, $entries['built'])),
            ),
        ];
    }

    private function devServer(string $package): ?string
    {
        $hotFile = $this->application->basePath(sprintf('vendor/pajak/%s/public/hot', $package));

        $contents = is_file($hotFile) ? file_get_contents($hotFile) : false;

        if ($contents === false) {
            return null;
        }

        $origin = trim($contents);

        return $origin === '' ? null : rtrim($origin, '/');
    }

    private function stylesheet(string $href): string
    {
        return sprintf('<link rel="stylesheet" href="%s">', $href);
    }

    private function module(string $source): string
    {
        return sprintf('<script type="module" src="%s"></script>', $source);
    }
}
