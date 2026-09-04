<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Closure;

final class TableExtensions
{
    /**
     * @var array<class-string, array<int, Closure(object): void>>
     */
    private array $callbacks = [];

    /**
     * @param class-string $tableClass
     * @param Closure(object): void $callback
     */
    public function extend(string $tableClass, Closure $callback): void
    {
        $this->callbacks[$tableClass][] = $callback;
    }

    /**
     * @param class-string $tableClass
     */
    public function applyTo(string $tableClass, object $table): void
    {
        foreach ($this->callbacks[$tableClass] ?? [] as $callback) {
            $callback($table);
        }
    }

    /**
     * @param class-string $tableClass
     */
    public function has(string $tableClass): bool
    {
        return isset($this->callbacks[$tableClass]) && $this->callbacks[$tableClass] !== [];
    }
}
