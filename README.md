# Modularity Manual Input Extensions

Modularity Manual Input Extensions ports focused editor and compatibility
behavior from Municipio LTS to modern Municipio without restoring the
deprecated standalone Modularity plugin.

## Supported first port

- The existing Manual Input module, fields, controller, and components remain
  the source of truth.
- The stable link field `field_64ff232ad91ba` uses ACF's Link control with URL
  return format, giving editors WordPress's built-in internal-link search and
  support for external links.
- Existing URL strings and LTS link arrays are normalized to a URL string at
  read time. Raw post metadata is never rewritten.
- `link_text` remains the visible frontend label. Stored Link-field `title` and
  `target` values are preserved but not rendered by this release.
- Numeric legacy `box_icon` values are hidden at render time outside the `box`
  layout. Valid icon names and every icon value in `box` remain unchanged.

Custom Blade views, link title or target rendering, other Manual Input
extensions, and write migrations are intentionally outside this release.

## Installation

Install `municipio/wp-plugin-modularity-manual-input-extensions` with Composer.
Composer Installers places it in
`wp-content/plugins/modularity-manual-input-extensions` through
`extra.installer-name`.

The plugin supports modern Municipio only. The initial compatibility contract
is verified against `helsingborg-stad/municipio` 6.43.2, where Modularity is
bundled with the theme.

## Data and deactivation

No activation or write migration runs. Link arrays, including their `title`
and `target`, and legacy icon metadata remain untouched in the database.

The plugin is a permanent dependency while editors need the Link control and
the read-time compatibility rules. Deactivation returns the field to
Municipio's URL control and disables array normalization and legacy-icon
filtering; the stored metadata still remains intact.

## Extension points

The plugin consumes these public ACF and Modularity filters:

- `acf/load_field/key=field_64ff232ad91ba` changes only the field type and
  return format while preserving Municipio's labels, conditions, and other
  properties.
- `acf/format_value/key=field_64ff232ad91ba` guarantees that current URL strings
  and existing LTS arrays reach Municipio's controller as URL strings.
- `Modularity/Display/mod-manualinput/viewData` suppresses only numeric legacy
  icons outside the `box` layout after Municipio has prepared its normal view
  data.

## Development

```console
composer format
composer test
composer lint
```
