<?php

declare(strict_types=1);

namespace Pajak\Core\Settings;

use Pajak\Core\Settings\Dto\SettingDefinition;
use Pajak\Core\Settings\Dto\SettingGroup;

final class SettingsRegistry
{
    /**
     * @var array<string, SettingGroup>
     */
    private array $groups = [];

    /**
     * @var array<string, SettingDefinition>
     */
    private array $definitions = [];

    public function group(SettingGroup $group): void
    {
        $this->groups[$group->key] = $group;
    }

    public function add(SettingDefinition $definition): void
    {
        $this->definitions[$definition->key] = $definition;
    }

    /**
     * @param array<int, SettingDefinition> $definitions
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

    public function get(string $key): ?SettingDefinition
    {
        return $this->definitions[$key] ?? null;
    }

    /**
     * @return array<string, SettingGroup>
     */
    public function groups(): array
    {
        return $this->groups;
    }

    /**
     * @return array<string, SettingDefinition>
     */
    public function all(): array
    {
        return $this->definitions;
    }

    /**
     * @return array<string, array<int, SettingDefinition>>
     */
    public function byGroup(): array
    {
        $byGroup = [];

        foreach ($this->definitions as $definition) {
            $byGroup[$definition->group][] = $definition;
        }

        return $byGroup;
    }
}
