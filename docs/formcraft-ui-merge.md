# v2.9 FormCraft UI Merge

## Goal

Bring the uploaded FormCraft-style UI into STORZ without replacing the STORZ builder system.

## Preserved STORZ Features

- Form builder
- Drag/drop field behavior
- Custom CSS per form
- AJAX live preview
- Form themes/presets
- Export/import
- Submissions logic
- Blank page template

## Added / Updated

- `front-page.php` rebuilt with FormCraft-inspired landing page UI
- `assets/css/storz-formcraft-ui.css`
- `assets/js/storz-formcraft-ui.js`
- Admin/builder visual skin
- Frontend form visual skin
- Drag/drop handle visual affordance

## Notes

The merge is intentionally UI-focused. It does not replace STORZ database tables, post types, AJAX handlers, or builder data structures.
