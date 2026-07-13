# Repository instructions

## Scope

This plugin ports focused editor and compatibility behavior for Manual Input in
modern Municipio. Keep it independent of Municipio Cloud and the deprecated
standalone Modularity plugin.

Preserve the existing Manual Input field keys and raw metadata. Do not add
templates, write migrations, link-target behavior, or unrelated LTS features
without a separately confirmed outcome.

## Verification

Run these commands after changing PHP or runtime behavior:

```console
composer format
composer test
composer lint
```
