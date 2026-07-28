<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\LinkValue;
use PHPUnit\Framework\TestCase;

final class LinkValueStorageTest extends TestCase
{
    private const LINK_FIELD = [
        'key' => 'field_64ff232ad91ba',
        'type' => 'link',
    ];

    public function testItPreparesProgrammaticUrlStringsForAcfLinkStorage(): void
    {
        static::assertSame(
            [
                'url' => 'https://example.com/path',
                'title' => '',
                'target' => '',
            ],
            LinkValue::prepareForStorage('https://example.com/path', 88, self::LINK_FIELD),
        );
    }

    public function testItPreservesExistingLinkArrays(): void
    {
        $link = [
            'url' => 'https://example.com/path',
            'title' => 'Example',
            'target' => '_blank',
        ];

        static::assertSame($link, LinkValue::prepareForStorage($link, 88, self::LINK_FIELD));
    }

    public function testItPreservesEmptyAndUnsupportedValues(): void
    {
        static::assertSame('', LinkValue::prepareForStorage('', 88, self::LINK_FIELD));
        static::assertNull(LinkValue::prepareForStorage(null, 88, self::LINK_FIELD));
        static::assertFalse(LinkValue::prepareForStorage(false, 88, self::LINK_FIELD));
    }

    public function testItDoesNotChangeOtherFields(): void
    {
        static::assertSame('https://example.com/path', LinkValue::prepareForStorage('https://example.com/path', 88, [
            'key' => 'field_unrelated',
            'type' => 'link',
        ]));
    }
}
