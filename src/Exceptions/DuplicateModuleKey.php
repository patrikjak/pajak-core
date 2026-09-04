<?php

declare(strict_types=1);

namespace Pajak\Core\Exceptions;

use LogicException;

final class DuplicateModuleKey extends LogicException
{
    public static function for(string $key): self
    {
        return new self(sprintf('A module with key [%s] is already registered.', $key));
    }
}
