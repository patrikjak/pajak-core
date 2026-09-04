<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Closure;

final class FormExtensions
{
    /**
     * @var array<class-string, array<int, Closure(): array<string, mixed>>>
     */
    private array $callbacks = [];

    /**
     * @param class-string $requestClass
     * @param Closure(): array<string, mixed> $callback
     */
    public function rules(string $requestClass, Closure $callback): void
    {
        $this->callbacks[$requestClass][] = $callback;
    }

    /**
     * @param class-string $requestClass
     *
     * @return array<string, mixed>
     */
    public function rulesFor(string $requestClass): array
    {
        $rules = [];

        foreach ($this->callbacks[$requestClass] ?? [] as $callback) {
            $rules = array_merge($rules, $callback());
        }

        return $rules;
    }

    /**
     * @param class-string $requestClass
     *
     * @return array<int, string>
     */
    public function keysFor(string $requestClass): array
    {
        return array_keys($this->rulesFor($requestClass));
    }
}
