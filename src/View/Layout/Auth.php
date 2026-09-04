<?php

declare(strict_types=1);

namespace Pajak\Core\View\Layout;

use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Pajak\Core\Support\AssetResolver;
use Pajak\Core\Support\CoreConfig;

final class Auth extends Component
{
    public function __construct(
        private readonly AssetResolver $assetResolver,
        private readonly CoreConfig $coreConfig,
        public string $title = '',
    ) {
    }

    public function assetTags(): HtmlString
    {
        return $this->assetResolver->tags();
    }

    public function appName(): string
    {
        return $this->coreConfig->appName();
    }

    public function fontUrl(): ?string
    {
        return $this->coreConfig->brandingFontUrl();
    }

    public function render(): View
    {
        return view('pajak-core::components.layout.auth');
    }
}
