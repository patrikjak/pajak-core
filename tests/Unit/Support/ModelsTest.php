<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Illuminate\Config\Repository;
use Pajak\Core\Exceptions\InvalidModelConfiguration;
use Pajak\Core\Models\Role;
use Pajak\Core\Models\User;
use Pajak\Core\Support\Models;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ModelsTest extends TestCase
{
    #[Test]
    public function returnsBaseClassesByDefault(): void
    {
        $models = new Models(new Repository(['pajak-core' => ['models' => []]]));

        self::assertSame(User::class, $models->userClass());
        self::assertSame(Role::class, $models->roleClass());
        self::assertSame(
            ['user', 'role', 'permission', 'invitation', 'setting'],
            array_keys($models->map()),
        );
    }

    #[Test]
    public function acceptsConfiguredSubclass(): void
    {
        $subclass = new class extends User {
        };

        $models = new Models(new Repository([
            'pajak-core' => ['models' => ['user' => $subclass::class]],
        ]));

        self::assertSame($subclass::class, $models->userClass());
    }

    #[Test]
    public function rejectsClassThatIsNotACoreModel(): void
    {
        $models = new Models(new Repository([
            'pajak-core' => ['models' => ['user' => stdClass::class]],
        ]));

        $this->expectException(InvalidModelConfiguration::class);

        $models->userClass();
    }

    #[Test]
    public function throwsForUnknownKey(): void
    {
        $models = new Models(new Repository(['pajak-core' => ['models' => []]]));

        $this->expectException(InvalidModelConfiguration::class);

        $models->instance('nope');
    }
}
