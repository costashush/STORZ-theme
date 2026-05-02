# STORZ Theme

Custom WordPress theme focused on dynamic form building, per-form styling, AJAX preview, export/import, and flexible blank pages.

## Version

Current package: **2.9.0**

This UI upgrade is built on top of the **v2.8.1** feature base.

## Features

- Dynamic form builder
- Custom CSS per form
- AJAX live preview
- Form themes/presets
- Export/import forms
- Blank page template without header/footer
- Modernized frontend and builder UI

## Documentation

- [Forms](docs/forms.md)
- [Architecture](docs/architecture.md)
- [Development](docs/development.md)
- [Git Workflow](docs/git.md)

## Installation

Upload the theme folder to:

```text
/wp-content/themes/
```

Then activate it from WordPress Admin → Appearance → Themes.

## Recommended Git Commit

```bash
git add .
git commit -m "v2.9.0: upgrade UI based on v2.8.1"
git push
```


## v2.9 FormCraft UI Merge

This package keeps the STORZ v2.9/v2.8.1 feature base and adds the uploaded FormCraft-inspired UI layer:

- FormCraft-style homepage
- Dark modern frontend form skin
- Admin/builder visual polish
- Drag/drop visual affordances
- Existing STORZ form builder logic preserved
- Existing custom CSS, AJAX preview, presets and export/import preserved

Main added files:

```text
assets/css/storz-formcraft-ui.css
assets/js/storz-formcraft-ui.js
front-page.php
```

## Admin UI

The admin/form-builder UI is intentionally light and WordPress-friendly. The dark FormCraft-inspired visual style is kept mainly for the homepage and frontend forms.


## v2.9 Premium Polish

Added:

- Global dark frontend
- Optional frontend dark/light toggle
- Better typography for regular pages/posts
- Premium card hover effects
- Improved content readability
- Reduced-motion support
