<?php

declare(strict_types=1);

namespace Pajak\Core\Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\View\View;
use Pajak\Core\Http\Controllers\Controller;

final class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('pajak-core::dashboard.index');
    }
}
