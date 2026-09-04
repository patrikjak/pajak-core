<?php

declare(strict_types=1);

namespace Pajak\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Pajak\Core\Support\Features;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class EnsureFeatureEnabled
{
    public function __construct(private Features $features)
    {
    }

    public function handle(Request $request, Closure $next, string $feature): Response
    {
        if ($this->features->disabled($feature)) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
