# STORZ Theme Documentation (v2.8.1)

## Overview

STORZ is a custom WordPress theme with a dynamic form builder, custom
styling, and extensibility.

------------------------------------------------------------------------

## Installation

1.  Upload theme to `/wp-content/themes/`
2.  Activate in WordPress Admin
3.  (Optional) Import demo forms

------------------------------------------------------------------------

## Versioning

Single source of truth in `functions.php`:

    define('STORZ_THEME_VERSION', '2.8.1');

Used for cache busting and compatibility.

------------------------------------------------------------------------

## Form Builder

### Storage

-   Post Type: storz_forms
-   Fields: JSON
-   Settings: JSON

------------------------------------------------------------------------

## Custom CSS per Form

-   UI inside builder
-   Saved as: `_storz_form_custom_css`
-   Injected into `<head>`

------------------------------------------------------------------------

## Live Preview

-   Uses AJAX
-   Updates form preview without reload

------------------------------------------------------------------------

## Form Themes

-   Presets applied via settings
-   Example: dark, light, rounded

------------------------------------------------------------------------

## Export / Import

-   Export JSON with version
-   Import validates structure

------------------------------------------------------------------------

## Blank Page Template

File: `page-blank.php`

Use for: - Landing pages - Full-screen forms

------------------------------------------------------------------------

## Development

### Dev Mode

    define('STORZ_DEV_MODE', true);

### Best Practices

-   Use STORZ_THEME_VERSION
-   Keep logic in /inc/
-   Sanitize input and escape output

------------------------------------------------------------------------

## Git Workflow

    git add .
    git commit -m "message"
    git push

------------------------------------------------------------------------

## Future Improvements

-   MVC structure
-   Plugin extraction
-   API integration
