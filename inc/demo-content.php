<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_prebuilt_pages_map() {
    return [
        'home' => [
            'title' => 'Home',
            'slug' => 'home',
            'content' => '<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Welcome to STORZ</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">A clean starter with full-width layout, side-aligned branding, transparent inputs, search, and multi-step forms.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="lead-capture-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'contact' => [
            'title' => 'Contact',
            'slug' => 'contact',
            'content' => '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Contact Us</h2><!-- /wp:heading -->
<!-- wp:shortcode -->[storz_form slug="contact-form"]<!-- /wp:shortcode -->',
        ],
        'login' => [
            'title' => 'Login',
            'slug' => 'login',
            'content' => '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Login</h2><!-- /wp:heading -->
<!-- wp:shortcode -->[storz_login_form]<!-- /wp:shortcode -->
<!-- wp:shortcode -->[storz_logout_link label="Logout"]<!-- /wp:shortcode -->',
        ],
        'quote-request' => [
            'title' => 'Quote Request',
            'slug' => 'quote-request',
            'content' => '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Request a Quote</h2><!-- /wp:heading -->
<!-- wp:shortcode -->[storz_form slug="quote-request-form"]<!-- /wp:shortcode -->',
        ],
        'filter-form' => [
            'title' => 'Filter Form',
            'slug' => 'filter-form',
            'content' => '<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading --><h2>Catalog Filter</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Use this demo page for filtering against a demo catalog table.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="products-catalog-filter"]<!-- /wp:shortcode --><!-- wp:shortcode -->[storz_filter_demo_table]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'demo-elements' => [
            'title' => 'Demo Elements',
            'slug' => 'demo-elements',
            'content' => '<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">STORZ Demo Elements</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">A sample page with common content blocks, cards, chips, and table elements.</p><!-- /wp:paragraph --></div><!-- /wp:group -->
<!-- wp:shortcode -->[storz_demo_elements]<!-- /wp:shortcode -->',
        ],
    ];
}

function storz_insert_prebuilt_pages() {
    $pages = storz_get_prebuilt_pages_map();
    $inserted = 0;

    foreach ($pages as $page) {
        $existing = get_page_by_path($page['slug']);
        if ($existing instanceof WP_Post) {
            continue;
        }

        $page_id = wp_insert_post([
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_content' => $page['content'],
        ], true);

        if (!is_wp_error($page_id) && $page['slug'] === 'home') {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $page_id);
        }

        if (!is_wp_error($page_id)) {
            $inserted++;
        }
    }

    return $inserted;
}

function storz_maybe_seed_prebuilt_pages() {
    if (get_option('storz_prebuilt_pages_seeded')) {
        return;
    }

    storz_insert_prebuilt_pages();
    update_option('storz_prebuilt_pages_seeded', 1);
}
add_action('after_switch_theme', 'storz_maybe_seed_prebuilt_pages', 30);
