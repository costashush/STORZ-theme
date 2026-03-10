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

function storz_get_registered_pattern_labels() {
    return [
        'hero'               => __('Centered Hero', 'storz'),
        'contact-cta'        => __('Contact CTA', 'storz'),
        'lead-capture'       => __('Lead Capture', 'storz'),
        'product-intro'      => __('Product Intro', 'storz'),
        'login-cta'          => __('Login CTA', 'storz'),
        'quote-banner'       => __('Quote Banner', 'storz'),
        'feature-grid'       => __('Feature Grid', 'storz'),
        'service-cards'      => __('Service Cards', 'storz'),
        'faq'                => __('FAQ', 'storz'),
        'centered-form-hero' => __('Centered Form Hero', 'storz'),
    ];
}

function storz_patterns_admin_page() {
    $patterns = storz_get_registered_pattern_labels();
    ?>
    <div class="wrap">
        <h1>STORZ Patterns</h1>
        <p>Open the block editor and search in the <strong>STORZ</strong> category.</p>
        <ul style="list-style:disc;padding-left:20px;">
            <?php foreach ($patterns as $slug => $label) : ?>
                <li><strong><?php echo esc_html($label); ?></strong> — <code>storz/<?php echo esc_html($slug); ?></code></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}

function storz_register_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    $patterns = [
        'hero' => [
            'title' => __('Centered Hero', 'storz'),
            'content' => '<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"72px","bottom":"72px","left":"24px","right":"24px"}},"color":{"background":"#111827","text":"#ffffff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group alignfull has-text-color has-background" style="color:#ffffff;background-color:#111827;padding-top:72px;padding-right:24px;padding-bottom:72px;padding-left:24px"><!-- wp:heading {"textAlign":"center","level":1} --><h1 class="has-text-align-center">Build cleaner flows with STORZ</h1><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Multi-step forms, centered layouts, and lightweight pages made for focused conversion.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact">Contact</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/quote-request">Request Quote</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
        ],
        'contact-cta' => [
            'title' => __('Contact CTA', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#f3f4f6"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#f3f4f6;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Need a custom website or ecommerce solution?</h3><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Use the built-in contact form to start collecting inquiries right away.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="contact-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'lead-capture' => [
            'title' => __('Lead Capture', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#eef2ff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#eef2ff;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Capture leads</h3><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="lead-capture-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'product-intro' => [
            'title' => __('Product Intro', 'storz'),
            'content' => '<!-- wp:columns {"verticalAlignment":"center"} --><div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"width":"55%"} --><div class="wp-block-column" style="flex-basis:55%"><!-- wp:heading --><h2>Product catalog ready</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Use WooCommerce categories and products as dynamic options in the STORZ form builder.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"width":"45%"} --><div class="wp-block-column" style="flex-basis:45%"><!-- wp:shortcode -->[storz_form slug="products-catalog-filter"]<!-- /wp:shortcode --></div><!-- /wp:column --></div><!-- /wp:columns -->',
        ],
        'login-cta' => [
            'title' => __('Login CTA', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","left":"24px","right":"24px"}},"border":{"radius":"16px"},"color":{"background":"#ecfeff"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#ecfeff;padding-top:32px;padding-right:24px;padding-bottom:32px;padding-left:24px"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Login or manage your account</h3><!-- /wp:heading --><!-- wp:shortcode -->[storz_login_form]<!-- /wp:shortcode --><!-- wp:shortcode -->[storz_logout_link label="Logout"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'quote-banner' => [
            'title' => __('Quote Banner', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"28px","bottom":"28px","left":"24px","right":"24px"}},"color":{"background":"#111827","text":"#ffffff"},"border":{"radius":"18px"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-text-color has-background" style="border-radius:18px;color:#ffffff;background-color:#111827;padding-top:28px;padding-right:24px;padding-bottom:28px;padding-left:24px"><!-- wp:columns {"verticalAlignment":"center"} --><div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3>Ready to launch your next project?</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Request a quote and get a cleaner project intake flow.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"width":"220px"} --><div class="wp-block-column" style="flex-basis:220px"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/quote-request">Get a Quote</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
        ],
        'feature-grid' => [
            'title' => __('Feature Grid', 'storz'),
            'content' => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"style":{"color":{"background":"#ffffff"},"border":{"radius":"16px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"}}}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#ffffff;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:heading {"level":4} --><h4>Multi-step Forms</h4><!-- /wp:heading --><!-- wp:paragraph --><p>Break long forms into focused steps.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"style":{"color":{"background":"#ffffff"},"border":{"radius":"16px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"}}}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#ffffff;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:heading {"level":4} --><h4>Centered Layout</h4><!-- /wp:heading --><!-- wp:paragraph --><p>Keep attention on the main action.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:group {"style":{"color":{"background":"#ffffff"},"border":{"radius":"16px"},"spacing":{"padding":{"top":"20px","bottom":"20px","left":"20px","right":"20px"}}}} --><div class="wp-block-group has-background" style="border-radius:16px;background-color:#ffffff;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:heading {"level":4} --><h4>Design Controls</h4><!-- /wp:heading --><!-- wp:paragraph --><p>Colors, spacing, cards, shadows, and form width.</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:column --></div><!-- /wp:columns -->',
        ],
        'service-cards' => [
            'title' => __('Service Cards', 'storz'),
            'content' => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4} --><h4 class="has-text-align-center">Web Design</h4><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Minimal, clean page layouts.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4} --><h4 class="has-text-align-center">Funnels</h4><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Focused lead and quote flows.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":4} --><h4 class="has-text-align-center">Client Portals</h4><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Simple login and customer journeys.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
        ],
        'faq' => [
            'title' => __('FAQ', 'storz'),
            'content' => '<!-- wp:details --><details class="wp-block-details"><summary>Can I use multi-step forms?</summary><!-- wp:paragraph --><p>Yes. Assign a step number to each field in the STORZ builder.</p><!-- /wp:paragraph --></details><!-- /wp:details --><!-- wp:details --><details class="wp-block-details"><summary>Can I hide the footer?</summary><!-- wp:paragraph --><p>Yes. You can hide the footer from the STORZ Design Options page.</p><!-- /wp:paragraph --></details><!-- /wp:details --><!-- wp:details --><details class="wp-block-details"><summary>Can I make the form transparent?</summary><!-- wp:paragraph --><p>Yes. Set Form Background to Transparent.</p><!-- /wp:paragraph --></details><!-- /wp:details -->',
        ],
        'centered-form-hero' => [
            'title' => __('Centered Form Hero', 'storz'),
            'content' => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"40px","bottom":"40px","left":"24px","right":"24px"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:40px;padding-right:24px;padding-bottom:40px;padding-left:24px"><!-- wp:heading {"textAlign":"center","level":1} --><h1 class="has-text-align-center">Tell us about your project</h1><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Start with a short multi-step intake form.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="quote-request-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
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


function storz_register_extra_block_patterns() {
    if (!function_exists('register_block_pattern')) {
        return;
    }

    $patterns = [
        'filter-form-panel' => [
            'title' => __('Filter Form Panel', 'storz'),
            'content' => '<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Filter Products</h3><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Use a centered filter form for category, product, and price.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="products-catalog-filter"]<!-- /wp:shortcode --></div><!-- /wp:group -->',
        ],
        'demo-elements-panel' => [
            'title' => __('Demo Elements Panel', 'storz'),
            'content' => '<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Visual Demo</h3><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Drop in a ready sample section with tiles, chips, and a demo form.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_demo_elements]<!-- /wp:shortcode --></div><!-- /wp:group -->',
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
add_action('init', 'storz_register_extra_block_patterns', 20);
