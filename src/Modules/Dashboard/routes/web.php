<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Pajak\Core\Modules\Dashboard\Http\Controllers\DashboardController;

Route::get('/', DashboardController::class)->name('dashboard.index');
