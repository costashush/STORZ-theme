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
    $background_image = esc_url_raw($input['background_image'] ?? '');
    if (empty($background_image)) {
        $background_image = STORZ_THEME_URI . '/assets/storz.png';
    }

    return [
        'brand_title'           => sanitize_text_field($input['brand_title'] ?? 'STORZ'),
        'footer_text'           => sanitize_text_field($input['footer_text'] ?? 'Built by STORZ'),
        'header_text'           => sanitize_text_field($input['header_text'] ?? 'Smart forms and clean funnels'),
        'primary_color'         => sanitize_hex_color($input['primary_color'] ?? '#111827'),
        'secondary_color'       => sanitize_hex_color($input['secondary_color'] ?? '#4f46e5'),
        'accent_color'          => sanitize_hex_color($input['accent_color'] ?? '#0ea5e9'),
        'background_color'      => sanitize_hex_color($input['background_color'] ?? '#f5f7fb'),
        'text_color'            => sanitize_hex_color($input['text_color'] ?? '#222222'),
        'muted_text_color'      => sanitize_hex_color($input['muted_text_color'] ?? '#6b7280'),
        'card_color'            => sanitize_hex_color($input['card_color'] ?? '#ffffff'),
        'input_text_color'      => sanitize_hex_color($input['input_text_color'] ?? '#1f2937'),
        'border_color'          => sanitize_hex_color($input['border_color'] ?? '#dbe3ef'),
        'gradient_start'        => sanitize_hex_color($input['gradient_start'] ?? '#f5f7fb'),
        'gradient_end'          => sanitize_hex_color($input['gradient_end'] ?? '#e9eefb'),
        'background_mode'       => in_array(($input['background_mode'] ?? 'image'), ['solid', 'gradient', 'image', 'image-gradient'], true) ? $input['background_mode'] : 'image',
        'show_header'           => !empty($input['show_header']) ? 1 : 0,
        'show_footer'           => !empty($input['show_footer']) ? 1 : 0,
        'show_search'           => !empty($input['show_search']) ? 1 : 0,
        'show_header_text'      => !empty($input['show_header_text']) ? 1 : 0,
        'show_logo_shadow'      => !empty($input['show_logo_shadow']) ? 1 : 0,
        'form_background_style' => in_array(($input['form_background_style'] ?? 'transparent'), ['transparent', 'card', 'glass'], true) ? $input['form_background_style'] : 'transparent',
        'page_shell_style'      => in_array(($input['page_shell_style'] ?? 'transparent'), ['transparent', 'card', 'glass'], true) ? $input['page_shell_style'] : 'transparent',
        'content_align'         => in_array(($input['content_align'] ?? 'right'), ['left', 'center', 'right'], true) ? $input['content_align'] : 'right',
        'shadow_style'          => in_array(($input['shadow_style'] ?? 'soft'), ['none', 'soft', 'strong'], true) ? $input['shadow_style'] : 'soft',
        'button_style'          => in_array(($input['button_style'] ?? 'rounded'), ['rounded', 'pill'], true) ? $input['button_style'] : 'rounded',
        'form_max_width'        => max(360, min(1400, absint($input['form_max_width'] ?? 980))),
        'content_max_width'     => max(800, min(1800, absint($input['content_max_width'] ?? 1440))),
        'logo_max_width'        => max(80, min(420, absint($input['logo_max_width'] ?? 220))),
        'card_radius'           => max(0, min(60, absint($input['card_radius'] ?? 20))),
        'field_radius'          => max(0, min(60, absint($input['field_radius'] ?? 12))),
        'section_gap'           => max(0, min(80, absint($input['section_gap'] ?? 24))),
        'background_image'      => $background_image,
        'background_size'       => in_array(($input['background_size'] ?? 'cover'), ['cover', 'contain', 'auto'], true) ? $input['background_size'] : 'cover',
        'background_position'   => sanitize_text_field($input['background_position'] ?? 'center center'),
        'background_repeat'     => in_array(($input['background_repeat'] ?? 'no-repeat'), ['no-repeat', 'repeat', 'repeat-x', 'repeat-y'], true) ? $input['background_repeat'] : 'no-repeat',
        'background_attachment' => in_array(($input['background_attachment'] ?? 'fixed'), ['scroll', 'fixed'], true) ? $input['background_attachment'] : 'fixed',
        'background_overlay'    => max(0, min(90, absint($input['background_overlay'] ?? 16))),
        'background_blur'       => max(0, min(20, absint($input['background_blur'] ?? 0))),
        'border_style'          => in_array(($input['border_style'] ?? 'solid'), ['none', 'solid', 'dashed', 'dotted'], true) ? $input['border_style'] : 'solid',
        'border_top_width'      => max(0, min(24, absint($input['border_top_width'] ?? 0))),
        'border_right_width'    => max(0, min(24, absint($input['border_right_width'] ?? 0))),
        'border_bottom_width'   => max(0, min(24, absint($input['border_bottom_width'] ?? 0))),
        'border_left_width'     => max(0, min(24, absint($input['border_left_width'] ?? 0))),
        'font_stylesheet_urls'  => implode("\n", storz_parse_external_urls($input['font_stylesheet_urls'] ?? '')),
        'custom_script_urls'    => implode("\n", storz_parse_external_urls($input['custom_script_urls'] ?? '')),
    ];
}

