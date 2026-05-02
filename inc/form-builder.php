<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_forms() {
    global $wpdb;
    $table = $wpdb->prefix . 'storz_forms';
    return $wpdb->get_results("SELECT * FROM {$table} ORDER BY id DESC");
}

function storz_get_form($id) {
    global $wpdb;
    $table = $wpdb->prefix . 'storz_forms';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE id = %d", $id));
}

function storz_get_prebuilt_form_templates() {
    return [
        'contact' => [
            'name' => 'Contact Form',
            'slug' => 'contact-form',
            'fields' => [
                ['label' => 'Full Name', 'name' => 'full_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Phone', 'name' => 'phone', 'type' => 'tel', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Subject', 'name' => 'subject', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 2],
                ['label' => 'Message', 'name' => 'message', 'type' => 'textarea', 'data_source' => 'manual', 'options' => [], 'step' => 2],
            ],
        ],
        'lead' => [
            'name' => 'Lead Capture Multi-Step Form',
            'slug' => 'lead-capture-form',
            'fields' => [
                ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Phone', 'name' => 'phone', 'type' => 'tel', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Company', 'name' => 'company', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 2],
                ['label' => 'Business Type', 'name' => 'business_type', 'type' => 'select', 'data_source' => 'manual', 'options' => ['Startup', 'Small Business', 'Agency', 'Ecommerce', 'Enterprise'], 'step' => 2],
                ['label' => 'Needed Services', 'name' => 'needed_services', 'type' => 'checkbox', 'data_source' => 'manual', 'options' => ['Website', 'WooCommerce', 'SEO', 'Maintenance', 'Custom Dev'], 'step' => 2],
                ['label' => 'Project Details', 'name' => 'project_details', 'type' => 'textarea', 'data_source' => 'manual', 'options' => [], 'step' => 3],
                ['label' => 'Budget', 'name' => 'budget', 'type' => 'select', 'data_source' => 'manual', 'options' => ['Under 5,000', '5,000-10,000', '10,000-25,000', '25,000+'], 'step' => 3],
            ],
        ],
        'product_catalog' => [
            'name' => 'Products Catalog Filter Form',
            'slug' => 'products-catalog-filter',
            'fields' => [
                ['label' => 'Keyword', 'name' => 'keyword', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Category', 'name' => 'category', 'type' => 'select', 'data_source' => 'product_categories', 'options' => [], 'step' => 1],
                ['label' => 'Product', 'name' => 'product', 'type' => 'select', 'data_source' => 'products', 'options' => [], 'step' => 1],
                ['label' => 'Price Range', 'name' => 'price_range', 'type' => 'select', 'data_source' => 'manual', 'options' => ['Any', '0-100', '100-500', '500-1000', '1000+'], 'step' => 1],
                ['label' => 'In Stock Only', 'name' => 'in_stock_only', 'type' => 'checkbox', 'data_source' => 'manual', 'options' => ['Yes'], 'step' => 1],
            ],
        ],
        'new_user_customer' => [
            'name' => 'New User / Customer Multi-Step Form',
            'slug' => 'new-user-customer-form',
            'fields' => [
                ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Phone', 'name' => 'phone', 'type' => 'tel', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Country', 'name' => 'country', 'type' => 'select', 'data_source' => 'countries', 'options' => [], 'step' => 2],
                ['label' => 'Customer Type', 'name' => 'customer_type', 'type' => 'radio', 'data_source' => 'manual', 'options' => ['Private', 'Business'], 'step' => 2],
                ['label' => 'Account Type', 'name' => 'account_type', 'type' => 'select', 'data_source' => 'user_roles', 'options' => [], 'step' => 2],
                ['label' => 'Interests', 'name' => 'interests', 'type' => 'checkbox', 'data_source' => 'manual', 'options' => ['Products', 'Support', 'Services', 'Offers'], 'step' => 3],
                ['label' => 'Notes', 'name' => 'notes', 'type' => 'textarea', 'data_source' => 'manual', 'options' => [], 'step' => 3],
            ],
        ],
        'registration' => [
            'name' => 'Registration / Sign Up Form',
            'slug' => 'registration-sign-up-form',
            'fields' => [
                ['label' => 'Username', 'name' => 'username', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Password', 'name' => 'password', 'type' => 'password', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Country', 'name' => 'country', 'type' => 'select', 'data_source' => 'countries', 'options' => [], 'step' => 2],
            ],
        ],
        'newsletter' => [
            'name' => 'Newsletter Signup Form',
            'slug' => 'newsletter-signup-form',
            'fields' => [
                ['label' => 'Full Name', 'name' => 'full_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Topics', 'name' => 'topics', 'type' => 'checkbox', 'data_source' => 'manual', 'options' => ['News', 'Products', 'Offers', 'Guides'], 'step' => 1],
            ],
        ],
        'support' => [
            'name' => 'Support Request Form',
            'slug' => 'support-request-form',
            'fields' => [
                ['label' => 'Full Name', 'name' => 'full_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Priority', 'name' => 'priority', 'type' => 'radio', 'data_source' => 'manual', 'options' => ['Low', 'Medium', 'High'], 'step' => 1],
                ['label' => 'Issue Type', 'name' => 'issue_type', 'type' => 'select', 'data_source' => 'manual', 'options' => ['Billing', 'Technical', 'Access', 'Other'], 'step' => 2],
                ['label' => 'Issue Details', 'name' => 'issue_details', 'type' => 'textarea', 'data_source' => 'manual', 'options' => [], 'step' => 2],
            ],
        ],
        'quote' => [
            'name' => 'Quote Request Multi-Step Form',
            'slug' => 'quote-request-form',
            'fields' => [
                ['label' => 'Contact Name', 'name' => 'contact_name', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Company', 'name' => 'company', 'type' => 'text', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'data_source' => 'manual', 'options' => [], 'step' => 1],
                ['label' => 'Project Type', 'name' => 'project_type', 'type' => 'checkbox', 'data_source' => 'manual', 'options' => ['Website', 'WooCommerce', 'Marketplace', 'Maintenance', 'SEO'], 'step' => 2],
                ['label' => 'Budget', 'name' => 'budget', 'type' => 'select', 'data_source' => 'manual', 'options' => ['Under 5,000', '5,000-10,000', '10,000-25,000', '25,000+'], 'step' => 2],
                ['label' => 'Brief', 'name' => 'brief', 'type' => 'textarea', 'data_source' => 'manual', 'options' => [], 'step' => 3],
            ],
        ],
    ];
}

function storz_insert_form_template($template) {
    global $wpdb;
    if (empty($template['name']) || empty($template['slug']) || empty($template['fields']) || !is_array($template['fields'])) {
        return false;
    }

    $table = $wpdb->prefix . 'storz_forms';
    $existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$table} WHERE slug = %s LIMIT 1", sanitize_title($template['slug'])));
    if ($existing) {
        return false;
    }

    return (bool) $wpdb->insert($table, [
        'name' => sanitize_text_field($template['name']),
        'slug' => sanitize_title($template['slug']),
        'fields' => wp_json_encode($template['fields']),
        'settings' => wp_json_encode([
            'ajax' => false,
            'store_submissions' => true,
            'template' => true,
        ]),
    ]);
}

