<?php
if (!defined('ABSPATH')) {
    exit;
}

define('STORZ_THEME_VERSION', '2.9.0');
define('STORZ_THEME_DIR', get_template_directory());
define('STORZ_THEME_URI', get_template_directory_uri());

require_once STORZ_THEME_DIR . '/inc/setup.php';
require_once STORZ_THEME_DIR . '/inc/assets.php';
require_once STORZ_THEME_DIR . '/inc/helpers.php';
require_once STORZ_THEME_DIR . '/inc/database.php';
require_once STORZ_THEME_DIR . '/inc/admin-menu.php';
require_once STORZ_THEME_DIR . '/inc/theme-options.php';
require_once STORZ_THEME_DIR . '/inc/data-sources.php';
require_once STORZ_THEME_DIR . '/inc/form-builder.php';
require_once STORZ_THEME_DIR . '/inc/form-enhancements.php';
require_once STORZ_THEME_DIR . '/inc/shortcodes.php';
require_once STORZ_THEME_DIR . '/inc/submissions.php';
require_once STORZ_THEME_DIR . '/inc/demo-content.php';
require_once STORZ_THEME_DIR . '/inc/installers.php';
require_once STORZ_THEME_DIR . '/inc/patterns.php';

require_once STORZ_THEME_DIR . '/inc/widgets.php';


function storz_cleanup_appearance_menu() {
    remove_submenu_page('themes.php', 'widgets.php');
    remove_submenu_page('themes.php', 'site-editor.php?path=%2Fpatterns');
    remove_submenu_page('themes.php', 'site-editor.php?path=/patterns');
    remove_submenu_page('themes.php', 'edit.php?post_type=wp_block');
}
add_action('admin_menu', 'storz_cleanup_appearance_menu', 999);


/**
 * STORZ UI Upgrade assets.
 *
 * These styles are intentionally scoped with .storz-* selectors where possible
 * so they improve the theme UI without breaking existing WordPress/admin styles.
 */
function storz_ui_upgrade_assets() {
    wp_enqueue_style(
        'storz-ui-upgrade',
        get_template_directory_uri() . '/assets/css/storz-ui-upgrade.css',
        array(),
        defined('STORZ_THEME_VERSION') ? STORZ_THEME_VERSION : '2.9.0'
    );

    wp_enqueue_script(
        'storz-ui-upgrade',
        get_template_directory_uri() . '/assets/js/storz-ui-upgrade.js',
        array(),
        defined('STORZ_THEME_VERSION') ? STORZ_THEME_VERSION : '2.9.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'storz_ui_upgrade_assets');
add_action('admin_enqueue_scripts', 'storz_ui_upgrade_assets');



/**
 * Enqueue FormCraft-inspired UI layer for STORZ.
 *
 * This keeps the STORZ builder/features intact and only adds the visual skin.
 */
function storz_formcraft_ui_assets() {
    wp_enqueue_style(
        'storz-formcraft-ui',
        get_template_directory_uri() . '/assets/css/storz-formcraft-ui.css',
        array('storz-ui-upgrade'),
        defined('STORZ_THEME_VERSION') ? STORZ_THEME_VERSION : '2.9.0'
    );

    wp_enqueue_script(
        'storz-formcraft-ui',
        get_template_directory_uri() . '/assets/js/storz-formcraft-ui.js',
        array(),
        defined('STORZ_THEME_VERSION') ? STORZ_THEME_VERSION : '2.9.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'storz_formcraft_ui_assets', 30);
add_action('admin_enqueue_scripts', 'storz_formcraft_ui_assets', 30);

