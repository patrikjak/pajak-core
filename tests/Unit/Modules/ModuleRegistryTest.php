<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Modules;

use Pajak\Core\Exceptions\DuplicateModuleKey;
use Pajak\Core\Exceptions\UnknownModule;
use Pajak\Core\Modules\Module;
use Pajak\Core\Modules\ModuleRegistry;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ModuleRegistryTest extends TestCase
{
    #[Test]
    public function registersModulesByKey(): void
    {
        $module = $this->module('alpha');
        $registry = new ModuleRegistry([$module]);

        self::assertTrue($registry->has('alpha'));
        self::assertSame($module, $registry->get('alpha'));
        self::assertSame(['alpha'], array_keys($registry->all()));
    }

    #[Test]
    public function rejectsDuplicateKeys(): void
    {
        $this->expectException(DuplicateModuleKey::class);

        new ModuleRegistry([$this->module('alpha'), $this->module('alpha')]);
    }

    #[Test]
    public function throwsForUnknownKey(): void
    {
        $this->expectException(UnknownModule::class);

        (new ModuleRegistry())->get('missing');
    }

    private function module(string $key): Module
    {
        return new class ($key) extends Module {
            public function __construct(private readonly string $moduleKey)
            {
            }

            public function key(): string
            {
                return $this->moduleKey;
            }
        };
    }
}
