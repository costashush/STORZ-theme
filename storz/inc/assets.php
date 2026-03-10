<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_enqueue_assets() {
    wp_enqueue_style('storz-main', get_stylesheet_uri(), [], STORZ_THEME_VERSION);
    wp_enqueue_style('storz-theme', STORZ_THEME_URI . '/assets/css/theme.css', [], STORZ_THEME_VERSION);
    wp_enqueue_style('storz-form', STORZ_THEME_URI . '/assets/css/form.css', [], STORZ_THEME_VERSION);
    wp_enqueue_script('storz-frontend-form', STORZ_THEME_URI . '/assets/js/frontend-form.js', ['jquery'], STORZ_THEME_VERSION, true);

    $primary_color = storz_get_option_value('primary_color', '#111827');
    $form_width = storz_get_form_width();
    $custom_css = ':root{--storz-primary:' . esc_attr($primary_color) . ';--storz-form-max-width:' . absint($form_width) . 'px;}';
    wp_add_inline_style('storz-theme', $custom_css);
}
add_action('wp_enqueue_scripts', 'storz_enqueue_assets');

function storz_admin_assets($hook) {
    if (strpos($hook, 'storz') === false) {
        return;
    }

    wp_enqueue_style('storz-admin', STORZ_THEME_URI . '/assets/css/admin.css', [], STORZ_THEME_VERSION);
    wp_enqueue_script('storz-admin-builder', STORZ_THEME_URI . '/assets/js/admin-form-builder.js', ['jquery'], STORZ_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'storz_admin_assets');
