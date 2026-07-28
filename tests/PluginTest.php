<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\Plugin;
use PHPUnit\Framework\TestCase;

final class PluginTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['manual_input_extensions_test_filters'] = [];
    }

    public function testItRegistersFieldCompatibilityFilters(): void
    {
        (new Plugin())->register();
        $filters = $GLOBALS['manual_input_extensions_test_filters'];

        static::assertSame(
            [
                'acf/load_field/key=field_64ff232ad91ba',
                'acf/update_value',
                'acf/format_value/key=field_64ff232ad91ba',
                'Modularity/Display/mod-manualinput/viewData',
            ],
            array_column($filters, 0),
        );
        static::assertSame([10, 5, 20, 10], array_column($filters, 2));
        static::assertSame([1, 3, 1, 1], array_column($filters, 3));
    }

    public function testThePluginContainsNoActivationOrPostMetaWrites(): void
    {
        $plugin = file_get_contents(dirname(__DIR__) . '/modularity-manual-input-extensions.php');
        $sourceFiles = glob(dirname(__DIR__) . '/source/*.php');
        $source = implode("\n", array_map('file_get_contents', is_array($sourceFiles) ? $sourceFiles : []));

        static::assertIsString($plugin);
        static::assertStringNotContainsString('register_activation_hook', $plugin . $source);
        static::assertStringNotContainsString('update_post_meta', $plugin . $source);
        static::assertStringNotContainsString('update_field', $plugin . $source);
    }
}
