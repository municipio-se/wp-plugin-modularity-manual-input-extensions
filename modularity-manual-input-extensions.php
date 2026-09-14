<?php

/**
 * Plugin Name: Modularity Manual Input Extensions
 * Description: Adds focused Manual Input editor and compatibility behavior to modern Municipio.
 * Version: 1.0.0
 * Requires PHP: 8.2
 * Author: Whitespace
 * License: MIT
 * Text Domain: modularity-manual-input-extensions
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit();
}

/**
 * Composer's installer-name is the production path contract. The fixed WordPress slug also keeps
 * autoloading stable when the local package is installed through a symlink.
 */
define(
    'MODULARITY_MANUAL_INPUT_EXTENSIONS_PATH',
    trailingslashit(WP_PLUGIN_DIR) . 'modularity-manual-input-extensions/',
);

$autoload = MODULARITY_MANUAL_INPUT_EXTENSIONS_PATH . 'vendor/autoload.php';

if (is_readable($autoload)) {
    require_once $autoload;
}

if (class_exists(\MunicipioModularityManualInputExtensions\Plugin::class)) {
    (new \MunicipioModularityManualInputExtensions\Plugin())->register();
}
