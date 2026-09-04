<?php

declare(strict_types=1);

namespace Pajak\Core\Settings\Dto;

use Pajak\Core\Enums\SettingType;

final readonly class SettingDefinition
{
    /**
     * @param array<int, string> $rules
     */
    public function __construct(
        public string $key,
        public string $group,
        public SettingType $type,
        public mixed $default = null,
        public ?string $labelKey = null,
        public array $rules = [],
    ) {
    }
}
