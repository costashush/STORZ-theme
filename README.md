# 🦋 STORZ Theme

A custom WordPress theme with a built-in admin suite — form builder, submission tracking, role manager, white-label rebranding, automation, and more. Built with PHP 72%, JavaScript 15%, CSS 12%.

![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue?logo=wordpress)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple?logo=php)
![Version](https://img.shields.io/badge/version-1.0.1-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

---

## ✨ Features

- **Form Builder** — drag-and-drop builder supporting text, email, tel, number, URL, date, textarea, select, checkbox, radio, and star-rating fields. Multi-column row layouts (2- or 3-column).
- **Submissions Manager** — view, filter, and export form submissions to CSV.
- **DB Manager** — browse any database table, paginate rows, and delete records from the admin.
- **Role Manager** — create, edit, and delete custom WordPress user roles with granular capability control.
- **Rebranding / White-label** — rename the admin panel, customize login page logo & message, inject custom CSS, and restyle the WP admin bar.
- **Automation** — send emails (WP Mail or Gmail OAuth2), WhatsApp (via Meta API), with a full send log.
- **Custom Avatars** — users can upload a custom profile avatar via the media library.
- **Demo Content** — 5 pre-built form templates and 4 landing page templates are auto-seeded on activation.
- **Dark / Light theme toggle** — visitor-facing color theme switchable via JS.
- **HTTPS enforcement** — automatic mixed-content fix for SSL sites.

---

## 📋 Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher
- MySQL 5.7 / MariaDB 10.3 or higher
- A modern browser (Chrome, Firefox, Safari, Edge)

---

## 🚀 Installation

1. Download or clone this repository into your WordPress themes directory:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/costashush/STORZ-theme.git storz
   ```

2. Go to **Appearance → Themes** in your WordPress admin and activate **STORZ**.

3. On activation the theme will automatically:
   - Create three database tables (`storz_forms`, `storz_submissions`, `storz_automation_log`)
   - Seed 5 demo forms
   - Create 4 demo pages (Contact, Newsletter, Event, Careers, Form Demo)

4. Navigate to the **STORZ** menu item in your admin sidebar to get started.

---

## 🗂 File Structure

```
storz/
├── admin/               # Admin panel pages & assets
│   ├── admin.css        # Admin UI styles
│   ├── admin.js         # Admin UI scripts
│   ├── wp-admin.css     # WP admin restyle
│   ├── wp-login.css     # Login page restyle
│   ├── page-dashboard.php
│   ├── page-forms.php
│   ├── page-builder.php
│   ├── page-submissions.php
│   ├── page-db-manager.php
│   ├── page-roles.php
│   ├── page-rebranding.php
│   ├── page-automation.php
│   └── page-settings.php
├── images/              # Theme images & logo
├── js/
│   └── main.js          # Frontend scripts
├── templates/           # Custom page templates
│   ├── blank.php
│   ├── form-demo.php
│   ├── landing-contact.php
│   ├── landing-newsletter.php
│   ├── landing-event.php
│   └── landing-careers.php
├── footer.php
├── front-page.php
├── functions.php        # Core theme logic
├── header.php
├── index.php
├── page.php
├── single.php
└── style.css            # Theme stylesheet & header
```

---

## 🧩 Shortcode

Embed any form on any page or post:

```
[storz_form id="1"]
```

Options:

| Attribute | Default | Description |
|-----------|---------|-------------|
| `id` | — | **Required.** The form ID from the Forms list. |
| `title` | `yes` | Show or hide the form title. Set to `no` to hide. |

Also aliased as `[formcraft id="1"]`.

---

## ⚙️ Configuration

### Gmail OAuth2 (Automation)

1. Create a project in [Google Cloud Console](https://console.cloud.google.com/).
2. Enable the **Gmail API** and create OAuth2 credentials.
3. In **STORZ → Automation**, enter your Client ID and Client Secret, then click **Connect Gmail**.
4. Authorize the app — your Gmail address will be saved automatically.

### WhatsApp (Automation)

1. Set up a [Meta for Developers](https://developers.facebook.com/) app with WhatsApp Business API access.
2. In **STORZ → Automation → Settings**, enter your Access Token and Phone Number ID.

### Custom CSS

Go to **STORZ → Rebranding** and paste your CSS in the Custom CSS box. It is injected into both the frontend and admin.

---

## 🪝 Hooks & Filters

STORZ registers standard WordPress hooks. Key ones:

| Hook | Type | Description |
|------|------|-------------|
| `after_switch_theme` | Action | Creates DB tables and seeds demo data |
| `storz_submit` / `storz_submit` (nopriv) | AJAX Action | Handles public form submissions |
| `get_avatar` | Filter | Overrides avatar with custom uploaded image |
| `login_headertext` | Filter | Replaces the WP login logo text with the brand name |
| `admin_bar_menu` | Action | Replaces the WP logo in the admin bar with the brand label |

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you'd like to change.

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m 'Add my feature'`
4. Push to the branch: `git push origin feature/my-feature`
5. Open a pull request

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
