<?php

declare(strict_types=1);

namespace Pajak\Core\View;

use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class FlashToasts extends Component
{
    public function __construct(private readonly Session $session)
    {
    }

    /**
     * @return array<string, mixed>|null
     */
    public function toast(): ?array
    {
        $toast = $this->session->get('toast');

        return is_array($toast) ? $toast : null;
    }

    public function render(): View
    {
        return view('pajak-core::components.flash-toasts');
    }
}
