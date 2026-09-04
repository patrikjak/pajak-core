<?php

declare(strict_types=1);

namespace Pajak\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Pajak\Core\Models\Concerns\ResolvesCoreModels;

/**
 * Fleshed out in the Authorization phase (schema, relationships, factory).
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property bool $is_system
 * @property ?string $description
 */
class Role extends Model
{
    use HasUuids;
    use ResolvesCoreModels;
}
