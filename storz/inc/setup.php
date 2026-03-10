<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 320,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'storz'),
    ]);
}
add_action('after_setup_theme', 'storz_theme_setup');
