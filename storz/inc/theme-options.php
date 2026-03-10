<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_register_theme_settings() {
    register_setting('storz_theme_options_group', 'storz_theme_options', [
        'sanitize_callback' => 'storz_sanitize_theme_options',
    ]);
}
add_action('admin_init', 'storz_register_theme_settings');

function storz_sanitize_theme_options($input) {
    return [
        'brand_title'      => sanitize_text_field($input['brand_title'] ?? 'STORZ'),
        'brand_tagline'    => sanitize_text_field($input['brand_tagline'] ?? 'Advanced digital solutions'),
        'footer_text'      => sanitize_text_field($input['footer_text'] ?? 'Built by STORZ'),
        'header_text'      => sanitize_text_field($input['header_text'] ?? 'Smart forms and clean funnels'),
        'primary_color'    => sanitize_hex_color($input['primary_color'] ?? '#111827'),
        'show_header'      => !empty($input['show_header']) ? 1 : 0,
        'show_footer'      => !empty($input['show_footer']) ? 1 : 0,
        'show_search'      => !empty($input['show_search']) ? 1 : 0,
        'show_header_text' => !empty($input['show_header_text']) ? 1 : 0,
        'form_background_style' => in_array(($input['form_background_style'] ?? 'transparent'), ['transparent', 'card'], true) ? $input['form_background_style'] : 'transparent',
        'page_shell_style' => in_array(($input['page_shell_style'] ?? 'transparent'), ['transparent', 'card'], true) ? $input['page_shell_style'] : 'transparent',
        'form_max_width' => max(360, min(900, absint($input['form_max_width'] ?? 620))),
    ];
}

function storz_theme_options_page() {
    $options = get_option('storz_theme_options', []);
    ?>
    <div class="wrap">
        <h1>STORZ Theme Options</h1>
        <form method="post" action="options.php">
            <?php settings_fields('storz_theme_options_group'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="brand_title">Brand Title</label></th>
                    <td><input type="text" name="storz_theme_options[brand_title]" id="brand_title" value="<?php echo esc_attr($options['brand_title'] ?? 'STORZ'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="header_text">Header Text</label></th>
                    <td><input type="text" name="storz_theme_options[header_text]" id="header_text" value="<?php echo esc_attr($options['header_text'] ?? 'Smart forms and clean funnels'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="footer_text">Footer Text</label></th>
                    <td><input type="text" name="storz_theme_options[footer_text]" id="footer_text" value="<?php echo esc_attr($options['footer_text'] ?? 'Built by STORZ'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="primary_color">Primary Color</label></th>
                    <td><input type="color" name="storz_theme_options[primary_color]" id="primary_color" value="<?php echo esc_attr($options['primary_color'] ?? '#111827'); ?>"></td>
                </tr>
                <tr>
                    <th>Show Header</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_header]" value="1" <?php checked($options['show_header'] ?? 1, 1); ?>> Enable minimal logo header</label></td>
                </tr>
                <tr>
                    <th>Show Header Text</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_header_text]" value="1" <?php checked($options['show_header_text'] ?? 1, 1); ?>> Show text below logo</label></td>
                </tr>
                <tr>
                    <th>Show Search</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_search]" value="1" <?php checked($options['show_search'] ?? 1, 1); ?>> Show centered search module</label></td>
                </tr>
                <tr>
                    <th>Show Footer</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_footer]" value="1" <?php checked($options['show_footer'] ?? 0, 1); ?>> Show footer</label></td>
                </tr>
                <tr>
                    <th><label for="form_background_style">Form Background</label></th>
                    <td>
                        <select name="storz_theme_options[form_background_style]" id="form_background_style">
                            <option value="transparent" <?php selected($options['form_background_style'] ?? 'transparent', 'transparent'); ?>>Transparent</option>
                            <option value="card" <?php selected($options['form_background_style'] ?? 'transparent', 'card'); ?>>Card / White Box</option>
                        </select>
                        <p class="description">Controls the form box style.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="page_shell_style">Page Content Background</label></th>
                    <td>
                        <select name="storz_theme_options[page_shell_style]" id="page_shell_style">
                            <option value="transparent" <?php selected($options['page_shell_style'] ?? 'transparent', 'transparent'); ?>>Transparent</option>
                            <option value="card" <?php selected($options['page_shell_style'] ?? 'transparent', 'card'); ?>>Card / White Box</option>
                        </select>
                        <p class="description">Use transparent mode for a cleaner centered form page.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="form_max_width">Form Max Width</label></th>
                    <td>
                        <input type="number" min="360" max="900" step="10" name="storz_theme_options[form_max_width]" id="form_max_width" value="<?php echo esc_attr($options['form_max_width'] ?? 620); ?>"> px
                        <p class="description">Recommended 560-680 for centered forms.</p>
                    </td>
                </tr>
            </table>
            <p>You can upload the logo from <strong>Appearance → Customize → Site Identity</strong>.</p>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
