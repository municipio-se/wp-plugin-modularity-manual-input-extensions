<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class Plugin
{
    private const LINK_FIELD_KEY = 'field_64ff232ad91ba';

    public function register(): void
    {
        add_filter('acf/load_field/key=' . self::LINK_FIELD_KEY, [Fields::class, 'enableLinkPicker']);
        add_filter('acf/format_value/key=' . self::LINK_FIELD_KEY, [LinkValue::class, 'format'], 20);

        /**
         * Municipio has already selected the Manual Input layout and prepared component data at
         * this point, so the compatibility rule has enough context without replacing its views.
         */
        add_filter('Modularity/Display/mod-manualinput/viewData', [
            ViewData::class,
            'hideNumericLegacyIconsOutsideBox',
        ]);
    }
}
