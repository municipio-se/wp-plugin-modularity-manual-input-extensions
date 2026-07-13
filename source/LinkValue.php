<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class LinkValue
{
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

        if (is_array($value) && isset($value['url']) && is_string($value['url'])) {
            return $value['url'];
        }

        return '';
    }
}
