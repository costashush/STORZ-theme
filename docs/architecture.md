# Architecture

## Current Structure

```text
storz-theme/
├── functions.php
├── style.css
├── page-blank.php
├── inc/
│   └── form-enhancements.php
├── assets/
│   ├── css/
│   │   └── storz-ui-upgrade.css
│   └── js/
│       └── storz-ui-upgrade.js
└── docs/
```

## Responsibilities

### `functions.php`

- Theme bootstrap
- Hooks
- Asset enqueue
- Version constant

### `inc/form-enhancements.php`

- Form builder enhancements
- Custom CSS support
- AJAX preview
- Export/import logic
- Presets

### `assets/css/storz-ui-upgrade.css`

- Frontend form UI
- Builder/admin UI
- Presets
- Responsive layout

### `assets/js/storz-ui-upgrade.js`

- Lightweight UX helpers
- Builder enhancement hooks
- Double-submit protection

## v2.9+ Direction

Recommended MVC-ish structure:

```text
inc/forms/
├── FormModel.php
├── FormView.php
└── FormController.php
```

Goal: keep data, rendering, and business logic separated.
