<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Authorization;

use Pajak\Core\Authorization\Dto\PermissionDefinition;
use Pajak\Core\Authorization\PermissionRegistry;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PermissionRegistryTest extends TestCase
{
    #[Test]
    public function registersAndDeduplicatesByKey(): void
    {
        $registry = new PermissionRegistry();
        $registry->add(new PermissionDefinition('users.view', 'users', 'general', 'label'));
        $registry->add(new PermissionDefinition('users.view', 'users', 'general', 'other-label'));

        self::assertTrue($registry->has('users.view'));
        self::assertSame(['users.view'], $registry->keys());
        self::assertSame('other-label', $registry->all()['users.view']->labelKey);
    }

    #[Test]
    public function crudHelperBuildsFourKeys(): void
    {
        $registry = new PermissionRegistry();
        $registry->addMany(PermissionDefinition::crud('roles', 'pajak-core::permissions'));

        self::assertSame(
            ['roles.view', 'roles.create', 'roles.update', 'roles.delete'],
            $registry->keys(),
        );
        self::assertSame('pajak-core::permissions.roles.view', $registry->all()['roles.view']->labelKey);
    }

    #[Test]
    public function groupsDefinitionsByModule(): void
    {
        $registry = new PermissionRegistry();
        $registry->addMany(PermissionDefinition::crud('users', 'pajak-core::permissions'));
        $registry->addMany(PermissionDefinition::crud('roles', 'pajak-core::permissions'));

        $byModule = $registry->byModule();

        self::assertSame(['users', 'roles'], array_keys($byModule));
        self::assertCount(4, $byModule['users']);
    }
}
