<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\Fields;
use PHPUnit\Framework\TestCase;

final class FieldsTest extends TestCase
{
    public function testItChangesOnlyTheControlAndReturnFormat(): void
    {
        $field = [
            'key' => 'field_64ff232ad91ba',
            'label' => 'Link',
            'name' => 'link',
            'type' => 'url',
            'return_format' => 'array',
            'conditional_logic' => [['field' => 'display_as', 'operator' => '!=', 'value' => 'accordion']],
            'wrapper' => ['width' => '50'],
            'custom_property' => 'preserved',
        ];

        $result = Fields::enableLinkPicker($field);

        static::assertSame('link', $result['type']);
        static::assertSame('url', $result['return_format']);
        static::assertSame($field['conditional_logic'], $result['conditional_logic']);
        static::assertSame($field['wrapper'], $result['wrapper']);
        static::assertSame('preserved', $result['custom_property']);
    }
}
