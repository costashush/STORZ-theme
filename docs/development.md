# Development Guide

## Versioning

Use a single source of truth:

```php
define('STORZ_THEME_VERSION', '2.9.0');
```

Use it for CSS/JS cache busting.

## UI Styling

Main UI upgrade file:

```text
assets/css/storz-ui-upgrade.css
```

Use CSS variables:

```css
:root {
    --storz-primary: #111827;
    --storz-radius: 14px;
}
```

## Security

Sanitize input:

```php
sanitize_text_field()
```

Escape output:

```php
esc_html()
esc_attr()
```

For CSS, avoid raw output unless sanitized and scoped.

## Best Practices

- Keep logic inside `/inc/`
- Keep templates clean
- Scope CSS using `.storz-*`
- Avoid changing the form data structure unless versioned
- Use comments for non-obvious logic
