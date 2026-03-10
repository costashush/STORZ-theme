<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_install_tables() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();
    $forms_table = $wpdb->prefix . 'storz_forms';
    $submissions_table = $wpdb->prefix . 'storz_form_submissions';

    $sql_forms = "CREATE TABLE $forms_table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(200) NOT NULL,
        fields LONGTEXT NOT NULL,
        settings LONGTEXT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY slug (slug)
    ) $charset_collate;";

    $sql_submissions = "CREATE TABLE $submissions_table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        form_id BIGINT UNSIGNED NOT NULL,
        submitted_data LONGTEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY form_id (form_id)
    ) $charset_collate;";

    dbDelta($sql_forms);
    dbDelta($sql_submissions);
}
add_action('after_switch_theme', 'storz_install_tables');
