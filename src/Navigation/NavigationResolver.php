<?php

declare(strict_types=1);

namespace Pajak\Core\Navigation;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Pajak\Core\Navigation\Dto\NavigationChild;
use Pajak\Core\Navigation\Dto\NavigationGroup;
use Pajak\Core\Navigation\Dto\NavigationItem;
use Pajak\Core\Navigation\Dto\ResolvedNavigation;
use Pajak\Core\Navigation\Dto\ResolvedNavigationGroup;
use Pajak\Core\Navigation\Dto\ResolvedNavigationItem;

final readonly class NavigationResolver
{
    public function __construct(
        private NavigationRegistry $navigationRegistry,
        private Gate $gate,
        private Request $request,
        private UrlGenerator $urlGenerator,
    ) {
    }

    public function resolve(): ResolvedNavigation
    {
        $items = $this->navigationRegistry->items();
        uasort($items, static fn (NavigationItem $a, NavigationItem $b): int => $a->order <=> $b->order);

        $byGroup = [];

        foreach ($items as $item) {
            if (!$this->allowed($item->permission)) {
                continue;
            }

            $byGroup[$item->group][] = $this->resolveItem($item);
        }

        return new ResolvedNavigation($this->buildGroups($byGroup));
    }

    /**
     * @param array<string, array<int, ResolvedNavigationItem>> $byGroup
     *
     * @return array<int, ResolvedNavigationGroup>
     */
    private function buildGroups(array $byGroup): array
    {
        $groups = $this->navigationRegistry->groups();
        uasort($groups, static fn (NavigationGroup $a, NavigationGroup $b): int => $a->order <=> $b->order);

        $ordered = array_keys($groups);

        foreach (array_keys($byGroup) as $groupKey) {
            if (!in_array($groupKey, $ordered, true)) {
                $ordered[] = $groupKey;
            }
        }

        $resolved = [];

        foreach ($ordered as $groupKey) {
            if (($byGroup[$groupKey] ?? []) === []) {
                continue;
            }

            $resolved[] = new ResolvedNavigationGroup(
                $groupKey,
                $groups[$groupKey]->label ?? null,
                $byGroup[$groupKey],
            );
        }

        return $resolved;
    }

    private function resolveItem(NavigationItem $item): ResolvedNavigationItem
    {
        $children = [];
        $anyChildActive = false;

        foreach ($this->sortChildren($item->children) as $child) {
            if (!$this->allowed($child->permission)) {
                continue;
            }

            $resolvedChild = $this->resolveChild($child);
            $anyChildActive = $anyChildActive || $resolvedChild->active;
            $children[] = $resolvedChild;
        }

        return new ResolvedNavigationItem(
            $item->key,
            $item->label,
            $this->urlGenerator->route($item->route, $item->routeParameters),
            $this->matchesCurrentRoute($item->route, $item->activeRoutes) || $anyChildActive,
            $item->icon,
            $children,
        );
    }

    private function resolveChild(NavigationChild $child): ResolvedNavigationItem
    {
        return new ResolvedNavigationItem(
            $child->key,
            $child->label,
            $this->urlGenerator->route($child->route, $child->routeParameters),
            $this->matchesCurrentRoute($child->route, $child->activeRoutes),
        );
    }

    /**
     * @param array<int, NavigationChild> $children
     *
     * @return array<int, NavigationChild>
     */
    private function sortChildren(array $children): array
    {
        usort($children, static fn (NavigationChild $a, NavigationChild $b): int => $a->order <=> $b->order);

        return $children;
    }

    private function allowed(?string $permission): bool
    {
        return $permission === null || $this->gate->allows($permission);
    }

    /**
     * @param array<int, string> $activeRoutes
     */
    private function matchesCurrentRoute(string $route, array $activeRoutes): bool
    {
        if ($this->request->route() === null) {
            return false;
        }

        $patterns = $activeRoutes === []
            ? [$route, sprintf('%s.*', Str::beforeLast($route, '.'))]
            : $activeRoutes;

        return $this->request->routeIs(...$patterns);
    }
}
