<?php

declare(strict_types=1);

namespace Pajak\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Fleshed out in the Settings phase (schema, casts, repository).
 *
 * @property string $id
 * @property string $key
 * @property mixed $value
 */
class Setting extends Model
{
    use HasUuids;
}
