<?php

declare(strict_types=1);

namespace Pajak\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Pajak\Core\Models\Concerns\ResolvesCoreModels;

/**
 * Fleshed out in the Auth phase (schema, relationships, factory).
 *
 * @property string $id
 * @property string $email
 * @property array<int, string> $role_ids
 * @property ?string $invited_by_id
 */
class Invitation extends Model
{
    use HasUuids;
    use ResolvesCoreModels;

    public function getTable(): string
    {
        return 'user_invitations';
    }
}
