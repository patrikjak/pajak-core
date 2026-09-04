<?php

declare(strict_types=1);

namespace Pajak\Core\Enums;

enum SystemRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
}
