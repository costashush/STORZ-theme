<?php
if (!defined('ABSPATH')) {
    exit;
}

class STORZ_Form_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'storz_form_widget',
            __('STORZ Form Widget', 'storz'),
            ['description' => __('Show a STORZ form inside any widget area.', 'storz')]
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $form_id = !empty($instance['form_id']) ? (int) $instance['form_id'] : 0;
        $form_slug = !empty($instance['form_slug']) ? sanitize_title($instance['form_slug']) : '';
        $show_preview_label = !empty($instance['show_preview_label']);
        $custom_css = $instance['custom_css'] ?? '';
        $custom_js = $instance['custom_js'] ?? '';
        $widget_dom_id = 'storz-widget-' . esc_attr($this->id);

        echo $args['before_widget'];
        echo '<div id="' . $widget_dom_id . '" class="storz-widget-shell">';

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        if ($show_preview_label) {
            echo '<div class="storz-widget-preview-note">' . esc_html__('Live form output', 'storz') . '</div>';
        }

        echo do_shortcode($form_slug ? '[storz_form slug="' . esc_attr($form_slug) . '"]' : '[storz_form id="' . (int) $form_id . '"]');

        if (!empty($custom_css)) {
            echo '<style>' . wp_strip_all_tags($custom_css) . '</style>';
        }

        if (!empty($custom_js)) {
            echo '<script>(function(){var storzWidget=document.getElementById(' . wp_json_encode($widget_dom_id) . ');if(!storzWidget){return;}' . $custom_js . '})();</script>';
        }

        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? '';
        $form_id = !empty($instance['form_id']) ? (int) $instance['form_id'] : 0;
        $form_slug = !empty($instance['form_slug']) ? sanitize_title($instance['form_slug']) : '';
        $show_preview_label = !empty($instance['show_preview_label']);
        $custom_css = $instance['custom_css'] ?? '';
        $custom_js = $instance['custom_js'] ?? '';
        $forms = function_exists('storz_get_forms') ? storz_get_forms() : [];
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'storz'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('form_id')); ?>"><?php esc_html_e('Select Form', 'storz'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('form_id')); ?>" name="<?php echo esc_attr($this->get_field_name('form_id')); ?>">
                <option value="0"><?php esc_html_e('Choose a form', 'storz'); ?></option>
                <?php foreach ($forms as $form) : ?>
                    <option value="<?php echo (int) $form->id; ?>" <?php selected($form_id, (int) $form->id); ?>><?php echo esc_html($form->name . ' (' . $form->slug . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('form_slug')); ?>"><?php esc_html_e('Or enter form slug', 'storz'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('form_slug')); ?>" name="<?php echo esc_attr($this->get_field_name('form_slug')); ?>" type="text" value="<?php echo esc_attr($form_slug); ?>" placeholder="contact-form">
        </p>
        <p>
            <label>
                <input type="checkbox" name="<?php echo esc_attr($this->get_field_name('show_preview_label')); ?>" value="1" <?php checked($show_preview_label, true); ?>>
                <?php esc_html_e('Show small preview label above the widget output', 'storz'); ?>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('custom_css')); ?>"><?php esc_html_e('Custom CSS', 'storz'); ?></label>
            <textarea class="widefat code" rows="6" id="<?php echo esc_attr($this->get_field_id('custom_css')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_css')); ?>" placeholder="#<?php echo esc_attr($this->id); ?> .storz-public-form{backdrop-filter:blur(8px);}\n"><?php echo esc_textarea($custom_css); ?></textarea>
            <small><?php esc_html_e('Applies only to this widget instance. You can target storzWidget in JS and this widget wrapper in CSS.', 'storz'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('custom_js')); ?>"><?php esc_html_e('Custom Script', 'storz'); ?></label>
            <textarea class="widefat code" rows="6" id="<?php echo esc_attr($this->get_field_id('custom_js')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_js')); ?>" placeholder="var fields = storzWidget.querySelectorAll('input, select, textarea');\nfields.forEach(function(el){ el.setAttribute('data-widget','storz'); });"><?php echo esc_textarea($custom_js); ?></textarea>
            <small><?php esc_html_e('Runs only for this widget on the front end. Use storzWidget as the widget root element.', 'storz'); ?></small>
        </p>
        <div class="storz-widget-admin-preview" style="padding:10px;border:1px solid #dcdcde;border-radius:8px;background:#fff;max-height:260px;overflow:auto;">
            <strong><?php esc_html_e('Preview', 'storz'); ?></strong>
            <div style="margin-top:8px;">
                <?php
                if ($form_slug || $form_id) {
                    echo do_shortcode($form_slug ? '[storz_form slug="' . esc_attr($form_slug) . '"]' : '[storz_form id="' . (int) $form_id . '"]');
                } else {
                    echo '<em>' . esc_html__('Choose a form to preview it here.', 'storz') . '</em>';
                }
                ?>
            </div>
        </div>
        <p><small><?php esc_html_e('Works in widget areas and block-based widgets using the Legacy Widget block.', 'storz'); ?></small></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $custom_css = current_user_can('unfiltered_html') ? (string) ($new_instance['custom_css'] ?? '') : '';
        $custom_js = current_user_can('unfiltered_html') ? (string) ($new_instance['custom_js'] ?? '') : '';

        return [
            'title' => sanitize_text_field($new_instance['title'] ?? ''),
            'form_id' => absint($new_instance['form_id'] ?? 0),
            'form_slug' => sanitize_title($new_instance['form_slug'] ?? ''),
            'show_preview_label' => !empty($new_instance['show_preview_label']) ? 1 : 0,
            'custom_css' => $custom_css,
            'custom_js' => $custom_js,
        ];
    }
}

function storz_register_widgets() {
    register_widget('STORZ_Form_Widget');
}
add_action('widgets_init', 'storz_register_widgets', 20);
