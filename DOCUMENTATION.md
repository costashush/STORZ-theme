# STORZ Theme — Documentation

Version `1.0.1` · [GitHub](https://github.com/costashush/STORZ-theme)

---

## Table of Contents

1. [Getting Started](#1-getting-started)
2. [Admin Panel Overview](#2-admin-panel-overview)
3. [Form Builder](#3-form-builder)
4. [Forms List](#4-forms-list)
5. [Submissions](#5-submissions)
6. [DB Manager](#6-db-manager)
7. [Role Manager](#7-role-manager)
8. [Rebranding](#8-rebranding)
9. [Automation](#9-automation)
10. [Settings](#10-settings)
11. [Page Templates](#11-page-templates)
12. [Shortcode Reference](#12-shortcode-reference)
13. [Custom Avatars](#13-custom-avatars)
14. [Database Schema](#14-database-schema)
15. [Constants & Version](#15-constants--version)
16. [Troubleshooting](#16-troubleshooting)

---

## 1. Getting Started

After activating the theme three database tables are created and demo content is seeded automatically. You do not need to run any setup wizard.

**What happens on activation:**

- `wp_storz_forms` — stores all forms and their field definitions.
- `wp_storz_submissions` — stores every form submission.
- `wp_storz_automation_log` — logs every message sent via the Automation panel.
- 5 demo forms are inserted: Contact Us, Newsletter Signup, Support Ticket, Event Registration, Job Application.
- 5 demo pages are published: Contact Us, Newsletter, STORZ Summit 2025, Careers, Form Demo.

If the tables already exist, `dbDelta()` safely updates the schema without data loss.

---

## 2. Admin Panel Overview

The STORZ admin panel is accessible from the **STORZ** top-level menu (🦋 icon) in the WordPress sidebar. It replaces the need for most form or role management plugins.

| Menu Item | Purpose |
|-----------|---------|
| 🏠 Dashboard | Stats overview, demo pages list, server info, top forms, automation log |
| 📋 Forms | List all forms, edit or delete |
| ✚ Builder | Create or edit a form with the drag-and-drop builder |
| 📥 Submissions | Browse and export all submitted data |
| 🗄 DB Manager | Inspect any WordPress database table |
| 👤 Roles | Create and manage custom user roles |
| 🎨 Rebranding | White-label the admin panel, login page, and frontend |
| 🤖 Automation | Send emails, Gmail, and WhatsApp messages; view the send log |
| ⚙️ Settings | General theme settings |

The top bar always shows the brand name and version, and a **+ New Form** shortcut.

---

## 3. Form Builder

Navigate to **STORZ → Builder** to create a new form, or click **Edit** on an existing form.

### Field Types

| Type | HTML Element | Notes |
|------|-------------|-------|
| `text` | `<input type="text">` | General single-line input |
| `email` | `<input type="email">` | Browser-validated email |
| `tel` | `<input type="tel">` | Phone number |
| `number` | `<input type="number">` | Numeric input |
| `url` | `<input type="url">` | URL input |
| `date` | `<input type="date">` | Date picker |
| `textarea` | `<textarea>` | Multi-line text, configurable rows |
| `select` | `<select>` | Dropdown, options defined in builder |
| `checkbox` | `<input type="checkbox">` | Multiple-choice, stores as array |
| `radio` | `<input type="radio">` | Single-choice from list |
| `rating` | Radio-based star widget | 1–5 star rating |
| `row` | Layout wrapper | Groups 2 or 3 fields side-by-side |

### Field Properties

Each field supports:

- **Label** — displayed above the field.
- **Placeholder** — hint text inside the input.
- **Required** — marks the field mandatory; frontend and server both validate.
- **Hint** — small helper text shown below the field.
- **Options** (select / checkbox / radio) — comma or newline separated option list.
- **Rows** (textarea only) — number of visible lines.

### Form Settings

| Setting | Description |
|---------|-------------|
| Submit Button Label | Text shown on the submit button |
| Success Message | Message displayed to the user after successful submission |
| Notification Email | Email address to receive a notification on each submission |
| Enable Gmail | Send the notification via Gmail OAuth2 instead of `wp_mail()` |

### Saving

Click **Save Form**. The builder sends the field JSON and settings to the `storz_save_form` AJAX endpoint. The form ID is returned and the URL updates to include `?form_id=X` so the same form can be edited again.

---

## 4. Forms List

**STORZ → Forms** lists all forms with name, description, submission count, and created date.

Actions available per row:

- **Edit** — opens the form in the Builder.
- **Embed** — copies the shortcode `[storz_form id="X"]` to the clipboard.
- **Delete** — permanently removes the form and all its submissions (confirmed via dialog).

A **Reseed Demo Forms** button at the top resets all forms and submissions back to the 5 built-in demo forms (useful during development).

**Import / Export** buttons let you move forms between sites as JSON.

---

## 5. Submissions

**STORZ → Submissions** shows all submissions across all forms, or filtered by a specific form.

Columns: ID, Form Name, Submitted Data (key-value), IP Address, Date.

### Exporting to CSV

1. (Optional) Select a form from the filter dropdown.
2. Click **Export CSV**.
3. A `.csv` file is downloaded with all visible columns, including every dynamic field from the form.

---

## 6. DB Manager

**STORZ → DB Manager** exposes every table in the WordPress database.

- **Select a table** from the dropdown to browse its rows (25 per page).
- Use the **← / →** pagination buttons to move through large tables.
- Each row has a **Delete** button that issues a `DELETE … WHERE id = X LIMIT 1`.

> ⚠️ Changes in the DB Manager are permanent. There is no undo. Use with caution on production sites.

---

## 7. Role Manager

**STORZ → Roles** lets you create and manage WordPress user roles without a plugin.

### Creating a Role

1. Enter a **Role Key** (lowercase, no spaces — e.g. `editor_plus`).
2. Enter a **Display Name** (e.g. `Editor Plus`).
3. Check the capabilities you want to grant.
4. Optionally add extra capability slugs (one per line) in the **Extra Capabilities** field.
5. Click **Save Role**.

### Editing a Role

Existing roles appear in the table. Click **Edit** to load a role's current capabilities into the form, modify as needed, and save. The role key cannot be changed after creation.

### Deleting a Role

Click **Delete** next to any custom role. The `administrator` role cannot be deleted.

> Note: Built-in WordPress roles (subscriber, contributor, author, editor) can be edited but not deleted from this panel. Use `remove_role()` in code to remove built-in roles.

---

## 8. Rebranding

**STORZ → Rebranding** provides white-label controls for the entire WordPress install.

### Brand Identity

| Field | Effect |
|-------|--------|
| Brand Name | Replaces "STORZ" text throughout the admin panel |
| Tagline | Used in the admin footer area |
| Email / Phone / Address | Available for use in templates |
| Admin Bar Label | Text shown in the top admin bar instead of the WP logo |
| Footer Text | Replaces the default WP footer credit |
| Primary & Accent Colors | CSS variable overrides (applied via injected `<style>`) |

### Login Page

| Field | Effect |
|-------|--------|
| Login Logo | Upload an image from the media library; shown on the WP login screen |
| Login Brand Text | Text shown on the login page logo link |
| Login Message | Additional message displayed below the logo |

If no custom logo is uploaded, a gradient text logo using the Brand Name is shown by default.

### Custom CSS

The CSS entered here is injected into both the **frontend** `<head>` and the **admin** `<head>` via `wp_head` and `admin_head`. It is stored in the `storz_custom_css` option and sanitized with `wp_strip_all_tags()`.

---

## 9. Automation

**STORZ → Automation** lets you send one-off messages and view the send log.

### Sending a Message

1. Choose a **channel**: Email (wp_mail), Gmail, or WhatsApp.
2. Enter the **recipient** (email address or phone number in E.164 format for WhatsApp).
3. Fill in **Subject** and **Message**.
4. Click **Send**.

Every send attempt (success or failure) is logged in `wp_storz_automation_log`.

### Gmail Setup

1. In [Google Cloud Console](https://console.cloud.google.com/), create a project.
2. Enable the **Gmail API**.
3. Create **OAuth 2.0 credentials** (Web application type).
4. Set the authorized redirect URI to: `https://yoursite.com/wp-admin/admin.php?page=storz-automation`
5. Enter your **Client ID** and **Client Secret** in the Automation settings.
6. Click **Connect Gmail** and complete the OAuth flow.

The access token and from-email are stored in wp_options (`storz_gmail_access_token`, `storz_gmail_from_email`).

### WhatsApp Setup

1. Create a [Meta for Developers](https://developers.facebook.com/) app.
2. Add the **WhatsApp Business** product.
3. Copy your **Access Token** and **Phone Number ID**.
4. Enter both in **STORZ → Automation → WhatsApp Settings**.

Recipients must have opted in to receive messages per Meta's WhatsApp Business policy.

---

## 10. Settings

**STORZ → Settings** contains general theme options such as the color theme default (dark / light) and any future configuration options.

The active color theme is stored in `storz_color_theme` (values: `dark` or `light`) and passed to the frontend via `wp_localize_script` as `StorzCfg.theme`.

---

## 11. Page Templates

STORZ registers the following custom page templates, selectable from the Page Attributes panel in the block editor:

| Template File | Label | Description |
|---------------|-------|-------------|
| `templates/blank.php` | Blank Page | No header or footer; useful for custom landing pages |
| `templates/form-demo.php` | Form Demo Page | Showcases all demo forms with shortcodes |
| `templates/landing-contact.php` | Landing — Contact | Pre-styled contact landing page |
| `templates/landing-newsletter.php` | Landing — Newsletter | Newsletter signup landing page |
| `templates/landing-event.php` | Landing — Event Registration | Event registration landing page |
| `templates/landing-careers.php` | Landing — Careers | Careers / job application landing page |

To use a template: edit the page, open **Page Attributes** in the sidebar, and select the desired template from the **Template** dropdown.

---

## 12. Shortcode Reference

### `[storz_form]`

Renders a form on any page or post.

```
[storz_form id="3" title="no"]
```

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `id` | integer | — | **Required.** The numeric form ID |
| `title` | string | `yes` | Display the form heading. Set `no` to hide |

Also available as the alias `[formcraft id="X"]`.

### Front-end submission flow

1. User fills out the form and clicks Submit.
2. `main.js` serializes the fields and POSTs to `admin-ajax.php?action=storz_submit`.
3. The server validates required fields and sanitizes all values.
4. On success: the submission is saved to `wp_storz_submissions`, a notification email is dispatched, and the success message is displayed.
5. On validation failure: per-field error messages are shown inline without a page reload.

---

## 13. Custom Avatars

Users can upload a custom avatar image from their **Profile** page.

1. Navigate to **Users → Profile** (or **Your Profile**).
2. Scroll to the **STORZ Avatar** section.
3. Click **Upload Avatar** and select an image from the media library.
4. Save the profile.

The avatar is stored as user meta (`storz_avatar_id`). The `get_avatar` filter is hooked to serve the custom image wherever WordPress displays an avatar (comments, admin user list, etc.).

---

## 14. Database Schema

### `wp_storz_forms`

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint PK | Auto-increment |
| `name` | varchar(255) | Form display name |
| `description` | text | Optional description |
| `fields` | longtext | JSON array of field objects |
| `settings` | longtext | JSON object of form settings |
| `status` | varchar(20) | `active` or `inactive` |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

### `wp_storz_submissions`

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint PK | Auto-increment |
| `form_id` | bigint | FK → `wp_storz_forms.id` |
| `data` | longtext | JSON key-value of submitted field data |
| `ip_address` | varchar(45) | Submitter IP (IPv4 or IPv6) |
| `user_agent` | varchar(500) | Browser user-agent string |
| `status` | varchar(20) | `unread` or `read` |
| `created_at` | datetime | Submission timestamp |

### `wp_storz_automation_log`

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint PK | Auto-increment |
| `channel` | varchar(20) | `email`, `gmail`, or `whatsapp` |
| `recipient` | varchar(255) | Recipient address or phone |
| `subject` | varchar(500) | Message subject |
| `message` | text | Message body |
| `status` | varchar(20) | `sent` or `failed` |
| `created_at` | datetime | Send timestamp |

---

## 15. Constants & Version

Defined in `functions.php` on load:

| Constant | Value | Description |
|----------|-------|-------------|
| `STORZ_VER` | `1.0.1` | Theme version; used for asset cache-busting |
| `STORZ_DIR` | `get_template_directory()` | Absolute path to theme root |
| `STORZ_URL` | `get_template_directory_uri()` | URL to theme root |

---

## 16. Troubleshooting

**Forms not saving / AJAX errors**

- Check that the nonce `storz_admin` is being sent. Hard-refresh the admin page to get a fresh nonce.
- Confirm the current user has the `manage_options` capability.
- Check the browser Network tab for a 4xx or 5xx response from `admin-ajax.php`.

**Database tables not created**

- Go to **STORZ → Settings** or any STORZ page — the `admin_init` hook checks `storz_db_version` against `STORZ_VER` and runs `storz_create_tables()` if they differ.
- You can also deactivate and reactivate the theme to trigger `after_switch_theme`.

**Mixed content / HTTP assets on HTTPS site**

- The theme registers a series of filters on `option_siteurl`, `option_home`, and asset URL hooks to rewrite `http://` to `https://` automatically.
- If you still see mixed content, check that `WP_HOME` and `WP_SITEURL` in `wp-config.php` use `https://`.

**Gmail OAuth "redirect_uri_mismatch"**

- The redirect URI registered in Google Cloud Console must exactly match: `https://yoursite.com/wp-admin/admin.php?page=storz-automation` (no trailing slash, correct protocol).

**Custom avatar not showing**

- Ensure the attachment ID stored in `storz_avatar_id` user meta is a valid, published media item.
- The `get_avatar` filter priority is 10 — if another plugin hooks in at a lower priority it may override STORZ's avatar.
