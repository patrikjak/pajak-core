<?php

declare(strict_types=1);

namespace Pajak\Core\View;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Pajak\Ui\Common\Dto\BreadcrumbItem;

final class PageHeader extends Component
{
    /**
     * @param array<int, BreadcrumbItem> $breadcrumbs
     */
    public function __construct(
        public string $title = '',
        public ?string $description = null,
        public array $breadcrumbs = [],
    ) {
    }

    public function render(): View
    {
        return view('pajak-core::components.page-header');
    }
}
