<?php
if (!defined('ABSPATH')) {
    exit;
}

function storz_get_business_installers() {
    return [
        'manufacturing-company' => [
            'label' => 'Manufacturing Company',
            'description' => 'Install demo pages and forms for a factory, production, and RFQ workflow.',
            'forms' => [
                [
                    'name' => 'Manufacturing RFQ Form',
                    'slug' => 'manufacturing-rfq-form',
                    'fields' => [
                        ['label'=>'Company Name','name'=>'company_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Contact Person','name'=>'contact_person','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Email','name'=>'email','type'=>'email','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Product Line','name'=>'product_line','type'=>'select','data_source'=>'manual','options'=>['Metal','Plastic','Electronics','Packaging'],'step'=>2],
                        ['label'=>'Quantity Needed','name'=>'quantity_needed','type'=>'text','data_source'=>'manual','options'=>[],'step'=>2],
                        ['label'=>'Specs / Notes','name'=>'specs_notes','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>3],
                    ],
                ],
                [
                    'name' => 'Manufacturing Distributor Application',
                    'slug' => 'manufacturing-distributor-application',
                    'fields' => [
                        ['label'=>'Distributor Name','name'=>'distributor_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Region','name'=>'region','type'=>'select','data_source'=>'countries','options'=>[],'step'=>1],
                        ['label'=>'Annual Volume','name'=>'annual_volume','type'=>'select','data_source'=>'manual','options'=>['Under 100 units','100-500 units','500-1000 units','1000+ units'],'step'=>2],
                        ['label'=>'Comments','name'=>'comments','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>2],
                    ],
                ],
            ],
            'pages' => [
                ['title'=>'Manufacturing Home','slug'=>'manufacturing-home','content'=>'<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading --><h2>Manufacturing Company</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Production-ready demo starter with quote and distributor flows.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="manufacturing-rfq-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->'],
                ['title'=>'Request a Quote','slug'=>'manufacturing-request-quote','content'=>'<!-- wp:heading --><h2>Request a Manufacturing Quote</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="manufacturing-rfq-form"]<!-- /wp:shortcode -->'],
                ['title'=>'Distributor Application','slug'=>'manufacturer-distributor-application','content'=>'<!-- wp:heading --><h2>Distributor Application</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="manufacturing-distributor-application"]<!-- /wp:shortcode -->'],
            ],
        ],
        'retail-ecommerce' => [
            'label' => 'Retail and Ecommerce',
            'description' => 'Install demo catalog, product inquiry, and customer signup flows.',
            'forms' => [
                [
                    'name' => 'Retail Product Finder',
                    'slug' => 'retail-product-finder',
                    'fields' => [
                        ['label'=>'Keyword','name'=>'keyword','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Category','name'=>'category','type'=>'select','data_source'=>'product_categories','options'=>[],'step'=>1],
                        ['label'=>'Price Range','name'=>'price_range','type'=>'select','data_source'=>'manual','options'=>['Any','0-100','100-250','250-500','500+'],'step'=>1],
                        ['label'=>'Brand','name'=>'brand','type'=>'text','data_source'=>'manual','options'=>[],'step'=>2],
                    ],
                ],
                [
                    'name' => 'Retail Customer Signup',
                    'slug' => 'retail-customer-signup',
                    'fields' => [
                        ['label'=>'First Name','name'=>'first_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Last Name','name'=>'last_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Email','name'=>'email','type'=>'email','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Phone','name'=>'phone','type'=>'tel','data_source'=>'manual','options'=>[],'step'=>2],
                        ['label'=>'Interests','name'=>'interests','type'=>'checkbox','data_source'=>'manual','options'=>['New arrivals','Deals','VIP offers'],'step'=>2],
                    ],
                ],
            ],
            'pages' => [
                ['title'=>'Store Landing','slug'=>'store-landing','content'=>'<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading --><h2>Retail and Ecommerce</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Catalog-ready starter for shops and product-focused businesses.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="retail-product-finder"]<!-- /wp:shortcode --><!-- wp:shortcode -->[storz_filter_demo_table]<!-- /wp:shortcode --></div><!-- /wp:group -->'],
                ['title'=>'Customer Signup','slug'=>'customer-signup','content'=>'<!-- wp:heading --><h2>Customer Signup</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="retail-customer-signup"]<!-- /wp:shortcode -->'],
                ['title'=>'Catalog Filter','slug'=>'catalog-filter','content'=>'<!-- wp:heading --><h2>Catalog Filter</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="retail-product-finder"]<!-- /wp:shortcode --><!-- wp:shortcode -->[storz_filter_demo_table]<!-- /wp:shortcode -->'],
            ],
        ],
        'service-project-business' => [
            'label' => 'Service and Project Based Business',
            'description' => 'Install intake, project brief, and appointment demo content.',
            'forms' => [
                [
                    'name' => 'Service Intake Form',
                    'slug' => 'service-intake-form',
                    'fields' => [
                        ['label'=>'Full Name','name'=>'full_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Email','name'=>'email','type'=>'email','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Service Needed','name'=>'service_needed','type'=>'select','data_source'=>'manual','options'=>['Consulting','Development','Design','Maintenance'],'step'=>2],
                        ['label'=>'Preferred Start Date','name'=>'preferred_start','type'=>'date','data_source'=>'manual','options'=>[],'step'=>2],
                        ['label'=>'Project Brief','name'=>'project_brief','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>3],
                    ],
                ],
                [
                    'name' => 'Project Discovery Form',
                    'slug' => 'project-discovery-form',
                    'fields' => [
                        ['label'=>'Company','name'=>'company','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Budget','name'=>'budget','type'=>'select','data_source'=>'manual','options'=>['Under 5,000','5,000-10,000','10,000-25,000','25,000+'],'step'=>2],
                        ['label'=>'Timeline','name'=>'timeline','type'=>'select','data_source'=>'manual','options'=>['ASAP','This month','Next quarter','Planning stage'],'step'=>2],
                        ['label'=>'Scope','name'=>'scope','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>3],
                    ],
                ],
            ],
            'pages' => [
                ['title'=>'Services Overview','slug'=>'services-overview','content'=>'<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading --><h2>Service and Project Business</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Use this starter for agencies, studios, consultants, and project teams.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="service-intake-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->'],
                ['title'=>'Project Discovery','slug'=>'project-discovery','content'=>'<!-- wp:heading --><h2>Project Discovery</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="project-discovery-form"]<!-- /wp:shortcode -->'],
                ['title'=>'Book a Consultation','slug'=>'book-consultation','content'=>'<!-- wp:heading --><h2>Book a Consultation</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="service-intake-form"]<!-- /wp:shortcode -->'],
            ],
        ],
        'logistics-distribution' => [
            'label' => 'Logistics and Distribution',
            'description' => 'Install shipment inquiry, route filter, and partner onboarding content.',
            'forms' => [
                [
                    'name' => 'Shipment Inquiry Form',
                    'slug' => 'shipment-inquiry-form',
                    'fields' => [
                        ['label'=>'Company','name'=>'company','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Pickup Location','name'=>'pickup_location','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Delivery Location','name'=>'delivery_location','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Cargo Type','name'=>'cargo_type','type'=>'select','data_source'=>'manual','options'=>['General','Fragile','Cold chain','Oversized'],'step'=>2],
                        ['label'=>'Load Details','name'=>'load_details','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>3],
                    ],
                ],
                [
                    'name' => 'Carrier Partner Form',
                    'slug' => 'carrier-partner-form',
                    'fields' => [
                        ['label'=>'Carrier Name','name'=>'carrier_name','type'=>'text','data_source'=>'manual','options'=>[],'step'=>1],
                        ['label'=>'Fleet Size','name'=>'fleet_size','type'=>'select','data_source'=>'manual','options'=>['1-5','6-20','21-50','50+'],'step'=>1],
                        ['label'=>'Coverage Area','name'=>'coverage_area','type'=>'select','data_source'=>'countries','options'=>[],'step'=>2],
                        ['label'=>'Notes','name'=>'notes','type'=>'textarea','data_source'=>'manual','options'=>[],'step'=>2],
                    ],
                ],
            ],
            'pages' => [
                ['title'=>'Logistics Overview','slug'=>'logistics-overview','content'=>'<!-- wp:group {"className":"hero-card"} --><div class="wp-block-group hero-card"><!-- wp:heading --><h2>Logistics and Distribution</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Full-width demo setup for transport, warehousing, and distribution.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[storz_form slug="shipment-inquiry-form"]<!-- /wp:shortcode --></div><!-- /wp:group -->'],
                ['title'=>'Shipment Inquiry','slug'=>'shipment-inquiry','content'=>'<!-- wp:heading --><h2>Shipment Inquiry</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="shipment-inquiry-form"]<!-- /wp:shortcode -->'],
                ['title'=>'Carrier Partners','slug'=>'carrier-partners','content'=>'<!-- wp:heading --><h2>Carrier Partners</h2><!-- /wp:heading --><!-- wp:shortcode -->[storz_form slug="carrier-partner-form"]<!-- /wp:shortcode -->'],
            ],
        ],
    ];
}

function storz_insert_pages_batch($pages) {
    $inserted = 0;
    foreach ($pages as $page) {
        if (empty($page['slug']) || empty($page['title'])) {
            continue;
        }
        $existing = get_page_by_path($page['slug']);
        if ($existing instanceof WP_Post) {
            continue;
        }
        $page_id = wp_insert_post([
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_title' => wp_strip_all_tags($page['title']),
            'post_name' => sanitize_title($page['slug']),
            'post_content' => $page['content'] ?? '',
        ], true);
        if (!is_wp_error($page_id)) {
            $inserted++;
        }
    }
    return $inserted;
}

function storz_install_business_package($key) {
    $packages = storz_get_business_installers();
    if (empty($packages[$key])) {
        return ['forms' => 0, 'pages' => 0];
    }
    $package = $packages[$key];
    $forms = 0;
    foreach ($package['forms'] as $form) {
        if (storz_insert_form_template($form)) {
            $forms++;
        }
    }
    $pages = storz_insert_pages_batch($package['pages']);
    return ['forms' => $forms, 'pages' => $pages];
}

function storz_handle_installer_actions() {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }
    if (empty($_POST['storz_installer_action']) || empty($_POST['storz_installer_nonce'])) {
        return;
    }
    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['storz_installer_nonce'])), 'storz_run_installer')) {
        return;
    }
    $key = sanitize_key(wp_unslash($_POST['storz_installer_action']));
    $result = storz_install_business_package($key);
    $url = add_query_arg([
        'page' => 'storz-installers',
        'installed' => $key,
        'forms' => (int) $result['forms'],
        'pages' => (int) $result['pages'],
    ], admin_url('admin.php'));
    wp_safe_redirect($url);
    exit;
}
add_action('admin_init', 'storz_handle_installer_actions');

