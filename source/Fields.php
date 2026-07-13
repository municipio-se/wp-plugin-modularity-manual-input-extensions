<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class Fields
{
    /**
     * Preserve Municipio's complete field definition and change only the editor control and its
     * frontend return contract. ACF's Link field can read both existing URL strings and LTS arrays.
     *
     * @param array<string, mixed> $field
     * @return array<string, mixed>
     */
    public static function enableLinkPicker(array $field): array
    {
        $field['type'] = 'link';
        $field['return_format'] = 'url';

        return $field;
    }
}
