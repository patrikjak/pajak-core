<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

final readonly class ResolvedNavigationGroup
{
    /**
     * @param array<int, ResolvedNavigationItem> $items
     */
    public function __construct(
        public string $key,
        public ?string $label,
        public array $items,
    ) {
    }
}
