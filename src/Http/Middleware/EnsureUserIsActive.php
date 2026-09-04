<?php

declare(strict_types=1);

namespace Pajak\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Pajak\Core\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final readonly class EnsureUserIsActive
{
    public function __construct(private StatefulGuard $guard)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->guard->user();

        if ($user instanceof User && $user->isDisabled()) {
            $this->guard->logout();

            throw new AccessDeniedHttpException('Your account has been disabled.');
        }

        return $next($request);
    }
}
