<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Settings;

use Pajak\Core\Enums\SettingType;
use Pajak\Core\Settings\Dto\SettingDefinition;
use Pajak\Core\Settings\SettingsRegistry;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SettingsRegistryTest extends TestCase
{
    #[Test]
    public function registersDefinitionsAndGroupsThem(): void
    {
        $registry = new SettingsRegistry();
        $registry->addMany([
            new SettingDefinition('app.name', 'general', SettingType::String),
            new SettingDefinition('app.locale', 'general', SettingType::String),
            new SettingDefinition('mail.from', 'mail', SettingType::String),
        ]);

        self::assertTrue($registry->has('app.name'));
        self::assertSame(SettingType::String, $registry->get('app.name')?->type);
        self::assertNull($registry->get('missing'));
        self::assertSame(['general', 'mail'], array_keys($registry->byGroup()));
        self::assertCount(2, $registry->byGroup()['general']);
    }
}
