<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class LinkPicker
{
    public static function enqueue(): void
    {
        wp_enqueue_script(
            'manual-input-link-picker',
            plugins_url('link-picker.js', __FILE__),
            ['acf-input', 'wplink'],
            (string) filemtime(__DIR__ . '/link-picker.js'),
            true,
        );
    }
}
