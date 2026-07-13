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

    public function testItRegistersOnlyReadTimeFilters(): void
    {
        (new Plugin())->register();

        static::assertSame(
            [
                'acf/load_field/key=field_64ff232ad91ba',
                'acf/format_value/key=field_64ff232ad91ba',
                'Modularity/Display/mod-manualinput/viewData',
            ],
            array_column($GLOBALS['manual_input_extensions_test_filters'], 0),
        );
        static::assertSame([10, 20, 10], array_column($GLOBALS['manual_input_extensions_test_filters'], 2));
    }

    public function testThePluginContainsNoActivationOrPostMetaWrites(): void
    {
        $plugin = file_get_contents(dirname(__DIR__) . '/modularity-manual-input-extensions.php');
        $source = implode("\n", array_map('file_get_contents', glob(dirname(__DIR__) . '/source/*.php') ?: []));

        static::assertIsString($plugin);
        static::assertStringNotContainsString('register_activation_hook', $plugin . $source);
        static::assertStringNotContainsString('update_post_meta', $plugin . $source);
        static::assertStringNotContainsString('update_field', $plugin . $source);
    }
}
