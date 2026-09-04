<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation\Dto;

use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, ResolvedNavigationGroup>
 */
final readonly class ResolvedNavigation implements IteratorAggregate
{
    /**
     * @param array<int, ResolvedNavigationGroup> $groups
     */
    public function __construct(public array $groups)
    {
    }

    /**
     * @return array<int, ResolvedNavigationGroup>
     */
    public function groups(): array
    {
        return $this->groups;
    }

    public function isEmpty(): bool
    {
        return $this->groups === [];
    }

    public function getIterator(): Traversable
    {
        yield from $this->groups;
    }
}
