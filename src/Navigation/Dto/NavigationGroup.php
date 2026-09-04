<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

final readonly class NavigationGroup
{
    public function __construct(
        public string $key,
        public ?string $label = null,
        public int $order = 100,
    ) {
    }
}
