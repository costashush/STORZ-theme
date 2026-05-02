# Forms System

## Overview

Forms are managed by the STORZ form builder and are designed to stay JSON-based and extendable.

## Storage

- Post type: `storz_forms`
- Fields: JSON
- Settings: JSON
- Custom CSS: `_storz_form_custom_css`

## Custom CSS per Form

Custom CSS is edited inside the form builder and rendered only for that form/page.

Recommended style:

```css
.storz-form-123 input {
    background: transparent;
}
```

## Live Preview

Flow:

```text
Builder UI → AJAX request → PHP render handler → Preview container
```

## Form Themes

Presets are controlled through form settings and can be styled using theme classes or data attributes.

Example:

```json
{
  "theme": "minimal",
  "input_style": "rounded",
  "button_color": "#111827"
}
```

## Export / Import

Export JSON should include:

```json
{
  "version": "2.9.0",
  "fields": [],
  "settings": {}
}
```

On import, validate structure before creating the form.
