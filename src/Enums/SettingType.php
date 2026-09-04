<?php

declare(strict_types=1);

namespace Pajak\Core\Enums;

enum SettingType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Boolean = 'boolean';
    case Array = 'array';
}
