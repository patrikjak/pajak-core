<?php

declare(strict_types=1);

namespace Pajak\Core\Modules;

use Pajak\Core\Exceptions\DuplicateModuleKey;
use Pajak\Core\Exceptions\UnknownModule;

final class ModuleRegistry
{
    /**
     * @var array<string, Module>
     */
    private array $modules = [];

    /**
     * @param array<int, Module> $modules
     *
     * @throws DuplicateModuleKey
     */
    public function __construct(array $modules = [])
    {
        foreach ($modules as $module) {
            $this->add($module);
        }
    }

    /**
     * @throws DuplicateModuleKey
     */
    public function add(Module $module): void
    {
        if (isset($this->modules[$module->key()])) {
            throw DuplicateModuleKey::for($module->key());
        }

        $this->modules[$module->key()] = $module;
    }

    public function has(string $key): bool
    {
        return isset($this->modules[$key]);
    }

    /**
     * @throws UnknownModule
     */
    public function get(string $key): Module
    {
        return $this->modules[$key] ?? throw UnknownModule::for($key);
    }

    /**
     * @return array<string, Module>
     */
    public function all(): array
    {
        return $this->modules;
    }
}
