<?php

declare(strict_types=1);

namespace Pajak\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Fleshed out in the Authorization phase (schema, relationships).
 *
 * @property string $id
 * @property string $key
 * @property string $module
 * @property string $group
 */
class Permission extends Model
{
    use HasUuids;
}
