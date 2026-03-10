<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_register_pattern_category() {
    if (function_exists('register_block_pattern_category')) {
        register_block_pattern_category('storz', ['label' => __('STORZ', 'storz')]);
    }
}
add_action('init', 'storz_register_pattern_category');

function storz_register_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    $patterns = [
        'hero' => [
            'title' => __('Hero Section', 'storz'),
            'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"64px","bottom":"64px","left":"24px","right":"24px"}},"color":{"background":"#111827","text":"#ffffff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group alignfull has-text-color has-background" style="color:#ffffff;background-color:#111827;padding-top:64px;padding-right:24px;padding-bottom:64px;padding-left:24px"><!-- wp:heading {"level":1} --><h1>Build faster with STORZ V2.1</h1><!-- /wp:heading --><!-- wp:paragraph --><p>Prebuilt forms, starter pages, login tools, and a flexible theme foundation for custom WordPress builds.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact">Contact</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/quote-request">Request Quote</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
        ],
        'contact-cta' => [
            'title' => __('Contact CTA', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#f3f4f6"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#f3f4f6;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"level":3} --><h3>Need a custom website or ecommerce solution?</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Use the built-in contact and lead forms to start collecting inquiries right away.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="contact-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'lead-capture' => [
            'title' => __('Lead Capture', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#eef2ff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#eef2ff;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"level":3} --><h3>Capture leads</h3><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="lead-capture-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'product-intro' => [
            'title' => __('Product Intro', 'storz'),
            'content' => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column {"width":"55%"} --><div class="wp-block-column" style="flex-basis:55%"><!-- wp:heading --><h2>Product catalog ready</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Use WooCommerce categories and products as dynamic options in the STORZ form builder.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"width":"45%"} --><div class="wp-block-column" style="flex-basis:45%"><!-- wp:shortcode -->[storz_form slug="products-catalog-filter"]<!-- /wp:shortcode --></div><!-- /wp:column --></div><!-- /wp:columns -->',
        ],
        'login-cta' => [
            'title' => __('Login CTA', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#ecfeff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#ecfeff;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"level":3} --><h3>Login or manage your account</h3><!-- /wp:heading --><!-- wp:shortcode -->[storz_login_form]<!-- /wp:shortcode --><!-- wp:shortcode -->[storz_logout_link label="Logout"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
    ];

    foreach ($patterns as $slug => $pattern) {
        register_block_pattern('storz/' . $slug, [
            'title'      => $pattern['title'],
            'categories' => ['storz'],
            'content'    => $pattern['content'],
        ]);
    }
}
add_action('init', 'storz_register_block_patterns');
