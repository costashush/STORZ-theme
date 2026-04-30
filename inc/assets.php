<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_enqueue_assets() {
    wp_enqueue_style('storz-main', get_stylesheet_uri(), [], STORZ_THEME_VERSION);
    wp_enqueue_style('storz-theme', STORZ_THEME_URI . '/assets/css/theme.css', [], STORZ_THEME_VERSION);
    wp_enqueue_style('storz-form', STORZ_THEME_URI . '/assets/css/form.css', [], STORZ_THEME_VERSION);
    wp_enqueue_script('storz-frontend-form', STORZ_THEME_URI . '/assets/js/frontend-form.js', ['jquery'], STORZ_THEME_VERSION, true);

    $font_urls = storz_parse_external_urls(storz_get_option_value('font_stylesheet_urls', ''));
    foreach ($font_urls as $index => $font_url) {
        wp_enqueue_style('storz-ext-font-' . $index, $font_url, [], null);
    }

    $script_urls = storz_parse_external_urls(storz_get_option_value('custom_script_urls', ''));
    foreach ($script_urls as $index => $script_url) {
        wp_enqueue_script('storz-ext-script-' . $index, $script_url, [], null, true);
    }

    $primary_color = storz_get_option_value('primary_color', '#111827');
    $secondary_color = storz_get_option_value('secondary_color', '#4f46e5');
    $accent_color = storz_get_option_value('accent_color', '#0ea5e9');
    $background_color = storz_get_option_value('background_color', '#f5f7fb');
    $text_color = storz_get_option_value('text_color', '#222222');
    $muted_text_color = storz_get_option_value('muted_text_color', '#6b7280');
    $card_color = storz_get_option_value('card_color', '#ffffff');
    $input_text_color = storz_get_input_text_color();
    $border_color = storz_get_option_value('border_color', '#dbe3ef');
    $gradient_start = storz_get_option_value('gradient_start', '#f5f7fb');
    $gradient_end = storz_get_option_value('gradient_end', '#e9eefb');
    $form_width = storz_get_form_width();
    $content_width = storz_get_content_width();
    $logo_max_width = absint(storz_get_option_value('logo_max_width', 220));
    $card_radius = absint(storz_get_option_value('card_radius', 20));
    $field_radius = absint(storz_get_option_value('field_radius', 12));
    $section_gap = absint(storz_get_option_value('section_gap', 24));
    $bg_image = esc_url(storz_get_background_image());
    $bg_size = sanitize_text_field(storz_get_option_value('background_size', 'cover'));
    $bg_position = sanitize_text_field(storz_get_option_value('background_position', 'center center'));
    $bg_repeat = sanitize_text_field(storz_get_option_value('background_repeat', 'no-repeat'));
    $bg_attachment = sanitize_text_field(storz_get_option_value('background_attachment', 'fixed'));
    $bg_overlay = absint(storz_get_option_value('background_overlay', 16)) / 100;
    $bg_blur = absint(storz_get_option_value('background_blur', 0));
    $border_style = storz_get_border_style();
    $border_top = storz_get_border_width('top');
    $border_right = storz_get_border_width('right');
    $border_bottom = storz_get_border_width('bottom');
    $border_left = storz_get_border_width('left');

    $custom_css = ':root{' .
        '--storz-primary:' . esc_attr($primary_color) . ';' .
        '--storz-secondary:' . esc_attr($secondary_color) . ';' .
        '--storz-accent:' . esc_attr($accent_color) . ';' .
        '--storz-bg:' . esc_attr($background_color) . ';' .
        '--storz-text:' . esc_attr($text_color) . ';' .
        '--storz-muted:' . esc_attr($muted_text_color) . ';' .
        '--storz-card:' . esc_attr($card_color) . ';' .
        '--storz-input-text:' . esc_attr($input_text_color) . ';' .
        '--storz-border:' . esc_attr($border_color) . ';' .
        '--storz-gradient-start:' . esc_attr($gradient_start) . ';' .
        '--storz-gradient-end:' . esc_attr($gradient_end) . ';' .
        '--storz-form-max-width:' . $form_width . 'px;' .
        '--storz-content-max-width:' . $content_width . 'px;' .
        '--storz-logo-max-width:' . $logo_max_width . 'px;' .
        '--storz-card-radius:' . $card_radius . 'px;' .
        '--storz-field-radius:' . $field_radius . 'px;' .
        '--storz-section-gap:' . $section_gap . 'px;' .
        '--storz-border-style:' . esc_attr($border_style) . ';' .
        '--storz-border-top:' . $border_top . 'px;' .
        '--storz-border-right:' . $border_right . 'px;' .
        '--storz-border-bottom:' . $border_bottom . 'px;' .
        '--storz-border-left:' . $border_left . 'px;' .
    '}';

    $custom_css .= 'body::before{background-image:url(' . $bg_image . ');background-size:' . esc_attr($bg_size) . ';background-position:' . esc_attr($bg_position) . ';background-repeat:' . esc_attr($bg_repeat) . ';background-attachment:' . esc_attr($bg_attachment) . ';opacity:1;filter:blur(' . $bg_blur . 'px);}';
    $custom_css .= 'body::after{background:rgba(255,255,255,' . $bg_overlay . ');}';

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
