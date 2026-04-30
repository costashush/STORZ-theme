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

function storz_has_logo_shadow() {
    return (bool) storz_get_option_value('show_logo_shadow', 0);
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
    $value = storz_get_option_value('form_background_style', 'transparent');
    return in_array($value, ['transparent', 'card', 'glass'], true) ? $value : 'transparent';
}

function storz_get_page_shell_style() {
    $value = storz_get_option_value('page_shell_style', 'transparent');
    return in_array($value, ['transparent', 'card', 'glass'], true) ? $value : 'transparent';
}

function storz_get_form_width() {
    return absint(storz_get_option_value('form_max_width', 980));
}

function storz_get_content_width() {
    return absint(storz_get_option_value('content_max_width', 1440));
}

function storz_get_content_align() {
    $value = storz_get_option_value('content_align', 'right');
    return in_array($value, ['left', 'center', 'right'], true) ? $value : 'right';
}

function storz_get_background_mode() {
    $value = storz_get_option_value('background_mode', 'image');
    return in_array($value, ['solid', 'gradient', 'image', 'image-gradient'], true) ? $value : 'image';
}

function storz_get_shadow_style() {
    $value = storz_get_option_value('shadow_style', 'soft');
    return in_array($value, ['none', 'soft', 'strong'], true) ? $value : 'soft';
}

function storz_get_button_style() {
    $value = storz_get_option_value('button_style', 'rounded');
    return in_array($value, ['rounded', 'pill'], true) ? $value : 'rounded';
}

function storz_get_background_image() {
    return storz_get_option_value('background_image', STORZ_THEME_URI . '/assets/storz.png');
}

function storz_body_classes($classes) {
    $classes[] = 'storz-form-style-' . sanitize_html_class(storz_get_form_background_style());
    $classes[] = 'storz-shell-style-' . sanitize_html_class(storz_get_page_shell_style());
    $classes[] = 'storz-align-' . sanitize_html_class(storz_get_content_align());
    $classes[] = 'storz-bg-' . sanitize_html_class(storz_get_background_mode());
    $classes[] = 'storz-shadow-' . sanitize_html_class(storz_get_shadow_style());
    $classes[] = 'storz-button-' . sanitize_html_class(storz_get_button_style());
    if (storz_has_logo_shadow()) {
        $classes[] = 'storz-logo-shadow';
    }
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


function storz_get_border_width($side) {
    $allowed = ['top', 'right', 'bottom', 'left'];
    if (!in_array($side, $allowed, true)) {
        return 0;
    }
    return max(0, min(24, absint(storz_get_option_value('border_' . $side . '_width', 0))));
}

function storz_get_border_style() {
    $value = storz_get_option_value('border_style', 'solid');
    return in_array($value, ['none', 'solid', 'dashed', 'dotted'], true) ? $value : 'solid';
}

function storz_parse_external_urls($raw) {
    if (is_array($raw)) {
        $raw = implode("
", $raw);
    }
    $lines = preg_split('/
|
|
/', (string) $raw);
    $urls = [];

    foreach ($lines as $line) {
        $url = esc_url_raw(trim($line), ['http', 'https']);
        if (!empty($url)) {
            $urls[] = $url;
        }
    }

    return array_values(array_unique($urls));
}


function storz_get_input_text_color() {
    return storz_get_option_value('input_text_color', '#1f2937');
}
