<?php

declare(strict_types=1);

namespace Pajak\Core\Authorization\Dto;

final readonly class PermissionDefinition
{
    public function __construct(
        public string $key,
        public string $module,
        public string $group,
        public string $labelKey,
    ) {
    }

    /**
     * @param array<int, string> $actions
     *
     * @return array<int, self>
     */
    public static function crud(
        string $module,
        string $translationNamespace,
        string $group = 'general',
        array $actions = ['view', 'create', 'update', 'delete'],
    ): array {
        return array_map(
            static fn (string $action): self => new self(
                sprintf('%s.%s', $module, $action),
                $module,
                $group,
                sprintf('%s.%s.%s', $translationNamespace, $module, $action),
            ),
            $actions,
        );
    }
}