function storz_insert_prebuilt_forms() {
    $templates = storz_get_prebuilt_form_templates();
    $inserted = 0;
    foreach ($templates as $template) {
        if (storz_insert_form_template($template)) {
            $inserted++;
        }
    }
    return $inserted;
}

function storz_maybe_seed_prebuilt_forms() {
    if (get_option('storz_prebuilt_forms_seeded')) {
        return;
    }
    storz_insert_prebuilt_forms();
    update_option('storz_prebuilt_forms_seeded', 1);
}
add_action('after_switch_theme', 'storz_maybe_seed_prebuilt_forms', 20);

function storz_handle_form_delete_action() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['page'], $_GET['action'], $_GET['form_id']) || $_GET['page'] !== 'storz-forms' || $_GET['action'] !== 'delete') {
        return;
    }

    check_admin_referer('storz_delete_form_' . (int) $_GET['form_id']);
    global $wpdb;
    $forms_table = $wpdb->prefix . 'storz_forms';
    $submissions_table = $wpdb->prefix . 'storz_form_submissions';
    $form_id = (int) $_GET['form_id'];

    $wpdb->delete($submissions_table, ['form_id' => $form_id], ['%d']);
    $wpdb->delete($forms_table, ['id' => $form_id], ['%d']);

    wp_safe_redirect(admin_url('admin.php?page=storz-forms&message=deleted'));
    exit;
}
add_action('admin_init', 'storz_handle_form_delete_action');


/**
 * Handle JSON export for one form from the All Forms table.
 */
function storz_handle_form_export_action() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['page'], $_GET['action'], $_GET['form_id']) || $_GET['page'] !== 'storz-forms' || $_GET['action'] !== 'export') {
        return;
    }

    check_admin_referer('storz_export_form_' . (int) $_GET['form_id']);
    $payload = function_exists('storz_get_form_export_payload') ? storz_get_form_export_payload((int) $_GET['form_id']) : false;
    if (!$payload) {
        wp_die('Form export failed.');
    }

    nocache_headers();
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="storz-form-' . sanitize_title($payload['form']['slug']) . '.json"');
    echo wp_json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}
