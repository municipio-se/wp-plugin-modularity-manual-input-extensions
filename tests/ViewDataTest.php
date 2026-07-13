<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\ViewData;
use PHPUnit\Framework\TestCase;

final class ViewDataTest extends TestCase
{
    public function testItHidesNumericLegacyIconsOutsideBoxWithoutChangingRawCompanionData(): void
    {
        $viewData = [
            'context' => ['module.manual-input.card'],
            'manualInputs' => [
                ['icon' => 123, 'boxIcon' => 123, 'title' => 'First'],
                ['icon' => '456', 'boxIcon' => '456', 'title' => 'Second'],
            ],
        ];

        $result = ViewData::hideNumericLegacyIconsOutsideBox($viewData);

        static::assertNull($result['manualInputs'][0]['icon']);
        static::assertNull($result['manualInputs'][1]['icon']);
        static::assertSame(123, $result['manualInputs'][0]['boxIcon']);
        static::assertSame('456', $result['manualInputs'][1]['boxIcon']);
    }

    public function testItPreservesValidIconNamesOutsideBox(): void
    {
        $viewData = [
            'context' => 'module.manual-input.card',
            'manualInputs' => [['icon' => 'home', 'boxIcon' => 'home']],
        ];

        static::assertSame($viewData, ViewData::hideNumericLegacyIconsOutsideBox($viewData));
    }

    public function testItPreservesEveryIconValueInBox(): void
    {
        $viewData = [
            'context' => ['module.manual-input.box'],
            'manualInputs' => [
                ['icon' => 123, 'boxIcon' => 123],
                ['icon' => 'home', 'boxIcon' => 'home'],
            ],
        ];

        static::assertSame($viewData, ViewData::hideNumericLegacyIconsOutsideBox($viewData));
    }

    public function testItLeavesUnrelatedViewDataUntouched(): void
    {
        $viewData = ['context' => ['module.manual-input.card'], 'title' => 'No rows'];

        static::assertSame($viewData, ViewData::hideNumericLegacyIconsOutsideBox($viewData));
    }
}
