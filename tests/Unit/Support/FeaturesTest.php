<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Illuminate\Config\Repository;
use Pajak\Core\Support\Features;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class FeaturesTest extends TestCase
{
    #[Test]
    public function readsFlagsFromConfig(): void
    {
        $features = new Features(new Repository([
            'pajak-core' => ['features' => ['google_login' => true, 'registration' => false]],
        ]));

        self::assertTrue($features->enabled('google_login'));
        self::assertFalse($features->enabled('registration'));
        self::assertTrue($features->disabled('registration'));
    }

    #[Test]
    public function unknownFlagIsDisabled(): void
    {
        $features = new Features(new Repository(['pajak-core' => ['features' => []]]));

        self::assertFalse($features->enabled('nope'));
    }

    #[Test]
    public function allReturnsBooleans(): void
    {
        $features = new Features(new Repository([
            'pajak-core' => ['features' => ['a' => 1, 'b' => 0]],
        ]));

        self::assertSame(['a' => true, 'b' => false], $features->all());
    }
}
