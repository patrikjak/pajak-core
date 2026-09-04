<?php

declare(strict_types=1);

namespace Pajak\Core\Authorization;

use Pajak\Core\Authorization\Dto\PermissionDefinition;

final class PermissionRegistry
{
    /**
     * @var array<string, PermissionDefinition>
     */
    private array $definitions = [];

    public function add(PermissionDefinition $definition): void
    {
        $this->definitions[$definition->key] = $definition;
    }

    /**
     * @param array<int, PermissionDefinition> $definitions
     */
    public function addMany(array $definitions): void
    {
        foreach ($definitions as $definition) {
            $this->add($definition);
        }
    }

    public function has(string $key): bool
    {
        return isset($this->definitions[$key]);
    }

    /**
     * @return array<string, PermissionDefinition>
     */
    public function all(): array
    {
        return $this->definitions;
    }

    /**
     * @return array<int, string>
     */
    public function keys(): array
    {
        return array_keys($this->definitions);
    }

    /**
     * @return array<string, array<int, PermissionDefinition>>
     */
    public function byModule(): array
    {
        $byModule = [];

        foreach ($this->definitions as $definition) {
            $byModule[$definition->module][] = $definition;
        }

        return $byModule;
    }
}
