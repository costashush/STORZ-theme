<?php
if (!defined('ABSPATH')) {
    exit;
}

define('STORZ_THEME_VERSION', '2.2.1');
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
require_once STORZ_THEME_DIR . '/inc/shortcodes.php';
require_once STORZ_THEME_DIR . '/inc/submissions.php';
require_once STORZ_THEME_DIR . '/inc/demo-content.php';
require_once STORZ_THEME_DIR . '/inc/patterns.php';
