<?php
if (!defined('ABSPATH')) {
    exit;
}

define('STORZ_THEME_VERSION', '2.8.0');
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
