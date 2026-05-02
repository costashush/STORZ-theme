<?php
/**
 * STORZ Form Enhancements
 *
 * This file keeps advanced form-builder features separate from the core builder UI.
 * Features included here:
 * - Form theme presets
 * - Per-form custom CSS helpers
 * - AJAX live preview
 * - JSON export/import helpers
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns visual theme presets available in the form builder.
 *
 * The selected key is saved inside the form `settings` JSON column so no DB migration
 * is needed when adding more themes later.
 */
function storz_get_form_theme_presets() {
    return [
        'default' => __('Default / Theme Global', 'storz'),
        'clean'   => __('Clean Minimal', 'storz'),
        'card'    => __('Card', 'storz'),
        'glass'   => __('Glass', 'storz'),
        'outline' => __('Outline', 'storz'),
        'dark'    => __('Dark', 'storz'),
    ];
}

/**
 * Decode form settings safely and merge with defaults.
 */
function storz_parse_form_settings($settings_json = '') {
    $settings = json_decode((string) $settings_json, true);
    if (!is_array($settings)) {
        $settings = [];
    }

    return wp_parse_args($settings, [
        'ajax' => false,
        'store_submissions' => true,
        'theme' => 'default',
        'custom_css' => '',
    ]);
}

/**
 * Sanitize custom CSS from the admin form builder.
 *
 * WordPress has no full CSS sanitizer for arbitrary admin CSS. We remove HTML tags
 * and dangerous at-rules/protocols while keeping normal CSS syntax usable.
 */
function storz_sanitize_form_custom_css($css) {
    $css = wp_unslash($css);
    $css = wp_strip_all_tags($css);
    $css = preg_replace('/@import\s+[^;]+;/i', '', $css);
    $css = preg_replace('/expression\s*\(/i', '', $css);
    $css = preg_replace('/javascript\s*:/i', '', $css);
    return trim($css);
}

/**
 * Build the inline CSS tag for one form instance.
 *
 * Tip for developers: use {{form}} in the custom CSS textarea to target only the
 * current form instance. Example: {{form}} input { border-color: red; }
 */
function storz_get_form_inline_css($instance_class, $settings) {
    $theme = isset($settings['theme']) ? sanitize_html_class($settings['theme']) : 'default';
    $custom_css = isset($settings['custom_css']) ? (string) $settings['custom_css'] : '';

    if ($custom_css === '') {
        return '';
    }

    $scoped_css = str_replace('{{form}}', '.' . $instance_class, $custom_css);

    return '<style id="' . esc_attr($instance_class) . '-custom-css">' . $scoped_css . "\n/* Active STORZ form theme: " . esc_html($theme) . " */\n</style>";
}

/**
 * Export a form as JSON for backup or moving between sites.
 */
function storz_get_form_export_payload($form_id) {
    $form = storz_get_form((int) $form_id);
    if (!$form) {
        return false;
    }

    return [
        'exporter' => 'storz-theme',
        'version' => defined('STORZ_THEME_VERSION') ? STORZ_THEME_VERSION : 'unknown',
        'exported_at' => gmdate('c'),
        'form' => [
            'name' => $form->name,
            'slug' => $form->slug,
            'fields' => json_decode($form->fields, true),
            'settings' => storz_parse_form_settings($form->settings),
        ],
    ];
}

/**
 * AJAX endpoint for live preview in the admin form builder.
 */
function storz_ajax_form_preview() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => __('Not allowed.', 'storz')], 403);
    }

    check_ajax_referer('storz_form_preview', 'nonce');

    $fields_raw = wp_unslash($_POST['fields_json'] ?? '[]');
    $fields = json_decode($fields_raw, true);
    if (!is_array($fields)) {
        $fields = [];
    }

    $settings = [
        'ajax' => !empty($_POST['ajax']),
        'store_submissions' => true,
        'theme' => sanitize_key($_POST['theme'] ?? 'default'),
        'custom_css' => storz_sanitize_form_custom_css($_POST['custom_css'] ?? ''),
    ];

    $preview_form = (object) [
        'id' => 0,
        'name' => sanitize_text_field(wp_unslash($_POST['form_name'] ?? 'Preview Form')),
        'slug' => 'preview-form',
        'fields' => wp_json_encode($fields),
        'settings' => wp_json_encode($settings),
    ];

    if (!function_exists('storz_render_form_markup')) {
        wp_send_json_error(['message' => __('Preview renderer is not available.', 'storz')], 500);
    }

    wp_send_json_success(['html' => storz_render_form_markup($preview_form, true)]);
}
add_action('wp_ajax_storz_form_preview', 'storz_ajax_form_preview');
