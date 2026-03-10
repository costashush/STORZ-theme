<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_form_by_slug($slug) {
    global $wpdb;
    $table = $wpdb->prefix . 'storz_forms';
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE slug = %s LIMIT 1", sanitize_title($slug)));
}

function storz_render_form_field($field, $index) {
    $type = $field['type'] ?? 'text';
    $label = $field['label'] ?? 'Field';
    $name = $field['name'] ?? 'field_' . $index;
    $options = storz_get_field_options($field);

    ob_start();
    ?>
    <div class="storz-field-group storz-field-<?php echo esc_attr($type); ?>">
        <label for="<?php echo esc_attr($name); ?>"><strong><?php echo esc_html($label); ?></strong></label>

        <?php if (in_array($type, ['text', 'email', 'number', 'date', 'tel', 'password'], true)) : ?>
            <input type="<?php echo esc_attr($type); ?>" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>">

        <?php elseif ($type === 'textarea') : ?>
            <textarea id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>" rows="4"></textarea>

        <?php elseif ($type === 'select') : ?>
            <select id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>">
                <?php foreach ($options as $option) : ?>
                    <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                <?php endforeach; ?>
            </select>

        <?php elseif ($type === 'radio') : ?>
            <div class="storz-choice-list">
                <?php foreach ($options as $option) : ?>
                    <label><input type="radio" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($option); ?>"> <?php echo esc_html($option); ?></label>
                <?php endforeach; ?>
            </div>

        <?php elseif ($type === 'checkbox') : ?>
            <div class="storz-choice-list">
                <?php foreach ($options as $option) : ?>
                    <label><input type="checkbox" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr($option); ?>"> <?php echo esc_html($option); ?></label>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

function storz_render_form_shortcode($atts) {
    $atts = shortcode_atts(['id' => 0, 'slug' => ''], $atts, 'storz_form');
    $form = !empty($atts['slug']) ? storz_get_form_by_slug($atts['slug']) : storz_get_form((int) $atts['id']);

    if (!$form) {
        return '<p>Form not found.</p>';
    }

    $fields = json_decode($form->fields, true);
    if (!is_array($fields)) {
        $fields = [];
    }

    $steps = storz_get_form_step_groups($fields);
    $is_multistep = count($steps) > 1;

    ob_start();
    ?>
    <div class="storz-form-card">
        <form method="post" class="storz-public-form" data-multistep="<?php echo $is_multistep ? '1' : '0'; ?>">
            <input type="hidden" name="storz_form_id" value="<?php echo (int) $form->id; ?>">
            <?php wp_nonce_field('storz_submit_form', 'storz_submit_nonce'); ?>

            <?php if ($is_multistep) : ?>
                <div class="storz-form-progress">
                    <?php foreach (array_values($steps) as $step_index => $unused) : ?>
                        <span class="storz-form-progress-dot<?php echo $step_index === 0 ? ' is-active' : ''; ?>"></span>
                    <?php endforeach; ?>
                </div>
                <div class="storz-step-indicator">Step 1 of <?php echo (int) count($steps); ?></div>
            <?php endif; ?>

            <?php $step_position = 0; foreach ($steps as $step_number => $step_fields) : ?>
                <div class="storz-form-step<?php echo $step_position === 0 ? ' is-active' : ''; ?>" data-step="<?php echo (int) $step_number; ?>">
                    <?php foreach ($step_fields as $item) {
                        echo storz_render_form_field($item['field'], $item['index']);
                    } ?>

                    <?php if ($is_multistep) : ?>
                        <div class="storz-step-actions">
                            <?php if ($step_position > 0) : ?>
                                <button type="button" data-storz-prev><?php esc_html_e('Previous', 'storz'); ?></button>
                            <?php endif; ?>

                            <?php if ($step_position < count($steps) - 1) : ?>
                                <button type="button" data-storz-next><?php esc_html_e('Next', 'storz'); ?></button>
                            <?php else : ?>
                                <button type="submit" name="storz_submit_form"><?php esc_html_e('Submit', 'storz'); ?></button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php $step_position++; endforeach; ?>

            <?php if (!$is_multistep) : ?>
                <div class="storz-submit-row">
                    <button type="submit" name="storz_submit_form"><?php esc_html_e('Submit', 'storz'); ?></button>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('storz_form', 'storz_render_form_shortcode');

function storz_login_form_shortcode($atts) {
    $atts = shortcode_atts([
        'redirect' => home_url('/'),
        'title'    => 'Login',
    ], $atts, 'storz_login_form');

    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        return '<div class="storz-form-card"><p>You are logged in as <strong>' . esc_html($current_user->display_name) . '</strong>.</p>' . do_shortcode('[storz_logout_link]') . '</div>';
    }

    $args = [
        'echo'           => false,
        'redirect'       => esc_url($atts['redirect']),
        'remember'       => true,
        'form_id'        => 'storz-loginform',
        'label_username' => __('Email or Username', 'storz'),
        'label_password' => __('Password', 'storz'),
        'label_remember' => __('Remember Me', 'storz'),
        'label_log_in'   => __('Log In', 'storz'),
    ];

    $output  = '<div class="storz-form-card storz-auth-card">';
    $output .= '<h3>' . esc_html($atts['title']) . '</h3>';
    $output .= wp_login_form($args);
    $output .= '<p class="storz-auth-links"><a href="' . esc_url(wp_lostpassword_url()) . '">Lost your password?</a>';

    if (get_option('users_can_register')) {
        $output .= ' <span>|</span> <a href="' . esc_url(wp_registration_url()) . '">Register</a>';
    }

    $output .= '</p></div>';
    return $output;
}
add_shortcode('storz_login_form', 'storz_login_form_shortcode');

function storz_logout_link_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '';
    }

    $atts = shortcode_atts([
        'label'    => 'Log Out',
        'redirect' => home_url('/'),
    ], $atts, 'storz_logout_link');

    return '<p class="storz-logout-wrap"><a class="storz-button-link" href="' . esc_url(wp_logout_url($atts['redirect'])) . '">' . esc_html($atts['label']) . '</a></p>';
}
add_shortcode('storz_logout_link', 'storz_logout_link_shortcode');

function storz_account_panel_shortcode() {
    if (!is_user_logged_in()) {
        return '<div class="storz-form-card"><p>Please log in to view your account area.</p>' . do_shortcode('[storz_login_form]') . '</div>';
    }

    $user = wp_get_current_user();
    ob_start();
    ?>
    <div class="storz-form-card storz-account-panel">
        <h3>My Account</h3>
        <p><strong>Name:</strong> <?php echo esc_html($user->display_name); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($user->user_email); ?></p>
        <p><strong>Role:</strong> <?php echo esc_html(implode(', ', $user->roles)); ?></p>
        <?php echo do_shortcode('[storz_logout_link]'); ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('storz_account_panel', 'storz_account_panel_shortcode');
