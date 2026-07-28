<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class LinkValue
{
    private const LINK_FIELD_KEY = 'field_64ff232ad91ba';

    /**
     * ACF's Link field discards scalar values before saving, while Municipio's database upgrades
     * write the original URL field as a string. ACF applies type-specific update filters before
     * key-specific ones, so this guard must run on the generic hook before the priority-10
     * variation dispatcher.
     *
     * @param array<string, mixed> $field
     */
    public static function prepareForStorage(mixed $value, mixed $postId, array $field): mixed
    {
        if (($field['key'] ?? null) !== self::LINK_FIELD_KEY || !is_string($value) || $value === '') {
            return $value;
        }

        return [
            'url' => $value,
            'title' => '',
            'target' => '',
        ];
    }

    /**
     * ACF normally applies `return_format=url` before this key-specific compatibility filter. The
     * array branch remains necessary for imported LTS rows and protects Municipio's string-only
     * component contract if another filter returns the stored array unchanged.
     */
    public static function format(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_array($value) && is_string($value['url'] ?? null)) {
            return $value['url'];
        }

        return '';
    }
}
