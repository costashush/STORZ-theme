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


function storz_register_sidebars() {
    register_sidebar([
        'name'          => __('STORZ Sidebar', 'storz'),
        'id'            => 'storz-sidebar',
        'description'   => __('Main sidebar area for STORZ widgets and forms.', 'storz'),
        'before_widget' => '<section id="%1$s" class="widget storz-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'storz_register_sidebars', 5);