add_action('admin_init', 'storz_handle_form_export_action');

/**
 * Handle JSON import from the STORZ Forms page.
 */
function storz_handle_form_import_action() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    if (!isset($_POST['storz_import_form'], $_POST['storz_import_nonce'])) {
        return;
    }

    check_admin_referer('storz_import_form', 'storz_import_nonce');

    if (empty($_FILES['storz_import_file']['tmp_name'])) {
        wp_safe_redirect(admin_url('admin.php?page=storz-forms&message=import-empty'));
        exit;
    }

    $json = file_get_contents($_FILES['storz_import_file']['tmp_name']);
    $payload = json_decode($json, true);
    $form_data = $payload['form'] ?? null;

    if (!is_array($form_data) || empty($form_data['name']) || empty($form_data['fields'])) {
        wp_safe_redirect(admin_url('admin.php?page=storz-forms&message=import-invalid'));
        exit;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'storz_forms';
    $base_slug = sanitize_title($form_data['slug'] ?? $form_data['name']);
    $slug = $base_slug;
    $i = 2;
    while ($wpdb->get_var($wpdb->prepare("SELECT id FROM {$table} WHERE slug = %s LIMIT 1", $slug))) {
        $slug = $base_slug . '-' . $i;
        $i++;
    }

    $fields = is_array($form_data['fields']) ? $form_data['fields'] : [];
    $settings = is_array($form_data['settings'] ?? null) ? $form_data['settings'] : [];

    $wpdb->insert($table, [
        'name' => sanitize_text_field($form_data['name']),
        'slug' => $slug,
        'fields' => wp_json_encode($fields),
        'settings' => wp_json_encode($settings),
    ], ['%s', '%s', '%s', '%s']);

    wp_safe_redirect(admin_url('admin.php?page=storz-forms&message=imported'));
    exit;
}
add_action('admin_init', 'storz_handle_form_import_action');

function storz_save_form_record($form_id = 0) {
    global $wpdb;
    $table = $wpdb->prefix . 'storz_forms';

    // Basic form identity. The slug is used by the [storz_form slug="..."] shortcode.
    $name = sanitize_text_field(wp_unslash($_POST['form_name'] ?? ''));
    $slug = sanitize_title(wp_unslash($_POST['form_slug'] ?? ''));

    // Fields are managed in JavaScript and saved as JSON for flexible form structures.
    $fields_raw = wp_unslash($_POST['fields_json'] ?? '[]');
    $fields = json_decode($fields_raw, true);
    if (!is_array($fields)) {
        $fields = [];
    }

    // Advanced options are kept in the existing settings JSON column to avoid DB migrations.
    $settings = [
        'ajax' => !empty($_POST['form_ajax']),
        'store_submissions' => true,
        'theme' => sanitize_key($_POST['form_theme'] ?? 'default'),
        'custom_css' => function_exists('storz_sanitize_form_custom_css') ? storz_sanitize_form_custom_css($_POST['form_custom_css'] ?? '') : '',
    ];

    $data = [
        'name' => $name,
        'slug' => $slug,
        'fields' => wp_json_encode($fields),
        'settings' => wp_json_encode($settings),
    ];

    if ($form_id > 0) {
        $wpdb->update($table, $data, ['id' => $form_id], ['%s', '%s', '%s', '%s'], ['%d']);
        return $form_id;
    }

    $wpdb->insert($table, $data, ['%s', '%s', '%s', '%s']);
    return (int) $wpdb->insert_id;
}

