<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Illuminate\Contracts\Config\Repository;

final readonly class Features
{
    public function __construct(private Repository $repository)
    {
    }

    public function enabled(string $key): bool
    {
        return (bool) $this->repository->get(sprintf('pajak-core.features.%s', $key), false);
    }

    public function disabled(string $key): bool
    {
        return !$this->enabled($key);
    }

    /**
     * @return array<string, bool>
     */
    public function all(): array
    {
        $features = $this->repository->get('pajak-core.features', []);

        return array_map(static fn (mixed $value): bool => (bool) $value, $features);
    }
}
