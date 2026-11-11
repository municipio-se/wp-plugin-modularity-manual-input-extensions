<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class LinkTargets
{
    /**
     * Keep the URL-only link contract while exposing the saved target on its own row. Reading
     * without ACF formatting avoids recursion and preserves duplicate URLs with different targets.
     * This runs before Modularity copies rows into the user's private list.
     */
    public static function formatRows(mixed $rows, mixed $postId, array $field): mixed
    {
        if (!is_array($rows)) {
            return $rows;
        }

        $rawRows = get_field($field['key'], $postId, false);

        return self::withTargets($rows, is_array($rawRows) ? $rawRows : []);
    }

    public static function withTargets(array $rows, array $rawRows): array
    {
        foreach ($rows as $index => &$row) {
            if (!is_array($row)) {
                continue;
            }

            // Unformatted ACF repeaters use field keys; imported values may use field names.
            $link = $rawRows[$index]['field_64ff232ad91ba'] ?? $rawRows[$index]['link'] ?? null;
            $target = is_array($link) ? $link['target'] ?? '' : '';
            $row['link_target'] = in_array($target, ['_blank', '_self', '_parent', '_top'], true) ? $target : '';
        }
        unset($row);

        return $rows;
    }
}
