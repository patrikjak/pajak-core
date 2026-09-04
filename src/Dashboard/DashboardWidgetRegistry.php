<?php

declare(strict_types=1);

namespace Pajak\Core\Dashboard;

use Pajak\Core\Dashboard\Contracts\DashboardWidget;

final class DashboardWidgetRegistry
{
    /**
     * @var array<int, class-string<DashboardWidget>>
     */
    private array $widgets = [];

    /**
     * @param class-string<DashboardWidget> $widget
     */
    public function add(string $widget): void
    {
        if (!in_array($widget, $this->widgets, true)) {
            $this->widgets[] = $widget;
        }
    }

    /**
     * @param array<int, class-string<DashboardWidget>> $widgets
     */
    public function addMany(array $widgets): void
    {
        foreach ($widgets as $widget) {
            $this->add($widget);
        }
    }

    /**
     * @return array<int, class-string<DashboardWidget>>
     */
    public function all(): array
    {
        return $this->widgets;
    }
}
