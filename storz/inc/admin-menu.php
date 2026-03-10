<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_register_admin_menu() {
    add_menu_page(
        __('STORZ', 'storz'),
        __('STORZ', 'storz'),
        'manage_options',
        'storz',
        'storz_theme_options_page',
        'dashicons-admin-customizer',
        26
    );

    add_submenu_page('storz', __('Design Options', 'storz'), __('Design Options', 'storz'), 'manage_options', 'storz', 'storz_theme_options_page');
    add_submenu_page('storz', __('All Forms', 'storz'), __('All Forms', 'storz'), 'manage_options', 'storz-forms', 'storz_forms_page');
    add_submenu_page('storz', __('Add New Form', 'storz'), __('Add New Form', 'storz'), 'manage_options', 'storz-add-form', 'storz_add_form_page');
    add_submenu_page('storz', __('Submissions', 'storz'), __('Submissions', 'storz'), 'manage_options', 'storz-submissions', 'storz_submissions_page');
    add_submenu_page('storz', __('Patterns', 'storz'), __('Patterns', 'storz'), 'manage_options', 'storz-patterns', 'storz_patterns_admin_page');
    add_submenu_page(null, __('Edit Form', 'storz'), __('Edit Form', 'storz'), 'manage_options', 'storz-edit-form', 'storz_edit_form_page');
}
add_action('admin_menu', 'storz_register_admin_menu');
