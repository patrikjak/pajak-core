<?php

declare(strict_types=1);

namespace Pajak\Core\Tests\Unit\Support;

use Pajak\Core\Support\FormExtensions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class FormExtensionsTest extends TestCase
{
    #[Test]
    public function mergesRulesFromEveryRegisteredCallback(): void
    {
        $extensions = new FormExtensions();
        $extensions->rules('SomeRequest', static fn (): array => ['phone' => ['nullable', 'string']]);
        $extensions->rules('SomeRequest', static fn (): array => ['vat_id' => ['nullable', 'string']]);

        self::assertSame(
            ['phone' => ['nullable', 'string'], 'vat_id' => ['nullable', 'string']],
            $extensions->rulesFor('SomeRequest'),
        );
        self::assertSame(['phone', 'vat_id'], $extensions->keysFor('SomeRequest'));
    }

    #[Test]
    public function returnsEmptyForUnknownRequest(): void
    {
        self::assertSame([], (new FormExtensions())->rulesFor('Unknown'));
    }
}
