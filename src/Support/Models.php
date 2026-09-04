<?php

declare(strict_types=1);

namespace Pajak\Core\Support;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Pajak\Core\Exceptions\InvalidModelConfiguration;
use Pajak\Core\Models\Invitation;
use Pajak\Core\Models\Permission;
use Pajak\Core\Models\Role;
use Pajak\Core\Models\Setting;
use Pajak\Core\Models\User;

final readonly class Models
{
    private const array BASE_CLASSES = [
        'user' => User::class,
        'role' => Role::class,
        'permission' => Permission::class,
        'invitation' => Invitation::class,
        'setting' => Setting::class,
    ];

    public function __construct(private Repository $repository)
    {
    }

    /**
     * @return array<string, class-string<Model>>
     */
    public function map(): array
    {
        return [
            'user' => $this->userClass(),
            'role' => $this->roleClass(),
            'permission' => $this->permissionClass(),
            'invitation' => $this->invitationClass(),
            'setting' => $this->settingClass(),
        ];
    }

    /**
     * @return class-string<User>
     */
    public function userClass(): string
    {
        return $this->resolve('user', User::class);
    }

    /**
     * @return class-string<Role>
     */
    public function roleClass(): string
    {
        return $this->resolve('role', Role::class);
    }

    /**
     * @return class-string<Permission>
     */
    public function permissionClass(): string
    {
        return $this->resolve('permission', Permission::class);
    }

    /**
     * @return class-string<Invitation>
     */
    public function invitationClass(): string
    {
        return $this->resolve('invitation', Invitation::class);
    }

    /**
     * @return class-string<Setting>
     */
    public function settingClass(): string
    {
        return $this->resolve('setting', Setting::class);
    }

    public function instance(string $key): Model
    {
        $class = $this->classFor($key);

        return new $class();
    }

    /**
     * @return Builder<Model>
     */
    public function query(string $key): Builder
    {
        return $this->instance($key)->newQuery();
    }

    /**
     * @template TModel of Model
     *
     * @param class-string<TModel> $baseClass
     *
     * @return class-string<TModel>
     *
     * @throws InvalidModelConfiguration
     */
    private function resolve(string $key, string $baseClass): string
    {
        $configured = $this->repository->get(sprintf('pajak-core.models.%s', $key));

        if ($configured === null) {
            return $baseClass;
        }

        if (!is_string($configured)) {
            throw InvalidModelConfiguration::notASubclass($key, get_debug_type($configured), $baseClass);
        }

        if ($configured !== $baseClass && !is_subclass_of($configured, $baseClass)) {
            throw InvalidModelConfiguration::notASubclass($key, $configured, $baseClass);
        }

        return $configured;
    }

    /**
     * @return class-string<Model>
     *
     * @throws InvalidModelConfiguration
     */
    private function classFor(string $key): string
    {
        $baseClass = self::BASE_CLASSES[$key] ?? throw InvalidModelConfiguration::unknownKey($key);

        return $this->resolve($key, $baseClass);
    }
}
