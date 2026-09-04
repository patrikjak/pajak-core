<?php

declare(strict_types=1);

namespace Pajak\Core\Dashboard\Contracts;

use Illuminate\Contracts\View\View;

interface DashboardWidget
{
    public function key(): string;

    public function order(): int;

    public function permission(): ?string;

    public function render(): View;
}
