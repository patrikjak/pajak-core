<?php

declare(strict_types=1);

namespace Pajak\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class RedirectIfAuthenticatedAdmin
{
    public function __construct(private Guard $guard)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->guard->check()) {
            return new RedirectResponse(route('pajak-core.dashboard.index'));
        }

        return $next($request);
    }
}
