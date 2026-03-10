<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_option_value($key, $default = '') {
    $options = get_option('storz_theme_options', []);
    return $options[$key] ?? $default;
}

function storz_get_default_country_options() {
    return ['Israel', 'USA', 'Germany', 'France', 'Bulgaria', 'UK', 'Canada'];
}

function storz_is_header_enabled() {
    return (bool) storz_get_option_value('show_header', 1);
}

function storz_is_footer_enabled() {
    return (bool) storz_get_option_value('show_footer', 0);
}

function storz_is_search_enabled() {
    return (bool) storz_get_option_value('show_search', 1);
}

function storz_is_header_text_enabled() {
    return (bool) storz_get_option_value('show_header_text', 1);
}

function storz_get_header_text() {
    return storz_get_option_value('header_text', get_bloginfo('description'));
}

function storz_get_logo_markup() {
    if (function_exists('the_custom_logo') && has_custom_logo()) {
        return get_custom_logo();
    }

    return '<div class="site-logo-fallback">' . esc_html(storz_get_option_value('brand_title', get_bloginfo('name'))) . '</div>';
}



function storz_get_form_background_style() {
    return storz_get_option_value('form_background_style', 'transparent');
}

function storz_get_page_shell_style() {
    return storz_get_option_value('page_shell_style', 'transparent');
}

function storz_get_form_width() {
    return absint(storz_get_option_value('form_max_width', 620));
}

function storz_body_classes($classes) {
    $classes[] = 'storz-form-style-' . sanitize_html_class(storz_get_form_background_style());
    $classes[] = 'storz-shell-style-' . sanitize_html_class(storz_get_page_shell_style());
    return $classes;
}
add_filter('body_class', 'storz_body_classes');

function storz_get_form_step_groups($fields) {
    $steps = [];

    foreach ($fields as $index => $field) {
        $step_number = isset($field['step']) ? max(1, (int) $field['step']) : 1;
        if (!isset($steps[$step_number])) {
            $steps[$step_number] = [];
        }
        $steps[$step_number][] = ['index' => $index, 'field' => $field];
    }

    ksort($steps);
    return $steps;
}