function storz_render_form_editor($mode = 'create', $form = null) {
    $form_name = $form ? $form->name : '';
    $form_slug = $form ? $form->slug : '';
    $fields_json = $form && !empty($form->fields) ? $form->fields : '[]';
    $settings = function_exists('storz_parse_form_settings') ? storz_parse_form_settings($form->settings ?? '') : ['theme' => 'default', 'custom_css' => '', 'ajax' => false];
    $themes = function_exists('storz_get_form_theme_presets') ? storz_get_form_theme_presets() : ['default' => 'Default'];
    ?>
    <form method="post" id="storz-form-editor">
        <?php wp_nonce_field($mode === 'edit' ? 'storz_update_form' : 'storz_save_form', 'storz_nonce'); ?>
        <table class="form-table">
            <tr>
                <th><label for="form_name">Form Name</label></th>
                <td><input type="text" name="form_name" id="form_name" class="regular-text" value="<?php echo esc_attr($form_name); ?>" required></td>
            </tr>
            <tr>
                <th><label for="form_slug">Form Slug</label></th>
                <td><input type="text" name="form_slug" id="form_slug" class="regular-text" value="<?php echo esc_attr($form_slug); ?>" required></td>
            </tr>
            <tr>
                <th><label for="form_theme">Form Theme</label></th>
                <td>
                    <select name="form_theme" id="form_theme">
                        <?php foreach ($themes as $theme_key => $theme_label) : ?>
                            <option value="<?php echo esc_attr($theme_key); ?>" <?php selected($settings['theme'], $theme_key); ?>><?php echo esc_html($theme_label); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="description">Preset styling for this form only. Global theme options still work.</p>
                </td>
            </tr>
            <tr>
                <th><label for="form_ajax">AJAX Preview Mode</label></th>
                <td>
                    <label><input type="checkbox" name="form_ajax" id="form_ajax" value="1" <?php checked(!empty($settings['ajax'])); ?>> Enable AJAX-friendly form setting</label>
                    <p class="description">Saved for future AJAX submissions. Live preview below already uses AJAX.</p>
                </td>
            </tr>
            <tr>
                <th><label for="form_custom_css">Custom CSS</label></th>
                <td>
                    <textarea name="form_custom_css" id="form_custom_css" class="large-text code" rows="10" placeholder="{{form}} input { border-color: #111827; }
{{form}} button { border-radius: 999px; }
"><?php echo esc_textarea($settings['custom_css']); ?></textarea>
                    <p class="description">Use <code>{{form}}</code> to target only this form instance.</p>
                </td>
            </tr>
        </table>

        <div class="storz-builder-layout">
            <div class="storz-builder-main">
                <div class="storz-builder-wrap">
                    <h2>Fields</h2>
                    <div id="storz-fields"></div>
                    <button type="button" class="button button-secondary" id="storz-add-field">Add Field</button>
                    <input type="hidden" name="fields_json" id="fields_json" value="<?php echo esc_attr($fields_json); ?>">
                </div>
            </div>
            <div class="storz-builder-preview-panel">
                <h2>Live Preview</h2>
                <p class="description">Updates through AJAX without saving the form.</p>
                <button type="button" class="button" id="storz-refresh-preview">Refresh Preview</button>
                <div id="storz-live-preview" class="storz-live-preview"><p>Preview will load here.</p></div>
            </div>
        </div>

        <p class="submit">
            <button type="submit" name="<?php echo $mode === 'edit' ? 'storz_update_form' : 'storz_save_form'; ?>" class="button button-primary"><?php echo $mode === 'edit' ? 'Update Form' : 'Save Form'; ?></button>
        </p>
    </form>
    <?php
}

