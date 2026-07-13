<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\LinkValue;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LinkValueTest extends TestCase
{
    #[DataProvider('values')]
    public function testItReturnsOnlyAUrlString(mixed $value, string $expected): void
    {
        static::assertSame($expected, LinkValue::format($value));
    }

    /**
     * @return iterable<string, array{mixed, string}>
     */
    public static function values(): iterable
    {
        yield 'current URL string' => ['https://example.test/page', 'https://example.test/page'];
        yield 'LTS link array' => [
            ['url' => 'https://example.test/internal', 'title' => 'Stored title', 'target' => '_blank'],
            'https://example.test/internal',
        ];
        yield 'empty value' => [null, ''];
        yield 'array without URL' => [['title' => 'Missing URL'], ''];
        yield 'non-string URL' => [['url' => 123], ''];
        yield 'unexpected scalar' => [123, ''];
    }
}
