<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

final readonly class NavigationItem
{
    /**
     * @param array<int, string> $activeRoutes
     * @param array<int, NavigationChild> $children
     * @param array<string, string> $routeParameters
     */
    public function __construct(
        public string $key,
        public string $label,
        public string $route,
        public string $group = 'main',
        public ?string $icon = null,
        public ?string $permission = null,
        public array $activeRoutes = [],
        public int $order = 100,
        public array $children = [],
        public array $routeParameters = [],
    ) {
    }
}