function storz_installers_page() {
    $packages = storz_get_business_installers();
    ?>
    <div class="wrap">
        <h1>STORZ Installers</h1>
        <p>Install a prebuilt package with industry-specific forms and pages.</p>
        <?php if (!empty($_GET['installed'])) : ?>
            <div class="updated"><p><?php echo esc_html(ucwords(str_replace(['-', '_'], ' ', sanitize_text_field(wp_unslash($_GET['installed']))))); ?> installed. Added <?php echo (int) ($_GET['forms'] ?? 0); ?> forms and <?php echo (int) ($_GET['pages'] ?? 0); ?> pages.</p></div>
        <?php endif; ?>
        <div class="storz-installer-grid">
            <?php foreach ($packages as $key => $package) : ?>
                <div class="storz-installer-card postbox" style="padding:16px;max-width:900px;margin-bottom:20px;">
                    <h2><?php echo esc_html($package['label']); ?></h2>
                    <p><?php echo esc_html($package['description']); ?></p>
                    <p><strong>Forms:</strong> <?php echo esc_html(implode(', ', wp_list_pluck($package['forms'], 'name'))); ?></p>
                    <p><strong>Pages:</strong> <?php echo esc_html(implode(', ', wp_list_pluck($package['pages'], 'title'))); ?></p>
                    <form method="post">
                        <?php wp_nonce_field('storz_run_installer', 'storz_installer_nonce'); ?>
                        <input type="hidden" name="storz_installer_action" value="<?php echo esc_attr($key); ?>">
                        <button type="submit" class="button button-primary">Install <?php echo esc_html($package['label']); ?></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
