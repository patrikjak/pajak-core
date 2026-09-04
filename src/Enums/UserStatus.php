<?php

declare(strict_types=1);

namespace Pajak\Core\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
}