function storz_forms_page() {
    if (
        isset($_POST['storz_install_prebuilt_forms'], $_POST['storz_templates_nonce']) &&
        current_user_can('manage_options') &&
        wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['storz_templates_nonce'])), 'storz_install_prebuilt_forms')
    ) {
        $inserted = storz_insert_prebuilt_forms();
        echo '<div class="updated"><p>' . ($inserted > 0 ? 'Installed ' . (int) $inserted . ' prebuilt forms.' : 'All prebuilt forms are already installed.') . '</p></div>';
    }

    if (
        isset($_POST['storz_install_prebuilt_pages'], $_POST['storz_pages_nonce']) &&
        current_user_can('manage_options') &&
        wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['storz_pages_nonce'])), 'storz_install_prebuilt_pages')
    ) {
        $inserted_pages = storz_insert_prebuilt_pages();
        echo '<div class="updated"><p>' . ($inserted_pages > 0 ? 'Installed ' . (int) $inserted_pages . ' prebuilt pages.' : 'All prebuilt pages are already installed.') . '</p></div>';
    }

    if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
        echo '<div class="updated"><p>Form deleted.</p></div>';
    }
    if (isset($_GET['message']) && $_GET['message'] === 'updated') {
        echo '<div class="updated"><p>Form updated.</p></div>';
    }
    if (isset($_GET['message']) && $_GET['message'] === 'imported') {
        echo '<div class="updated"><p>Form imported.</p></div>';
    }
    if (isset($_GET['message']) && $_GET['message'] === 'import-empty') {
        echo '<div class="error"><p>Please choose a JSON file to import.</p></div>';
    }
    if (isset($_GET['message']) && $_GET['message'] === 'import-invalid') {
        echo '<div class="error"><p>Invalid STORZ form JSON.</p></div>';
    }

    $forms = storz_get_forms();
    $templates = storz_get_prebuilt_form_templates();
    ?>
    <div class="wrap">
        <h1>STORZ Forms <a href="<?php echo esc_url(admin_url('admin.php?page=storz-add-form')); ?>" class="page-title-action">Add New</a></h1>

        <div class="notice notice-info" style="padding:12px 16px; margin:16px 0;">
            <p style="margin:0 0 10px;"><strong>Prebuilt forms and pages included in V2.1.</strong></p>
            <form method="post" style="display:inline-block; margin:0 12px 0 0;">
                <?php wp_nonce_field('storz_install_prebuilt_forms', 'storz_templates_nonce'); ?>
                <button type="submit" name="storz_install_prebuilt_forms" class="button button-secondary">Install Prebuilt Forms</button>
            </form>
            <form method="post" style="display:inline-block; margin:0;">
                <?php wp_nonce_field('storz_install_prebuilt_pages', 'storz_pages_nonce'); ?>
                <button type="submit" name="storz_install_prebuilt_pages" class="button button-secondary">Install Prebuilt Pages</button><p class="description">For industry-specific demo content use the new <strong>STORZ → Installers</strong> page.</p>
            </form>
        </div>

        <div class="storz-import-box">
            <h2>Import / Export Forms</h2>
            <form method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('storz_import_form', 'storz_import_nonce'); ?>
                <input type="file" name="storz_import_file" accept="application/json,.json" required>
                <button type="submit" name="storz_import_form" class="button button-secondary">Import Form JSON</button>
            </form>
            <p class="description">Use Export in the Actions column to download a portable JSON backup of a form.</p>
        </div>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Shortcode</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($forms) : foreach ($forms as $form) :
                $edit_url = admin_url('admin.php?page=storz-edit-form&form_id=' . (int) $form->id);
                $delete_url = wp_nonce_url(admin_url('admin.php?page=storz-forms&action=delete&form_id=' . (int) $form->id), 'storz_delete_form_' . (int) $form->id);
                $export_url = wp_nonce_url(admin_url('admin.php?page=storz-forms&action=export&form_id=' . (int) $form->id), 'storz_export_form_' . (int) $form->id);
            ?>
                <tr>
                    <td><?php echo (int) $form->id; ?></td>
                    <td><?php echo esc_html($form->name); ?></td>
                    <td><?php echo esc_html($form->slug); ?></td>
                    <td>[storz_form id="<?php echo (int) $form->id; ?>"]<br>[storz_form slug="<?php echo esc_attr($form->slug); ?>"]</td>
                    <td>
                        <a class="button button-small" href="<?php echo esc_url($edit_url); ?>">Edit</a>
                        <a class="button button-small" href="<?php echo esc_url($export_url); ?>">Export</a>
                        <a class="button button-small button-link-delete" href="<?php echo esc_url($delete_url); ?>" onclick="return confirm('Delete this form and its submissions?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; else : ?>
                <tr><td colspan="5">No forms found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <h2 style="margin-top:24px;">Template Summary</h2>
        <ul>
            <?php foreach ($templates as $template) : ?>
                <li><strong><?php echo esc_html($template['name']); ?></strong> — <?php echo esc_html($template['slug']); ?> (<?php echo count($template['fields']); ?> fields)</li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

function storz_add_form_page() {
    if (isset($_POST['storz_save_form'], $_POST['storz_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['storz_nonce'])), 'storz_save_form')) {
        storz_save_form_record();
        echo '<div class="updated"><p>Form saved.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Create STORZ Form</h1>
        <p>You can create your own form here, or install the prebuilt templates from the <strong>STORZ Forms</strong> page.</p>
        <?php storz_render_form_editor('create'); ?>
    </div>
    <?php
}

function storz_edit_form_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $form_id = isset($_GET['form_id']) ? (int) $_GET['form_id'] : 0;
    $form = storz_get_form($form_id);

    if (!$form) {
        echo '<div class="wrap"><h1>Edit STORZ Form</h1><p>Form not found.</p></div>';
        return;
    }

    if (isset($_POST['storz_update_form'], $_POST['storz_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['storz_nonce'])), 'storz_update_form')) {
        storz_save_form_record($form_id);
        wp_safe_redirect(admin_url('admin.php?page=storz-forms&message=updated'));
        exit;
    }
    ?>
    <div class="wrap">
        <h1>Edit STORZ Form</h1>
        <?php storz_render_form_editor('edit', $form); ?>
    </div>
    <?php
}
