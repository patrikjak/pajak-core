<?php

declare(strict_types=1);

namespace Pajak\Core\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Pajak\Core\Database\Factories\UserFactory;
use Pajak\Core\Enums\SystemRole;
use Pajak\Core\Models\Concerns\ResolvesCoreModels;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property ?string $password
 * @property ?string $google_id
 * @property ?CarbonImmutable $email_verified_at
 * @property ?CarbonImmutable $disabled_at
 * @property ?string $remember_token
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Collection<int, Role> $roles
 */
#[Fillable(['first_name', 'last_name', 'email', 'password', 'google_id', 'disabled_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /**
     * @use HasFactory<UserFactory>
     */
    use HasFactory;
    use HasUuids;
    use Notifiable;
    use ResolvesCoreModels;

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    /**
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany($this->roleModel(), 'role_user');
    }

    public function fullName(): string
    {
        return trim(sprintf('%s %s', $this->first_name, $this->last_name));
    }

    public function initials(): string
    {
        return mb_strtoupper(mb_substr($this->first_name, 0, 1) . mb_substr($this->last_name, 0, 1));
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles->contains('slug', SystemRole::SuperAdmin->value);
    }

    public function isDisabled(): bool
    {
        return $this->disabled_at !== null;
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'immutable_datetime',
            'disabled_at' => 'immutable_datetime',
        ];
    }
}
