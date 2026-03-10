<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_handle_form_submission() {
    if (!isset($_POST['storz_submit_form'], $_POST['storz_form_id'], $_POST['storz_submit_nonce'])) {
        return;
    }

    $nonce = sanitize_text_field(wp_unslash($_POST['storz_submit_nonce']));
    if (!wp_verify_nonce($nonce, 'storz_submit_form')) {
        return;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'storz_form_submissions';
    $form_id = (int) $_POST['storz_form_id'];

    $data = $_POST;
    unset($data['storz_submit_form'], $data['storz_form_id'], $data['storz_submit_nonce'], $data['_wp_http_referer']);

    $sanitized = [];
    foreach ($data as $key => $value) {
        $clean_key = sanitize_key($key);
        if (is_array($value)) {
            $sanitized[$clean_key] = array_map('sanitize_text_field', wp_unslash($value));
        } else {
            $sanitized[$clean_key] = sanitize_text_field(wp_unslash($value));
        }
    }

    $wpdb->insert($table, [
        'form_id' => $form_id,
        'submitted_data' => wp_json_encode($sanitized),
    ]);
}
add_action('init', 'storz_handle_form_submission');

function storz_submissions_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'storz_form_submissions';
    $forms_table = $wpdb->prefix . 'storz_forms';

    $rows = $wpdb->get_results(
        "SELECT s.*, f.name as form_name
         FROM {$table} s
         LEFT JOIN {$forms_table} f ON s.form_id = f.id
         ORDER BY s.id DESC
         LIMIT 100"
    );
    ?>
    <div class="wrap">
        <h1>Submissions</h1>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Form</th>
                    <th>Data</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?php echo (int) $row->id; ?></td>
                            <td><?php echo esc_html($row->form_name ?: 'Unknown'); ?></td>
                            <td><pre><?php echo esc_html($row->submitted_data); ?></pre></td>
                            <td><?php echo esc_html($row->created_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="4">No submissions found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
