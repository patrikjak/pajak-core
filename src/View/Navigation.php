<?php

declare(strict_types=1);

namespace Pajak\Core\View;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Pajak\Core\Navigation\Dto\ResolvedNavigation;
use Pajak\Core\Navigation\NavigationResolver;

final class Navigation extends Component
{
    public function __construct(private readonly NavigationResolver $navigationResolver)
    {
    }

    public function navigation(): ResolvedNavigation
    {
        return $this->navigationResolver->resolve();
    }

    public function render(): View
    {
        return view('pajak-core::components.navigation');
    }
}
