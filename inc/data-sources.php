<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_field_options($field) {
    $data_source = $field['data_source'] ?? 'manual';
    $options = $field['options'] ?? [];

    switch ($data_source) {
        case 'countries':
            return storz_get_default_country_options();

        case 'user_roles':
            global $wp_roles;
            return is_object($wp_roles) ? array_values($wp_roles->get_names()) : [];

        case 'pages':
            $pages = get_pages(['sort_column' => 'post_title']);
            return wp_list_pluck($pages, 'post_title');

        case 'posts':
            $posts = get_posts([
                'post_type'      => 'post',
                'posts_per_page' => 100,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);
            return wp_list_pluck($posts, 'post_title');

        case 'categories':
            $terms = get_terms([
                'taxonomy'   => 'category',
                'hide_empty' => false,
            ]);
            return is_array($terms) ? wp_list_pluck($terms, 'name') : [];

        case 'products':
            if (!post_type_exists('product')) {
                return [];
            }
            $products = get_posts([
                'post_type'      => 'product',
                'posts_per_page' => 100,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);
            return wp_list_pluck($products, 'post_title');

        case 'product_categories':
            if (!taxonomy_exists('product_cat')) {
                return [];
            }
            $terms = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            ]);
            return is_array($terms) ? wp_list_pluck($terms, 'name') : [];

        default:
            return is_array($options) ? $options : [];
    }
}
