<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

final readonly class NavigationChild
{
    /**
     * @param array<int, string> $activeRoutes
     * @param array<string, string> $routeParameters
     */
    public function __construct(
        public string $key,
        public string $label,
        public string $route,
        public ?string $permission = null,
        public array $activeRoutes = [],
        public int $order = 100,
        public array $routeParameters = [],
    ) {
    }
}
