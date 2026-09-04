<?php

declare(strict_types=1);

namespace Pajak\Core\Settings\Dto;

final readonly class SettingGroup
{
    public function __construct(
        public string $key,
        public ?string $labelKey = null,
        public int $order = 100,
    ) {
    }
}
