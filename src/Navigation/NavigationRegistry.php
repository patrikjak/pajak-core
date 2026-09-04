<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation;

use Pajak\Core\Navigation\Dto\NavigationGroup;
use Pajak\Core\Navigation\Dto\NavigationItem;

final class NavigationRegistry
{
    /**
     * @var array<string, NavigationGroup>
     */
    private array $groups = [];

    /**
     * @var array<string, NavigationItem>
     */
    private array $items = [];

    public function group(NavigationGroup $group): void
    {
        $this->groups[$group->key] = $group;
    }

    public function add(NavigationItem $item): void
    {
        $this->items[$item->key] = $item;
    }

    /**
     * @param array<int, NavigationItem> $items
     */
    public function addMany(array $items): void
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }

    public function hasGroup(string $key): bool
    {
        return isset($this->groups[$key]);
    }

    /**
     * @return array<string, NavigationGroup>
     */
    public function groups(): array
    {
        return $this->groups;
    }

    /**
     * @return array<string, NavigationItem>
     */
    public function items(): array
    {
        return $this->items;
    }
}
