<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Pajak\Core\Support\TableExtensions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

final class TableExtensionsTest extends TestCase
{
    #[Test]
    public function appliesEveryCallbackToTheTable(): void
    {
        $extensions = new TableExtensions();
        $extensions->extend('UsersTable', static fn (object $table): int => $table->calls++);
        $extensions->extend('UsersTable', static fn (object $table): int => $table->calls++);

        $table = new stdClass();
        $table->calls = 0;
        $extensions->applyTo('UsersTable', $table);

        self::assertSame(2, $table->calls);
        self::assertTrue($extensions->has('UsersTable'));
        self::assertFalse($extensions->has('RolesTable'));
    }
}
