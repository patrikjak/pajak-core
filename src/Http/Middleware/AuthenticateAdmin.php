<?php

declare(strict_types=1);

namespace Pajak\Core\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

final class AuthenticateAdmin extends Authenticate
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route('pajak-core.auth.login');
    }
}
