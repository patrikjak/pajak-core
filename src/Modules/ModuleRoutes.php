<?php

declare(strict_types=1);

namespace Pajak\Core\Modules;

final readonly class ModuleRoutes
{
    private function __construct(
        public ?string $web,
        public ?string $api,
    ) {
    }

    public static function make(?string $web = null, ?string $api = null): self
    {
        return new self($web, $api);
    }
}
