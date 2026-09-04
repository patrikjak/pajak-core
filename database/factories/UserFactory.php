<?php

declare(strict_types=1);

namespace Pajak\Core\Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Str;
use Pajak\Core\Models\User;
use Pajak\Core\Support\Models;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    protected static ?string $password = null;

    /**
     * @return class-string<User>
     */
    public function modelName(): string
    {
        return app(Models::class)->userClass();
    }

    /**
     * @return array<string, mixed>
     * @throws BindingResolutionException
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => CarbonImmutable::now(),
            'password' => self::$password ??= app(HashManager::class)->make('password'),
            'google_id' => null,
            'remember_token' => Str::random(10),
            'disabled_at' => null,
        ];
    }

    public function unverified(): self
    {
        return $this->state(static fn (): array => ['email_verified_at' => null]);
    }

    public function disabled(): self
    {
        return $this->state(static fn (): array => ['disabled_at' => CarbonImmutable::now()]);
    }
}
