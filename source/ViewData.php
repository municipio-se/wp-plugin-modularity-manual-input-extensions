<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions;

final class ViewData
{
    private const BOX_CONTEXT = 'module.manual-input.box';

    /**
     * Numeric `box_icon` values are media IDs left by older Manual Input data. LTS did not expose
     * them outside the box layout, while modern Municipio maps every value to the component icon.
     * Change only prepared view data so raw metadata remains available for later migration audits.
     *
     * @param array<string, mixed> $viewData
     * @return array<string, mixed>
     */
    public static function hideNumericLegacyIconsOutsideBox(array $viewData): array
    {
        if (self::isBoxLayout($viewData['context'] ?? null) || !is_array($viewData['manualInputs'] ?? null)) {
            return $viewData;
        }

        foreach ($viewData['manualInputs'] as &$input) {
            if (!is_array($input) || !self::isNumericLegacyIcon($input['icon'] ?? null)) {
                continue;
            }

            $input['icon'] = null;
        }
        unset($input);

        return $viewData;
    }

    private static function isBoxLayout(mixed $context): bool
    {
        if (is_string($context)) {
            return $context === self::BOX_CONTEXT;
        }

        return is_array($context) && in_array(self::BOX_CONTEXT, $context, true);
    }

    private static function isNumericLegacyIcon(mixed $icon): bool
    {
        if (is_int($icon)) {
            return true;
        }

        return is_string($icon) && preg_match('/^\d+$/D', trim($icon)) === 1;
    }
}
