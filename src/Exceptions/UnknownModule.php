<?php

declare(strict_types=1);

namespace Pajak\Core\Exceptions;

use OutOfBoundsException;

final class UnknownModule extends OutOfBoundsException
{
    public static function for(string $key): self
    {
        return new self(sprintf('No module registered with key [%s].', $key));
    }
}
