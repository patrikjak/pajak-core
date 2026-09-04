<?php

declare(strict_types=1);

namespace Pajak\Core\Exceptions;

use InvalidArgumentException;

final class InvalidModelConfiguration extends InvalidArgumentException
{
    public static function unknownKey(string $key): self
    {
        return new self(sprintf('Unknown core model key [%s].', $key));
    }

    public static function notASubclass(string $key, string $class, string $baseClass): self
    {
        return new self(sprintf(
            'Configured class [%s] for core model [%s] must be [%s] or a subclass of it.',
            $class,
            $key,
            $baseClass,
        ));
    }
}
