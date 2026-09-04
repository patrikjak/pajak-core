<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

final readonly class ResolvedNavigationItem
{
    /**
     * @param array<int, ResolvedNavigationItem> $children
     */
    public function __construct(
        public string $key,
        public string $label,
        public string $href,
        public bool $active,
        public ?string $icon = null,
        public array $children = [],
    ) {
    }
}