function storz_theme_options_page() {
    $options = get_option('storz_theme_options', []);
    $default_bg = STORZ_THEME_URI . '/assets/storz.png';
    ?>
    <div class="wrap">
        <h1>STORZ Design Options</h1>
        <form method="post" action="options.php">
            <?php settings_fields('storz_theme_options_group'); ?>

            <h2>Brand</h2>
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
                    <th><label for="logo_max_width">Logo Max Width</label></th>
                    <td><input type="number" min="80" max="420" step="10" name="storz_theme_options[logo_max_width]" id="logo_max_width" value="<?php echo esc_attr($options['logo_max_width'] ?? 220); ?>"> px</td>
                </tr>
                <tr>
                    <th>Logo Shadow</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_logo_shadow]" value="1" <?php checked($options['show_logo_shadow'] ?? 0, 1); ?>> Add a subtle shadow under the logo image</label></td>
                </tr>
            </table>

            <h2>Layout</h2>
            <table class="form-table">
                <tr>
                    <th>Show Header</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_header]" value="1" <?php checked($options['show_header'] ?? 1, 1); ?>> Enable minimal logo header</label></td>
                </tr>
                <tr>
                    <th>Show Header Text</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_header_text]" value="1" <?php checked($options['show_header_text'] ?? 1, 1); ?>> Show optional text below logo</label></td>
                </tr>
                <tr>
                    <th>Show Search</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_search]" value="1" <?php checked($options['show_search'] ?? 1, 1); ?>> Show search module</label></td>
                </tr>
                <tr>
                    <th>Show Footer</th>
                    <td><label><input type="checkbox" name="storz_theme_options[show_footer]" value="1" <?php checked($options['show_footer'] ?? 0, 1); ?>> Show footer</label></td>
                </tr>
                <tr>
                    <th><label for="content_align">Content Alignment</label></th>
                    <td>
                        <select name="storz_theme_options[content_align]" id="content_align">
                            <option value="center" <?php selected($options['content_align'] ?? 'right', 'center'); ?>>Center</option>
                            <option value="left" <?php selected($options['content_align'] ?? 'right', 'left'); ?>>Left</option>
                            <option value="right" <?php selected($options['content_align'] ?? 'right', 'right'); ?>>Right</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="form_max_width">Form Max Width</label></th>
                    <td><input type="number" min="360" max="1400" step="10" name="storz_theme_options[form_max_width]" id="form_max_width" value="<?php echo esc_attr($options['form_max_width'] ?? 980); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="content_max_width">Content Max Width</label></th>
                    <td><input type="number" min="800" max="1800" step="10" name="storz_theme_options[content_max_width]" id="content_max_width" value="<?php echo esc_attr($options['content_max_width'] ?? 1440); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="section_gap">Section Gap</label></th>
                    <td><input type="number" min="0" max="80" step="2" name="storz_theme_options[section_gap]" id="section_gap" value="<?php echo esc_attr($options['section_gap'] ?? 24); ?>"> px</td>
                </tr>
            </table>

            <h2>Background</h2>
            <table class="form-table">
                <tr>
                    <th><label for="background_mode">Background Mode</label></th>
                    <td>
                        <select name="storz_theme_options[background_mode]" id="background_mode">
                            <option value="image" <?php selected($options['background_mode'] ?? 'image', 'image'); ?>>Image</option>
                            <option value="image-gradient" <?php selected($options['background_mode'] ?? 'image', 'image-gradient'); ?>>Image + Gradient</option>
                            <option value="gradient" <?php selected($options['background_mode'] ?? 'image', 'gradient'); ?>>Gradient</option>
                            <option value="solid" <?php selected($options['background_mode'] ?? 'image', 'solid'); ?>>Solid</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="background_image">Background Image URL</label></th>
                    <td>
                        <input type="url" name="storz_theme_options[background_image]" id="background_image" value="<?php echo esc_attr($options['background_image'] ?? $default_bg); ?>" class="regular-text code">
                        <p class="description">Default image is the STORZ image you sent.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="background_size">Background Size</label></th>
                    <td>
                        <select name="storz_theme_options[background_size]" id="background_size">
                            <option value="cover" <?php selected($options['background_size'] ?? 'cover', 'cover'); ?>>Cover</option>
                            <option value="contain" <?php selected($options['background_size'] ?? 'cover', 'contain'); ?>>Contain</option>
                            <option value="auto" <?php selected($options['background_size'] ?? 'cover', 'auto'); ?>>Auto</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="background_position">Background Position</label></th>
                    <td><input type="text" name="storz_theme_options[background_position]" id="background_position" value="<?php echo esc_attr($options['background_position'] ?? 'center center'); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="background_repeat">Background Repeat</label></th>
                    <td>
                        <select name="storz_theme_options[background_repeat]" id="background_repeat">
                            <option value="no-repeat" <?php selected($options['background_repeat'] ?? 'no-repeat', 'no-repeat'); ?>>No repeat</option>
                            <option value="repeat" <?php selected($options['background_repeat'] ?? 'no-repeat', 'repeat'); ?>>Repeat</option>
                            <option value="repeat-x" <?php selected($options['background_repeat'] ?? 'no-repeat', 'repeat-x'); ?>>Repeat X</option>
                            <option value="repeat-y" <?php selected($options['background_repeat'] ?? 'no-repeat', 'repeat-y'); ?>>Repeat Y</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="background_attachment">Background Attachment</label></th>
                    <td>
                        <select name="storz_theme_options[background_attachment]" id="background_attachment">
                            <option value="fixed" <?php selected($options['background_attachment'] ?? 'fixed', 'fixed'); ?>>Fixed</option>
                            <option value="scroll" <?php selected($options['background_attachment'] ?? 'fixed', 'scroll'); ?>>Scroll</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="background_overlay">Background Overlay</label></th>
                    <td><input type="number" min="0" max="90" step="1" name="storz_theme_options[background_overlay]" id="background_overlay" value="<?php echo esc_attr($options['background_overlay'] ?? 16); ?>"> %</td>
                </tr>
                <tr>
                    <th><label for="background_blur">Background Blur</label></th>
                    <td><input type="number" min="0" max="20" step="1" name="storz_theme_options[background_blur]" id="background_blur" value="<?php echo esc_attr($options['background_blur'] ?? 0); ?>"> px</td>
                </tr>
            </table>


            <h2>Borders and Assets</h2>
            <table class="form-table">
                <tr>
                    <th><label for="border_style">Border Style</label></th>
                    <td>
                        <select name="storz_theme_options[border_style]" id="border_style">
                            <option value="none" <?php selected($options['border_style'] ?? 'solid', 'none'); ?>>None</option>
                            <option value="solid" <?php selected($options['border_style'] ?? 'solid', 'solid'); ?>>Solid</option>
                            <option value="dashed" <?php selected($options['border_style'] ?? 'solid', 'dashed'); ?>>Dashed</option>
                            <option value="dotted" <?php selected($options['border_style'] ?? 'solid', 'dotted'); ?>>Dotted</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="border_top_width">Top Border Width</label></th>
                    <td><input type="number" min="0" max="24" step="1" name="storz_theme_options[border_top_width]" id="border_top_width" value="<?php echo esc_attr($options['border_top_width'] ?? 0); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="border_right_width">Right Border Width</label></th>
                    <td><input type="number" min="0" max="24" step="1" name="storz_theme_options[border_right_width]" id="border_right_width" value="<?php echo esc_attr($options['border_right_width'] ?? 0); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="border_bottom_width">Bottom Border Width</label></th>
                    <td><input type="number" min="0" max="24" step="1" name="storz_theme_options[border_bottom_width]" id="border_bottom_width" value="<?php echo esc_attr($options['border_bottom_width'] ?? 0); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="border_left_width">Left Border Width</label></th>
                    <td><input type="number" min="0" max="24" step="1" name="storz_theme_options[border_left_width]" id="border_left_width" value="<?php echo esc_attr($options['border_left_width'] ?? 0); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="font_stylesheet_urls">Font Stylesheet URLs</label></th>
                    <td>
                        <textarea name="storz_theme_options[font_stylesheet_urls]" id="font_stylesheet_urls" rows="4" class="large-text code"><?php echo esc_textarea($options['font_stylesheet_urls'] ?? ''); ?></textarea>
                        <p class="description">One URL per line. Use it for external font stylesheet links.</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="custom_script_urls">Custom Script URLs</label></th>
                    <td>
                        <textarea name="storz_theme_options[custom_script_urls]" id="custom_script_urls" rows="4" class="large-text code"><?php echo esc_textarea($options['custom_script_urls'] ?? ''); ?></textarea>
                        <p class="description">One URL per line. These scripts load in the footer.</p>
                    </td>
                </tr>
            </table>

            <h2>Colors</h2>
            <table class="form-table">
                <tr>
                    <th><label for="background_color">Background Color</label></th>
                    <td><input type="color" name="storz_theme_options[background_color]" id="background_color" value="<?php echo esc_attr($options['background_color'] ?? '#f5f7fb'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="gradient_start">Gradient Start</label></th>
                    <td><input type="color" name="storz_theme_options[gradient_start]" id="gradient_start" value="<?php echo esc_attr($options['gradient_start'] ?? '#f5f7fb'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="gradient_end">Gradient End</label></th>
                    <td><input type="color" name="storz_theme_options[gradient_end]" id="gradient_end" value="<?php echo esc_attr($options['gradient_end'] ?? '#e9eefb'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="primary_color">Primary Color</label></th>
                    <td><input type="color" name="storz_theme_options[primary_color]" id="primary_color" value="<?php echo esc_attr($options['primary_color'] ?? '#111827'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="secondary_color">Secondary Color</label></th>
                    <td><input type="color" name="storz_theme_options[secondary_color]" id="secondary_color" value="<?php echo esc_attr($options['secondary_color'] ?? '#4f46e5'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="accent_color">Accent Color</label></th>
                    <td><input type="color" name="storz_theme_options[accent_color]" id="accent_color" value="<?php echo esc_attr($options['accent_color'] ?? '#0ea5e9'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="text_color">Text Color</label></th>
                    <td><input type="color" name="storz_theme_options[text_color]" id="text_color" value="<?php echo esc_attr($options['text_color'] ?? '#222222'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="muted_text_color">Muted Text Color</label></th>
                    <td><input type="color" name="storz_theme_options[muted_text_color]" id="muted_text_color" value="<?php echo esc_attr($options['muted_text_color'] ?? '#6b7280'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="card_color">Card Color</label></th>
                    <td><input type="color" name="storz_theme_options[card_color]" id="card_color" value="<?php echo esc_attr($options['card_color'] ?? '#ffffff'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="input_text_color">Input Text Color</label></th>
                    <td><input type="color" name="storz_theme_options[input_text_color]" id="input_text_color" value="<?php echo esc_attr($options['input_text_color'] ?? '#1f2937'); ?>"></td>
                </tr>
                <tr>
                    <th><label for="border_color">Border Color</label></th>
                    <td><input type="color" name="storz_theme_options[border_color]" id="border_color" value="<?php echo esc_attr($options['border_color'] ?? '#dbe3ef'); ?>"></td>
                </tr>
            </table>

            <h2>Cards and Forms</h2>
            <table class="form-table">
                <tr>
                    <th><label for="form_background_style">Form Background</label></th>
                    <td>
                        <select name="storz_theme_options[form_background_style]" id="form_background_style">
                            <option value="transparent" <?php selected($options['form_background_style'] ?? 'transparent', 'transparent'); ?>>Transparent</option>
                            <option value="card" <?php selected($options['form_background_style'] ?? 'transparent', 'card'); ?>>Card</option>
                            <option value="glass" <?php selected($options['form_background_style'] ?? 'transparent', 'glass'); ?>>Glass</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="page_shell_style">Page Content Background</label></th>
                    <td>
                        <select name="storz_theme_options[page_shell_style]" id="page_shell_style">
                            <option value="transparent" <?php selected($options['page_shell_style'] ?? 'transparent', 'transparent'); ?>>Transparent</option>
                            <option value="card" <?php selected($options['page_shell_style'] ?? 'transparent', 'card'); ?>>Card</option>
                            <option value="glass" <?php selected($options['page_shell_style'] ?? 'transparent', 'glass'); ?>>Glass</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="shadow_style">Shadow Style</label></th>
                    <td>
                        <select name="storz_theme_options[shadow_style]" id="shadow_style">
                            <option value="none" <?php selected($options['shadow_style'] ?? 'soft', 'none'); ?>>None</option>
                            <option value="soft" <?php selected($options['shadow_style'] ?? 'soft', 'soft'); ?>>Soft</option>
                            <option value="strong" <?php selected($options['shadow_style'] ?? 'soft', 'strong'); ?>>Strong</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="button_style">Button Style</label></th>
                    <td>
                        <select name="storz_theme_options[button_style]" id="button_style">
                            <option value="rounded" <?php selected($options['button_style'] ?? 'rounded', 'rounded'); ?>>Rounded</option>
                            <option value="pill" <?php selected($options['button_style'] ?? 'rounded', 'pill'); ?>>Pill</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="card_radius">Card Radius</label></th>
                    <td><input type="number" min="0" max="60" step="1" name="storz_theme_options[card_radius]" id="card_radius" value="<?php echo esc_attr($options['card_radius'] ?? 20); ?>"> px</td>
                </tr>
                <tr>
                    <th><label for="field_radius">Field / Button Radius</label></th>
                    <td><input type="number" min="0" max="60" step="1" name="storz_theme_options[field_radius]" id="field_radius" value="<?php echo esc_attr($options['field_radius'] ?? 12); ?>"> px</td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
