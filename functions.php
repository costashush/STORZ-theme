<?php
/**
 * STORZ Theme v1.0.1
 * All CSS loaded from files — zero raw CSS in PHP strings.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'STORZ_VER', '1.0.1' );
define( 'STORZ_DIR', get_template_directory() );
define( 'STORZ_URL', get_template_directory_uri() );

/* ── HTTPS force (fixes mixed-content on SSL sites) ─────────────── */
if ( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' )
  || ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ) {
    foreach ( [ 'option_siteurl','option_home','plugins_url','theme_root_uri',
        'stylesheet_uri','template_directory_uri','wp_get_attachment_url',
        'get_site_icon_url','site_icon_url','site_url' ] as $filter ) {
        add_filter( $filter, 'storz_force_https' );
    }
    add_filter( 'upload_dir', 'storz_force_https_upload' );
}
function storz_force_https( $url ) {
    return is_string( $url ) ? str_replace( 'http://', 'https://', $url ) : $url;
}
function storz_force_https_upload( $dirs ) {
    foreach ( [ 'url', 'baseurl' ] as $k ) {
        if ( isset( $dirs[$k] ) ) $dirs[$k] = str_replace( 'http://', 'https://', $dirs[$k] );
    }
    return $dirs;
}

/* ── THEME SETUP ─────────────────────────────────────────────────── */
function storz_setup() {
    load_theme_textdomain( 'storz', STORZ_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption' ] );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    register_nav_menus( [ 'primary' => 'Primary Menu', 'footer' => 'Footer Menu' ] );
    add_filter( 'theme_page_templates', function ( $t ) {
        $t['templates/blank.php']               = 'Blank Page';
        $t['templates/form-demo.php']           = 'Form Demo Page';
        $t['templates/landing-contact.php']     = 'Landing — Contact';
        $t['templates/landing-newsletter.php']  = 'Landing — Newsletter';
        $t['templates/landing-event.php']       = 'Landing — Event Registration';
        $t['templates/landing-careers.php']     = 'Landing — Careers';
        return $t;
    } );
}
add_action( 'after_setup_theme', 'storz_setup' );

/* ── FRONTEND ENQUEUE ────────────────────────────────────────────── */
function storz_enqueue() {
    wp_enqueue_style( 'storz-fonts',
        'https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600&family=JetBrains+Mono:wght@400;500&display=swap',
        [], null );
    wp_enqueue_style( 'storz-style', get_stylesheet_uri(), [ 'storz-fonts' ], STORZ_VER );
    wp_enqueue_script( 'storz-main', STORZ_URL . '/js/main.js', [], STORZ_VER, true );
    wp_localize_script( 'storz-main', 'StorzCfg', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'storz_pub' ),
        'theme'   => get_option( 'storz_color_theme', 'dark' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'storz_enqueue' );

/* ── ADMIN ENQUEUE ───────────────────────────────────────────────── */
function storz_admin_enqueue( $hook ) {
    $pages = [ 'toplevel_page_storz','storz_page_storz-forms','storz_page_storz-builder',
        'storz_page_storz-submissions','storz_page_storz-db-manager','storz_page_storz-roles',
        'storz_page_storz-rebranding','storz_page_storz-automation','storz_page_storz-settings' ];
    if ( in_array( $hook, $pages, true ) ) {
        wp_enqueue_style( 'storz-admin-fonts',
            'https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap',
            [], null );
        wp_enqueue_style(  'storz-admin', STORZ_URL . '/admin/admin.css', [ 'storz-admin-fonts' ], STORZ_VER );
        wp_enqueue_script( 'storz-admin', STORZ_URL . '/admin/admin.js', [ 'jquery','jquery-ui-sortable' ], STORZ_VER, true );
        wp_localize_script( 'storz-admin', 'StorzAdmin', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'storz_admin' ),
        ] );
    }
    if ( in_array( $hook, [ 'profile.php', 'user-edit.php', 'storz_page_storz-settings' ], true ) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'storz_admin_enqueue' );

/* ── WP ADMIN RESTYLE (loads from file — no CSS in PHP) ─────────── */
add_action( 'admin_enqueue_scripts', function () {
    wp_enqueue_style( 'storz-wp-admin', STORZ_URL . '/admin/wp-admin.css', [], STORZ_VER );
} );

/* ── LOGIN PAGE RESTYLE (loads from file — no CSS in PHP) ───────── */
add_action( 'login_enqueue_scripts', function () {
    wp_enqueue_style( 'storz-login', STORZ_URL . '/admin/wp-login.css', [], STORZ_VER );
    $logo_id = get_option( 'storz_login_logo_id', '' );
    if ( $logo_id ) {
        // Custom image: set CSS var + body class triggers image display
        $logo_url = esc_url( wp_get_attachment_image_url( $logo_id, 'medium' ) );
        wp_add_inline_style( 'storz-login', "body.login { --sz-logo-url: url('" . $logo_url . "'); } #login h1 a { background-image: url('" . $logo_url . "') !important; background: url('" . $logo_url . "') center/contain no-repeat !important; -webkit-text-fill-color: transparent !important; text-indent: -9999px !important; width: 80px !important; height: 80px !important; }" );
    }
    // else: gradient STORZ text is shown by default from wp-login.css
} );
// When image logo set, add body class
add_filter( 'login_body_class', function ( $classes ) {
    if ( get_option( 'storz_login_logo_id', '' ) ) $classes[] = 'has-logo';
    return $classes;
} );
add_filter( 'login_headertext', function () {
    // Show brand name OR "STORZ" as the link text (shown as gradient text when no image)
    return get_option( 'storz_login_brand_text', get_option( 'storz_brand_name', 'STORZ' ) );
} );
add_filter( 'login_headerurl', function () { return home_url(); } );
add_action( 'login_message', function () {
    $msg = get_option( 'storz_login_message', '' );
    if ( $msg ) echo '<p class="message">' . esc_html( $msg ) . '</p>';
} );

/* ── INJECT CUSTOM CSS (from Rebranding) ────────────────────────── */
add_action( 'wp_head',    'storz_inject_css' );
add_action( 'admin_head', 'storz_inject_css' );
function storz_inject_css() {
    $css = get_option( 'storz_custom_css', '' );
    if ( $css ) {
        echo '<style id="storz-custom">' . wp_strip_all_tags( $css ) . '</style>';
    }
}

/* ── MENU ICON SIZE FIX ──────────────────────────────────────────── */
add_action( 'admin_head', function () {
    echo '<style>#adminmenu #toplevel_page_storz .wp-menu-image img{width:20px!important;height:20px!important;padding:7px 0!important}</style>';
} );

/* ── ADMIN BAR REBRAND ───────────────────────────────────────────── */
add_action( 'admin_bar_menu', function ( $bar ) {
    $label = get_option( 'storz_admin_bar_label', '' );
    if ( $label ) {
        $bar->remove_node( 'wp-logo' );
        $bar->add_node( [ 'id' => 'storz-logo', 'title' => esc_html( $label ), 'href' => admin_url() ] );
    }
}, 11 );

/* ── DATABASE TABLES ─────────────────────────────────────────────── */
function storz_create_tables() {
    global $wpdb;
    $c = $wpdb->get_charset_collate();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( "CREATE TABLE {$wpdb->prefix}storz_forms (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL DEFAULT '',
  description text,
  fields longtext NOT NULL,
  settings longtext NOT NULL,
  status varchar(20) NOT NULL DEFAULT 'active',
  created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) $c;" );
    dbDelta( "CREATE TABLE {$wpdb->prefix}storz_submissions (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  form_id bigint(20) unsigned NOT NULL DEFAULT 0,
  data longtext NOT NULL,
  ip_address varchar(45) DEFAULT '',
  user_agent varchar(500) DEFAULT '',
  status varchar(20) NOT NULL DEFAULT 'unread',
  created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id),
  KEY form_id (form_id)
) $c;" );
    dbDelta( "CREATE TABLE {$wpdb->prefix}storz_automation_log (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  channel varchar(20) NOT NULL DEFAULT '',
  recipient varchar(255) DEFAULT '',
  subject varchar(500) DEFAULT '',
  message text,
  status varchar(20) NOT NULL DEFAULT 'sent',
  created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) $c;" );
    update_option( 'storz_db_version', STORZ_VER );
    storz_seed_demo_forms();
    storz_seed_demo_pages();
}
add_action( 'after_switch_theme', 'storz_create_tables' );
add_action( 'admin_init', function () {
    if ( get_option( 'storz_db_version' ) !== STORZ_VER ) {
        storz_create_tables();
    }
} );

/* ── SEED DEMO FORMS ─────────────────────────────────────────────── */
function storz_seed_demo_forms() {
    global $wpdb;
    $t = $wpdb->prefix . 'storz_forms';
    if ( ! $wpdb->get_var( "SHOW TABLES LIKE '$t'" ) ) return;
    if ( (int) $wpdb->get_var( "SELECT COUNT(*) FROM $t" ) > 0 ) return;
    $ae = get_option( 'admin_email' );
    $demos = [
        [ 'Contact Us', 'General enquiries — 2-column name row.',
          '[{"id":"1","type":"row","cols":2,"children":[{"id":"1a","type":"text","label":"First Name","placeholder":"Jane","required":true,"hint":"","options":[]},{"id":"1b","type":"text","label":"Last Name","placeholder":"Doe","required":true,"hint":"","options":[]}]},{"id":"2","type":"email","label":"Email","placeholder":"jane@example.com","required":true,"hint":"","options":[]},{"id":"3","type":"tel","label":"Phone","placeholder":"+1 555 000 0000","required":false,"hint":"Optional","options":[]},{"id":"4","type":"select","label":"Subject","placeholder":"","required":true,"hint":"","options":["General Inquiry","Support","Partnership","Other"]},{"id":"5","type":"textarea","label":"Message","placeholder":"How can we help?","required":true,"hint":"","options":[],"rows":5}]',
          '{"submit_label":"Send Message","success_message":"Thanks! We\'ll reply within 24 hours.","notification_email":"' . $ae . '","gmail_enabled":"0"}' ],
        [ 'Newsletter Signup', '2-column row + preferences.',
          '[{"id":"1","type":"row","cols":2,"children":[{"id":"1a","type":"text","label":"First Name","placeholder":"Jane","required":true,"hint":"","options":[]},{"id":"1b","type":"email","label":"Email","placeholder":"jane@example.com","required":true,"hint":"","options":[]}]},{"id":"2","type":"radio","label":"Frequency","placeholder":"","required":true,"hint":"","options":["Daily","Weekly","Bi-weekly","Monthly"]},{"id":"3","type":"checkbox","label":"Interests","placeholder":"","required":false,"hint":"","options":["Technology","Design","Business","Marketing"]}]',
          '{"submit_label":"Subscribe","success_message":"You\'re subscribed!","notification_email":"' . $ae . '","gmail_enabled":"0"}' ],
        [ 'Support Ticket', '3-column + 2-column priority row.',
          '[{"id":"1","type":"row","cols":3,"children":[{"id":"1a","type":"text","label":"Name","placeholder":"","required":true,"hint":"","options":[]},{"id":"1b","type":"email","label":"Email","placeholder":"","required":true,"hint":"","options":[]},{"id":"1c","type":"tel","label":"Phone","placeholder":"","required":false,"hint":"","options":[]}]},{"id":"2","type":"row","cols":2,"children":[{"id":"2a","type":"select","label":"Priority","placeholder":"","required":true,"hint":"","options":["Low","Medium","High","Critical"]},{"id":"2b","type":"select","label":"Category","placeholder":"","required":true,"hint":"","options":["Bug Report","Feature Request","Account","Billing"]}]},{"id":"3","type":"text","label":"Summary","placeholder":"","required":true,"hint":"","options":[]},{"id":"4","type":"textarea","label":"Details","placeholder":"Describe the issue...","required":true,"hint":"","options":[],"rows":6}]',
          '{"submit_label":"Submit Ticket","success_message":"Ticket submitted!","notification_email":"' . $ae . '","gmail_enabled":"0"}' ],
        [ 'Event Registration', '2-column rows + dietary + rating.',
          '[{"id":"1","type":"row","cols":2,"children":[{"id":"1a","type":"text","label":"Full Name","placeholder":"","required":true,"hint":"","options":[]},{"id":"1b","type":"email","label":"Email","placeholder":"","required":true,"hint":"","options":[]}]},{"id":"2","type":"row","cols":2,"children":[{"id":"2a","type":"number","label":"Guests","placeholder":"1","required":true,"hint":"Max 5","options":[]},{"id":"2b","type":"tel","label":"Phone","placeholder":"","required":false,"hint":"","options":[]}]},{"id":"3","type":"radio","label":"Session","placeholder":"","required":true,"hint":"","options":["Morning (9am-12pm)","Afternoon (1pm-5pm)","Evening (6pm-9pm)"]},{"id":"4","type":"checkbox","label":"Dietary Needs","placeholder":"","required":false,"hint":"","options":["Vegetarian","Vegan","Gluten-free","Halal","Kosher"]},{"id":"5","type":"rating","label":"Excitement level","placeholder":"","required":false,"hint":"","options":[]}]',
          '{"submit_label":"Register Now","success_message":"Registration confirmed!","notification_email":"' . $ae . '","gmail_enabled":"0"}' ],
        [ 'Job Application', '3x two-column rows + rating.',
          '[{"id":"1","type":"row","cols":2,"children":[{"id":"1a","type":"text","label":"First Name","placeholder":"","required":true,"hint":"","options":[]},{"id":"1b","type":"text","label":"Last Name","placeholder":"","required":true,"hint":"","options":[]}]},{"id":"2","type":"row","cols":2,"children":[{"id":"2a","type":"email","label":"Email","placeholder":"","required":true,"hint":"","options":[]},{"id":"2b","type":"tel","label":"Phone","placeholder":"","required":true,"hint":"","options":[]}]},{"id":"3","type":"row","cols":2,"children":[{"id":"3a","type":"select","label":"Position","placeholder":"","required":true,"hint":"","options":["Frontend Developer","Backend Developer","Designer","Product Manager","Other"]},{"id":"3b","type":"select","label":"Experience","placeholder":"","required":true,"hint":"","options":["Junior (0-2 yrs)","Mid (2-5 yrs)","Senior (5-10 yrs)","Lead (10+ yrs)"]}]},{"id":"4","type":"url","label":"Portfolio / LinkedIn","placeholder":"https://","required":false,"hint":"","options":[]},{"id":"5","type":"checkbox","label":"Work Preferences","placeholder":"","required":false,"hint":"","options":["Remote","Hybrid","On-site","Full-time","Part-time"]},{"id":"6","type":"textarea","label":"Cover Letter","placeholder":"Why are you a great fit?","required":true,"hint":"","options":[],"rows":6},{"id":"7","type":"rating","label":"How much do you want this role?","placeholder":"","required":false,"hint":"","options":[]}]',
          '{"submit_label":"Submit Application","success_message":"Application received! We\'ll be in touch within 5 business days.","notification_email":"' . $ae . '","gmail_enabled":"0"}' ],
    ];
    foreach ( $demos as [ $name, $desc, $fields, $settings ] ) {
        $wpdb->insert( $t, [ 'name' => $name, 'description' => $desc, 'fields' => $fields, 'settings' => $settings, 'status' => 'active' ] );
    }
}

/* ── SEED DEMO PAGES ─────────────────────────────────────────────── */
function storz_seed_demo_pages() {
    if ( get_option( 'storz_pages_seeded' ) ) return;
    $pages = [
        [ 'Contact Us',        'contact',    'templates/landing-contact.php',    '' ],
        [ 'Newsletter',        'newsletter', 'templates/landing-newsletter.php', '' ],
        [ 'STORZ Summit 2025', 'event',      'templates/landing-event.php',      '' ],
        [ 'Careers',           'careers',    'templates/landing-careers.php',    '' ],
        [ 'Form Demo',         'forms',      'templates/form-demo.php',          'Explore all available forms below.' ],
    ];
    foreach ( $pages as [ $title, $slug, $tpl, $content ] ) {
        if ( get_page_by_path( $slug ) ) continue;
        $id = wp_insert_post( [ 'post_title' => $title, 'post_name' => $slug, 'post_status' => 'publish', 'post_type' => 'page', 'post_content' => $content, 'post_author' => 1 ] );
        if ( $id && ! is_wp_error( $id ) ) update_post_meta( $id, '_wp_page_template', $tpl );
    }
    update_option( 'storz_pages_seeded', '1' );
}
add_action( 'admin_init', function () {
    if ( ! get_option( 'storz_pages_seeded' ) ) storz_seed_demo_pages();
} );

/* ── ADMIN MENU ──────────────────────────────────────────────────── */
function storz_admin_menu() {
    $svg = 'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><text y="16" font-size="16">🦋</text></svg>' );
    add_menu_page( 'STORZ', 'STORZ', 'manage_options', 'storz', 'storz_route_page', $svg, 3 );
    foreach ( [
        [ 'storz',             '🏠 Dashboard'  ],
        [ 'storz-forms',       '📋 Forms'       ],
        [ 'storz-builder',     '✚ Builder'      ],
        [ 'storz-submissions', '📥 Submissions' ],
        [ 'storz-db-manager',  '🗄 DB Manager'  ],
        [ 'storz-roles',       '👤 Roles'        ],
        [ 'storz-rebranding',  '🎨 Rebranding'  ],
        [ 'storz-automation',  '🤖 Automation'  ],
        [ 'storz-settings',    '⚙️ Settings'     ],
    ] as [ $slug, $label ] ) {
        add_submenu_page( 'storz', $label, $label, 'manage_options', $slug, 'storz_route_page' );
    }
}
add_action( 'admin_menu', 'storz_admin_menu' );

function storz_route_page() {
    $map = [
        'storz'             => 'page-dashboard.php',
        'storz-forms'       => 'page-forms.php',
        'storz-builder'     => 'page-builder.php',
        'storz-submissions' => 'page-submissions.php',
        'storz-db-manager'  => 'page-db-manager.php',
        'storz-roles'       => 'page-roles.php',
        'storz-rebranding'  => 'page-rebranding.php',
        'storz-automation'  => 'page-automation.php',
        'storz-settings'    => 'page-settings.php',
    ];
    $page = sanitize_key( $_GET['page'] ?? 'storz' );
    $file = STORZ_DIR . '/admin/' . ( $map[$page] ?? 'page-dashboard.php' );
    if ( file_exists( $file ) ) include $file;
}

/* ── WP DASHBOARD WIDGETS ────────────────────────────────────────── */
add_action( 'wp_dashboard_setup', function () {
    wp_add_dashboard_widget( 'storz_overview',  '🦋 STORZ Overview',    'storz_widget_overview'  );
    wp_add_dashboard_widget( 'storz_pages_w',   '🗂 Demo Pages',         'storz_widget_pages'     );
    wp_add_dashboard_widget( 'storz_hardware',  '🖥️ Server Info',        'storz_widget_hardware'  );
    wp_add_dashboard_widget( 'storz_forms_w',   '📋 Top Forms',          'storz_widget_forms'     );
    wp_add_dashboard_widget( 'storz_auto_w',    '🤖 Automation Log',     'storz_widget_automation');
} );

function storz_widget_overview() {
    global $wpdb;
    $f  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}storz_forms" );
    $s  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}storz_submissions" );
    $td = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}storz_submissions WHERE DATE(created_at)=CURDATE()" );
    $r  = count( get_editable_roles() );
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px">';
    foreach ( [ ['📋','Forms',$f],['📥','Submissions',$s],['📆','Today',$td],['👤','Roles',$r] ] as [ $i,$l,$v ] ) {
        echo '<div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px;text-align:center">';
        echo '<div style="font-size:1.3rem">' . $i . '</div>';
        echo '<div style="font-size:1.5rem;font-weight:800;color:#7c3aed">' . $v . '</div>';
        echo '<div style="font-size:.72rem;color:#64748b;text-transform:uppercase;letter-spacing:.05em">' . $l . '</div>';
        echo '</div>';
    }
    echo '</div><p style="font-size:.82rem"><a href="' . esc_url( admin_url( 'admin.php?page=storz' ) ) . '">→ Open Dashboard</a></p>';
}

function storz_widget_pages() {
    $demo_pages = [
        ['Contact Us','contact','📬'],['Newsletter','newsletter','📰'],
        ['STORZ Summit','event','📅'],['Careers','careers','🚀'],['Form Demo','forms','📋'],
    ];
    echo '<table style="width:100%;font-size:.82rem;border-collapse:collapse">';
    foreach ( $demo_pages as [ $title, $slug, $icon ] ) {
        $page = get_page_by_path( $slug );
        echo '<tr style="border-bottom:1px solid #e2e8f0"><td style="padding:5px 0;width:24px">' . $icon . '</td>';
        echo '<td style="padding:5px 4px;font-weight:600;color:#0f172a">' . esc_html( $title ) . '</td>';
        if ( $page ) {
            echo '<td style="padding:5px 0;text-align:right">';
            echo '<a href="' . esc_url( get_permalink( $page->ID ) ) . '" target="_blank" style="color:#7c3aed;margin-right:8px">View</a>';
            echo '<a href="' . esc_url( get_edit_post_link( $page->ID ) ) . '" style="color:#64748b">Edit</a>';
            echo '</td>';
        } else {
            echo '<td style="padding:5px 0;text-align:right;color:#94a3b8;font-size:.76rem">Pending</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function storz_widget_hardware() {
    global $wpdb;
    $db_size = $wpdb->get_var( "SELECT ROUND(SUM(data_length+index_length)/1024/1024,2) FROM information_schema.tables WHERE table_schema=DATABASE()" );
    $rows = [
        ['OS', php_uname('s') . ' ' . php_uname('r')],
        ['PHP', PHP_VERSION],
        ['Memory Limit', ini_get('memory_limit')],
        ['Memory Used', round(memory_get_usage(true)/1048576,1) . ' MB'],
        ['MySQL', $wpdb->db_version()],
        ['DB Size', $db_size . ' MB'],
        ['WP Version', get_bloginfo('version')],
        ['WP Debug', defined('WP_DEBUG') && WP_DEBUG ? '<span style="color:#ef4444">ON</span>' : '<span style="color:#10b981">OFF</span>'],
    ];
    echo '<table style="width:100%;font-size:.8rem;border-collapse:collapse">';
    foreach ( $rows as [ $k, $v ] ) {
        echo '<tr style="border-bottom:1px solid #e2e8f0"><td style="padding:5px 0;font-weight:600;color:#64748b;width:42%">' . esc_html($k) . '</td><td style="padding:5px 0;color:#0f172a">' . $v . '</td></tr>';
    }
    echo '</table>';
}

function storz_widget_forms() {
    global $wpdb;
    $rows = $wpdb->get_results( "SELECT f.id,f.name,COUNT(s.id) AS cnt FROM {$wpdb->prefix}storz_forms f LEFT JOIN {$wpdb->prefix}storz_submissions s ON f.id=s.form_id GROUP BY f.id ORDER BY cnt DESC LIMIT 5" );
    if ( ! $rows ) { echo '<p style="color:#64748b;font-size:.83rem">No forms yet. <a href="' . esc_url( admin_url('admin.php?page=storz-builder') ) . '">Create one →</a></p>'; return; }
    echo '<table style="width:100%;font-size:.82rem;border-collapse:collapse">';
    foreach ( $rows as $f ) {
        echo '<tr style="border-bottom:1px solid #e2e8f0"><td style="padding:6px 0">' . esc_html($f->name) . '</td>';
        echo '<td style="text-align:right;padding:6px 0"><a href="' . esc_url( admin_url('admin.php?page=storz-submissions&form_id='.$f->id) ) . '" style="font-weight:700;color:#7c3aed">' . $f->cnt . '</a></td></tr>';
    }
    echo '</table>';
}

function storz_widget_automation() {
    global $wpdb;
    $logs = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}storz_automation_log ORDER BY created_at DESC LIMIT 5" );
    if ( ! $logs ) { echo '<p style="color:#64748b;font-size:.83rem">No messages sent yet.</p>'; return; }
    echo '<table style="width:100%;font-size:.8rem;border-collapse:collapse">';
    foreach ( $logs as $l ) {
        $sc = $l->status === 'sent' ? '#10b981' : '#ef4444';
        echo '<tr style="border-bottom:1px solid #e2e8f0">';
        echo '<td style="padding:5px 0"><span style="font-size:.7rem;font-weight:700;padding:2px 7px;border-radius:100px;background:#ede9fe;color:#5b21b6">' . esc_html($l->channel) . '</span></td>';
        echo '<td style="padding:5px 4px;font-size:.79rem;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">' . esc_html($l->recipient) . '</td>';
        echo '<td style="text-align:right"><span style="color:' . $sc . ';font-weight:700">' . esc_html($l->status) . '</span></td></tr>';
    }
    echo '</table>';
}

/* ── HELPERS ─────────────────────────────────────────────────────── */
function storz_get_forms( $args = [] ) {
    global $wpdb;
    $a = wp_parse_args( $args, [ 'status' => 'active', 'limit' => 100, 'offset' => 0 ] );
    $w = $a['status'] !== 'all' ? $wpdb->prepare( 'WHERE status=%s', $a['status'] ) : '';
    return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}storz_forms $w ORDER BY created_at DESC LIMIT %d OFFSET %d", $a['limit'], $a['offset'] ) );
}
function storz_get_form( $id ) {
    global $wpdb;
    return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}storz_forms WHERE id=%d", $id ) );
}
function storz_count_submissions( $form_id = 0 ) {
    global $wpdb;
    return $form_id
        ? (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}storz_submissions WHERE form_id=%d", $form_id ) )
        : (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}storz_submissions" );
}
function storz_get_submissions( $form_id = 0, $limit = 100 ) {
    global $wpdb;
    $w = $form_id ? $wpdb->prepare( 'WHERE s.form_id=%d', $form_id ) : '';
    return $wpdb->get_results( $wpdb->prepare( "SELECT s.*,f.name AS form_name FROM {$wpdb->prefix}storz_submissions s LEFT JOIN {$wpdb->prefix}storz_forms f ON s.form_id=f.id $w ORDER BY s.created_at DESC LIMIT %d", $limit ) );
}

function storz_nav( $active = '' ) {
    $brand = esc_html( get_option( 'storz_brand_name', 'STORZ' ) );
    $logo  = esc_url( STORZ_URL . '/images/logo.png' );
    $links = [
        'storz'             => '🏠 Dashboard',
        'storz-forms'       => '📋 Forms',
        'storz-builder'     => '✚ Builder',
        'storz-submissions' => '📥 Submissions',
        'storz-db-manager'  => '🗄 DB Manager',
        'storz-roles'       => '👤 Roles',
        'storz-rebranding'  => '🎨 Rebranding',
        'storz-automation'  => '🤖 Automation',
        'storz-settings'    => '⚙️ Settings',
    ];
    echo '<div id="storz-app">';
    echo '<div class="sz-topbar"><div class="sz-brand">';
    echo '<div class="sz-brand-logo"><img src="' . $logo . '" alt="STORZ" width="36" height="36"></div>';
    echo '<div><div class="sz-brand-name">' . $brand . '</div><div class="sz-brand-sub">Suite v' . STORZ_VER . '</div></div></div>';
    echo '<a href="' . esc_url( admin_url( 'admin.php?page=storz-builder' ) ) . '" class="sz-btn sz-btn-primary" style="font-size:.8rem">+ New Form</a>';
    echo '</div><nav class="sz-nav" role="navigation">';
    $subs_count = storz_count_submissions();
    foreach ( $links as $slug => $label ) {
        $url   = esc_url( admin_url( 'admin.php?page=' . $slug ) );
        $cls   = $active === $slug ? ' class="active" aria-current="page"' : '';
        $badge = $slug === 'storz-submissions' ? '<span class="sz-nb">' . $subs_count . '</span>' : '';
        echo '<a href="' . $url . '"' . $cls . '>' . $label . ' ' . $badge . '</a>';
    }
    echo '</nav>';
}
function storz_nav_end() { echo '</div>'; }

/* ── AJAX: SAVE FORM ─────────────────────────────────────────────── */
add_action( 'wp_ajax_storz_save_form', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Permission denied' );
    if ( get_option( 'storz_db_version' ) !== STORZ_VER ) storz_create_tables();
    global $wpdb; $t = $wpdb->prefix . 'storz_forms';
    $id   = absint( $_POST['form_id'] ?? 0 );
    $name = sanitize_text_field( wp_unslash( $_POST['name'] ?? 'Untitled' ) );
    $desc = sanitize_textarea_field( wp_unslash( $_POST['description'] ?? '' ) );
    $flds = wp_unslash( $_POST['fields'] ?? '[]' );
    $sets = wp_unslash( $_POST['settings'] ?? '{}' );
    json_decode( $flds ); if ( json_last_error() ) $flds = '[]';
    json_decode( $sets ); if ( json_last_error() ) $sets = '{}';
    $data = [ 'name' => $name, 'description' => $desc, 'fields' => $flds, 'settings' => $sets ];
    if ( $id ) { $wpdb->update( $t, $data, [ 'id' => $id ] ); } else { $wpdb->insert( $t, $data ); $id = $wpdb->insert_id; }
    wp_send_json_success( [ 'id' => $id ] );
} );

/* ── AJAX: DELETE FORM ───────────────────────────────────────────── */
add_action( 'wp_ajax_storz_delete_form', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Permission denied' );
    global $wpdb; $id = absint( $_POST['form_id'] ?? 0 );
    if ( ! $id ) wp_send_json_error( 'Bad ID' );
    $wpdb->delete( $wpdb->prefix . 'storz_forms', [ 'id' => $id ] );
    $wpdb->delete( $wpdb->prefix . 'storz_submissions', [ 'form_id' => $id ] );
    wp_send_json_success( [ 'message' => 'Deleted.' ] );
} );

/* ── AJAX: RESEED FORMS ──────────────────────────────────────────── */
add_action( 'wp_ajax_storz_reseed_forms', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can( 'manage_options' ) ) wp_send_json_error( 'Permission denied' );
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->prefix}storz_forms" );
    $wpdb->query( "DELETE FROM {$wpdb->prefix}storz_submissions" );
    delete_option( 'storz_db_version' );
    storz_create_tables();
    wp_send_json_success( [ 'message' => 'Demo forms re-seeded! Reloading…' ] );
} );

/* ── AJAX: SUBMIT FORM (public) ──────────────────────────────────── */
function storz_handle_submit() {
    check_ajax_referer( 'storz_pub', 'nonce' );
    global $wpdb;
    $form_id = absint( $_POST['form_id'] ?? 0 );
    if ( ! $form_id ) wp_send_json_error( [ 'message' => 'Invalid form.' ] );
    $form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}storz_forms WHERE id=%d AND status='active'", $form_id ) );
    if ( ! $form ) wp_send_json_error( [ 'message' => 'Form not found.' ] );
    $fields   = json_decode( $form->fields, true ) ?: [];
    $settings = json_decode( $form->settings, true ) ?: [];
    $flat = [];
    foreach ( $fields as $f ) {
        if ( $f['type'] === 'row' ) { foreach ( $f['children'] ?? [] as $c ) $flat[] = $c; }
        else $flat[] = $f;
    }
    $submitted = []; $errors = [];
    foreach ( $flat as $f ) {
        $key = 'field_' . $f['id'];
        $val = isset( $_POST[$key] ) ? wp_unslash( $_POST[$key] ) : '';
        if ( is_array($val) ) $val = array_map( 'sanitize_text_field', $val );
        else $val = $f['type'] === 'textarea' ? sanitize_textarea_field($val) : sanitize_text_field($val);
        if ( ! empty($f['required']) && ( is_array($val) ? empty($val) : trim($val) === '' ) )
            $errors[$f['id']] = $f['label'] . ' is required.';
        $submitted[$f['label']] = $val;
    }
    if ( $errors ) wp_send_json_error( [ 'errors' => $errors ] );
    $wpdb->insert( $wpdb->prefix . 'storz_submissions', [
        'form_id' => $form_id, 'data' => wp_json_encode($submitted),
        'ip_address' => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
        'user_agent' => sanitize_text_field(substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500)),
    ] );
    $notify = $settings['notification_email'] ?? '';
    if ( $notify ) {
        $body = "New submission: {$form->name}\n\n";
        foreach ( $submitted as $l => $v ) $body .= "$l: " . ( is_array($v) ? implode(', ',$v) : $v ) . "\n";
        wp_mail( sanitize_email($notify), 'New submission: ' . $form->name, $body );
        if ( ! empty($settings['gmail_enabled']) && $settings['gmail_enabled'] === '1' ) {
            storz_send_gmail( $notify, 'New submission: ' . $form->name, $body );
        }
    }
    wp_send_json_success( [ 'message' => $settings['success_message'] ?? 'Thank you! Your submission has been received.' ] );
}
add_action( 'wp_ajax_storz_submit',        'storz_handle_submit' );
add_action( 'wp_ajax_nopriv_storz_submit', 'storz_handle_submit' );

/* ── GMAIL ───────────────────────────────────────────────────────── */
function storz_send_gmail( $to, $subject, $body ) {
    $token = get_option( 'storz_gmail_access_token', '' );
    $from  = get_option( 'storz_gmail_from_email', '' );
    if ( ! $token || ! $from || ! $to ) return false;
    $raw = "From: $from\r\nTo: $to\r\nSubject: $subject\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n$body";
    $enc = rtrim( strtr( base64_encode($raw), '+/', '-_' ), '=' );
    $r   = wp_remote_post( 'https://gmail.googleapis.com/gmail/v1/users/me/messages/send', [
        'headers' => [ 'Authorization' => "Bearer $token", 'Content-Type' => 'application/json' ],
        'body'    => wp_json_encode( [ 'raw' => $enc ] ), 'timeout' => 15,
    ] );
    return ! is_wp_error($r) && wp_remote_retrieve_response_code($r) === 200;
}
add_action( 'admin_init', function () {
    if ( ! isset($_GET['storz_gmail_code']) || ! current_user_can('manage_options') ) return;
    $r = wp_remote_post( 'https://oauth2.googleapis.com/token', [ 'body' => [
        'code'          => sanitize_text_field($_GET['storz_gmail_code']),
        'client_id'     => get_option('storz_gmail_client_id',''),
        'client_secret' => get_option('storz_gmail_client_secret',''),
        'redirect_uri'  => admin_url('admin.php?page=storz-automation'),
        'grant_type'    => 'authorization_code',
    ] ] );
    if ( ! is_wp_error($r) ) {
        $d = json_decode( wp_remote_retrieve_body($r), true );
        if ( ! empty($d['access_token']) ) {
            update_option( 'storz_gmail_access_token', $d['access_token'] );
            if ( ! empty($d['refresh_token']) ) update_option( 'storz_gmail_refresh_token', $d['refresh_token'] );
            $me = wp_remote_get( 'https://www.googleapis.com/oauth2/v2/userinfo', [ 'headers' => [ 'Authorization' => "Bearer {$d['access_token']}" ] ] );
            if ( ! is_wp_error($me) ) { $md = json_decode( wp_remote_retrieve_body($me), true ); update_option( 'storz_gmail_from_email', $md['email'] ?? '' ); }
        }
    }
    wp_safe_redirect( admin_url('admin.php?page=storz-automation&gmail=connected') ); exit;
} );

/* ── AJAX: EXPORT FORMS ──────────────────────────────────────────── */
add_action( 'wp_ajax_storz_export_forms', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can('manage_options') ) wp_send_json_error('Permission denied');
    global $wpdb;
    $ids  = isset($_POST['ids']) ? array_map('absint',(array)$_POST['ids']) : [];
    $forms = $ids
        ? $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}storz_forms WHERE id IN(" . implode(',',array_fill(0,count($ids),'%d')) . ")", ...$ids ), ARRAY_A )
        : $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}storz_forms", ARRAY_A );
    wp_send_json_success( [ 'json' => wp_json_encode( [ 'storz_version' => STORZ_VER, 'exported_at' => current_time('mysql'), 'forms' => $forms ], JSON_PRETTY_PRINT ) ] );
} );

/* ── AJAX: IMPORT FORMS ──────────────────────────────────────────── */
add_action( 'wp_ajax_storz_import_forms', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can('manage_options') ) wp_send_json_error('Permission denied');
    global $wpdb; $t = $wpdb->prefix . 'storz_forms';
    $data = json_decode( wp_unslash($_POST['import_json'] ?? ''), true );
    if ( json_last_error() || empty($data['forms']) ) wp_send_json_error('Invalid JSON or no forms found.');
    $count = 0;
    foreach ( $data['forms'] as $f ) {
        unset( $f['id'], $f['created_at'], $f['updated_at'] );
        $f['name']   = sanitize_text_field($f['name'] ?? 'Imported Form');
        $f['status'] = 'active';
        $wpdb->insert( $t, $f ); $count++;
    }
    wp_send_json_success( [ 'message' => "$count form(s) imported." ] );
} );

/* ── AJAX: EXPORT CSV ────────────────────────────────────────────── */
add_action( 'wp_ajax_storz_export_csv', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can('manage_options') ) wp_send_json_error('Permission denied');
    global $wpdb;
    $form_id = absint( $_POST['form_id'] ?? 0 );
    $w       = $form_id ? $wpdb->prepare('WHERE form_id=%d',$form_id) : '';
    $rows    = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}storz_submissions $w ORDER BY created_at DESC", ARRAY_A );
    if ( ! $rows ) { wp_send_json_error('No submissions found.'); return; }
    $all_keys = ['id','form_id','ip_address','created_at'];
    foreach ( $rows as $r ) { $d = json_decode($r['data'],true)?:[]; foreach(array_keys($d) as $k) if(!in_array($k,$all_keys)) $all_keys[]=$k; }
    $csv = implode(',',array_map(fn($k)=>'"'.str_replace('"','""',$k).'"',$all_keys))."\n";
    foreach ( $rows as $r ) {
        $d = json_decode($r['data'],true)?:[];
        $line = [];
        foreach($all_keys as $k){
            $v = isset($r[$k]) ? $r[$k] : (isset($d[$k]) ? (is_array($d[$k])?implode('|',$d[$k]):$d[$k]) : '');
            $line[] = '"'.str_replace('"','""',$v).'"';
        }
        $csv .= implode(',',$line)."\n";
    }
    wp_send_json_success( [ 'csv' => $csv, 'filename' => 'submissions-'.date('Y-m-d').'.csv' ] );
} );

/* ── AJAX: DB MANAGER ────────────────────────────────────────────── */
add_action( 'wp_ajax_storz_db', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can('manage_options') ) wp_send_json_error('Permission denied');
    global $wpdb; $act = sanitize_key($_POST['db_action'] ?? 'list');
    if ( $act === 'list' ) { wp_send_json_success(['tables'=>$wpdb->get_col('SHOW TABLES')]); }
    if ( $act === 'rows' ) {
        $table=$wpdb->esc_like(sanitize_key($_POST['table']??'')); $page=max(1,absint($_POST['page']??1)); $per=25; $offset=($page-1)*$per;
        $rows=$wpdb->get_results($wpdb->prepare("SELECT * FROM `$table` LIMIT %d OFFSET %d",$per,$offset),ARRAY_A);
        wp_send_json_success(['rows'=>$rows,'cols'=>array_keys($rows[0]??[]),'total'=>(int)$wpdb->get_var("SELECT COUNT(*) FROM `$table`"),'page'=>$page,'per'=>$per]);
    }
    if ( $act === 'delete_row' ) {
        $table=sanitize_key($_POST['table']??''); $pk=sanitize_key($_POST['pk']??'id'); $val=sanitize_text_field($_POST['val']??'');
        $wpdb->query($wpdb->prepare("DELETE FROM `$table` WHERE `$pk`=%s LIMIT 1",$val));
        wp_send_json_success(['message'=>'Row deleted']);
    }
} );

/* ── AJAX: SEND MESSAGE ──────────────────────────────────────────── */
add_action( 'wp_ajax_storz_send', function () {
    check_ajax_referer( 'storz_admin', 'nonce' );
    if ( ! current_user_can('manage_options') ) wp_send_json_error('Permission denied');
    global $wpdb;
    $channel   = sanitize_key($_POST['channel']??'email');
    $recipient = sanitize_text_field($_POST['recipient']??'');
    $subject   = sanitize_text_field($_POST['subject']??'');
    $message   = sanitize_textarea_field($_POST['message']??'');
    $status    = 'failed';
    if ( $channel==='email' && $recipient && $message ) {
        $status = wp_mail($recipient,$subject?:'STORZ Message',$message) ? 'sent' : 'failed';
    } elseif ( $channel==='gmail' && $recipient && $message ) {
        $status = storz_send_gmail($recipient,$subject,$message) ? 'sent' : 'failed';
    } elseif ( $channel==='whatsapp' ) {
        $tok=$wpdb->get_option('storz_wa_token',''); $pid=get_option('storz_wa_phone_id','');
        if ( $tok && $pid && $recipient && $message ) {
            $r=wp_remote_post("https://graph.facebook.com/v18.0/{$pid}/messages",['headers'=>['Authorization'=>"Bearer $tok",'Content-Type'=>'application/json'],'body'=>wp_json_encode(['messaging_product'=>'whatsapp','to'=>$recipient,'type'=>'text','text'=>['body'=>$message]]),'timeout'=>15]);
            $status=(!is_wp_error($r)&&wp_remote_retrieve_response_code($r)===200)?'sent':'failed';
        }
    }
    $wpdb->insert($wpdb->prefix.'storz_automation_log',compact('channel','recipient','subject','message','status'));
    if($status==='sent') wp_send_json_success(['message'=>'Sent!']); else wp_send_json_error('Failed — check settings.');
} );

/* ── AJAX: ROLES ─────────────────────────────────────────────────── */
add_action('wp_ajax_storz_save_role',function(){
    check_ajax_referer('storz_admin','nonce'); if(!current_user_can('manage_options'))wp_send_json_error('Permission denied');
    $key=sanitize_key($_POST['role_key']??''); $name=sanitize_text_field($_POST['display_name']??'');
    if(!$key||!$name)wp_send_json_error('Key and name required.');
    $caps=[];foreach((array)($_POST['caps']??[]) as $c)$caps[sanitize_key($c)]=true;
    foreach(explode("\n",wp_unslash($_POST['extra_caps']??'')) as $c){$c=sanitize_key(trim($c));if($c)$caps[$c]=true;}
    $ex=get_role($key);
    if($ex){$ex->capabilities=$caps;$msg="Role '$name' updated.";}else{add_role($key,$name,$caps);$msg="Role '$name' created.";}
    wp_send_json_success(['message'=>$msg]);
});
add_action('wp_ajax_storz_delete_role',function(){
    check_ajax_referer('storz_admin','nonce'); if(!current_user_can('manage_options'))wp_send_json_error('Permission denied');
    $key=sanitize_key($_POST['role_key']??'');
    if($key==='administrator')wp_send_json_error('Cannot delete administrator.');
    remove_role($key); wp_send_json_success(['message'=>"Role '$key' deleted."]);
});

/* ── AJAX: BRANDING ──────────────────────────────────────────────── */
add_action('wp_ajax_storz_save_brand',function(){
    check_ajax_referer('storz_admin','nonce'); if(!current_user_can('manage_options'))wp_send_json_error('Permission denied');
    foreach(['storz_brand_name','storz_brand_tagline','storz_brand_email','storz_brand_phone','storz_brand_address','storz_admin_bar_label','storz_login_message','storz_brand_footer_text','storz_brand_color_primary','storz_brand_color_accent'] as $o)
        update_option($o,sanitize_text_field(wp_unslash($_POST[$o]??'')));
    if(isset($_POST['storz_custom_css']))update_option('storz_custom_css',wp_strip_all_tags(wp_unslash($_POST['storz_custom_css'])));
    wp_send_json_success(['message'=>'Branding saved!']);
});

/* ── AJAX: LOGIN LOGO ────────────────────────────────────────────── */
add_action('wp_ajax_storz_save_login_logo',function(){
    check_ajax_referer('storz_admin','nonce'); if(!current_user_can('manage_options'))wp_send_json_error('Permission denied');
    $id=absint($_POST['logo_id']??0);
    if($id)update_option('storz_login_logo_id',$id); else delete_option('storz_login_logo_id');
    wp_send_json_success(['message'=>'Login logo saved!']);
});

/* ── AJAX: THEME TOGGLE ──────────────────────────────────────────── */
add_action('wp_ajax_storz_set_theme',function(){
    check_ajax_referer('storz_pub','nonce');
    $t=sanitize_key($_POST['theme']??'dark');
    if(in_array($t,['dark','light'],true))update_option('storz_color_theme',$t);
    wp_send_json_success();
});
add_action('wp_ajax_nopriv_storz_set_theme',function(){wp_send_json_error('Login required');});

/* ── USER AVATARS ────────────────────────────────────────────────── */
add_action('show_user_profile','storz_avatar_field');
add_action('edit_user_profile','storz_avatar_field');
function storz_avatar_field($user){
    $aid=get_user_meta($user->ID,'storz_avatar_id',true);
    $aurl=$aid?wp_get_attachment_image_url($aid,'thumbnail'):'';
    echo '<h3>STORZ Avatar</h3><table class="form-table"><tr><th><label>Custom Avatar</label></th><td>';
    if($aurl)echo '<img src="'.esc_url($aurl).'" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:12px;display:block">';
    echo '<input type="hidden" name="storz_avatar_id" id="storz_avatar_id" value="'.esc_attr($aid).'">';
    echo '<button type="button" class="button" id="storz_upload_avatar">Upload Avatar</button>';
    if($aid)echo ' <button type="button" class="button" id="storz_remove_avatar">Remove</button>';
    ?>
    <script>
    jQuery(function($){
        var frame;
        $('#storz_upload_avatar').on('click',function(e){
            e.preventDefault();
            if(frame){frame.open();return;}
            frame=wp.media({title:'Select Avatar',button:{text:'Use as Avatar'},multiple:false});
            frame.on('select',function(){
                var att=frame.state().get('selection').first().toJSON();
                $('#storz_avatar_id').val(att.id);
                $('#storz_upload_avatar').before('<img src="'+att.url+'" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:12px;display:block" id="sz-av-preview">');
            });
            frame.open();
        });
        $('#storz_remove_avatar').on('click',function(e){
            e.preventDefault();
            $('#storz_avatar_id').val('');
            $('#sz-av-preview').remove();
        });
    });
    </script>
    <?php
    echo '</td></tr></table>';
}
add_action('personal_options_update','storz_save_avatar');
add_action('edit_user_profile_update','storz_save_avatar');
function storz_save_avatar($uid){
    if(!current_user_can('edit_user',$uid))return;
    $aid=absint($_POST['storz_avatar_id']??0);
    if($aid)update_user_meta($uid,'storz_avatar_id',$aid);
    else delete_user_meta($uid,'storz_avatar_id');
}
add_filter('get_avatar',function($avatar,$id_or_email,$size,$default,$alt){
    $uid=0;
    if(is_numeric($id_or_email))$uid=(int)$id_or_email;
    elseif(is_string($id_or_email)){$u=get_user_by('email',$id_or_email);if($u)$uid=$u->ID;}
    if(!$uid)return $avatar;
    $aid=get_user_meta($uid,'storz_avatar_id',true);
    if(!$aid)return $avatar;
    $url=wp_get_attachment_image_url($aid,[$size,$size]);
    if(!$url)return $avatar;
    return '<img src="'.esc_url($url).'" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="avatar photo" loading="lazy">';
},10,5);
add_action('admin_enqueue_scripts',function($hook){
    if(in_array($hook,['profile.php','user-edit.php'],true))wp_enqueue_media();
});

/* ── SHORTCODE ───────────────────────────────────────────────────── */
function storz_shortcode( $atts ) {
    $atts     = shortcode_atts( [ 'id' => 0, 'title' => 'yes' ], $atts );
    $id       = absint( $atts['id'] );
    if ( ! $id ) return '<p style="color:#ef4444">Specify: [storz_form id="1"]</p>';
    $form     = storz_get_form( $id );
    if ( ! $form || $form->status !== 'active' ) return '<p style="color:#ef4444">Form not found.</p>';
    $fields   = json_decode( $form->fields, true ) ?: [];
    $settings = json_decode( $form->settings, true ) ?: [];
    $label    = esc_html( $settings['submit_label'] ?? 'Submit' );
    $out      = '<div class="storz-form" data-form-id="' . esc_attr($id) . '" role="form" aria-label="' . esc_attr($form->name) . '">';
    if ( $atts['title'] === 'yes' ) {
        $out .= '<h2 class="form-title">' . esc_html($form->name) . '</h2>';
        if ( $form->description ) $out .= '<p class="form-desc">' . esc_html($form->description) . '</p>';
    }
    $out .= '<div class="sz-messages" role="alert" aria-live="polite"></div>';
    $out .= '<div class="sz-fields">' . storz_render_fields( $fields ) . '</div>';
    $out .= '<div class="sz-submit-wrap"><button type="button" class="btn btn-primary sz-submit-btn">';
    $out .= '<span class="btn-lbl">' . $label . '</span><span class="btn-spin" aria-hidden="true" style="display:none">&#x23F3;</span>';
    $out .= '</button></div></div>';
    return $out;
}
add_shortcode( 'storz_form', 'storz_shortcode' );
add_shortcode( 'formcraft',  'storz_shortcode' );

function storz_render_fields( $fields ) {
    $out = '';
    foreach ( $fields as $f ) {
        if ( $f['type'] === 'row' ) {
            $cols = absint( $f['cols'] ?? 2 );
            $out .= '<div class="sz-form-row cols-' . $cols . '">';
            foreach ( $f['children'] ?? [] as $c ) $out .= storz_render_single_field($c);
            $out .= '</div>';
        } else {
            $out .= storz_render_single_field($f);
        }
    }
    return $out;
}

function storz_render_single_field( $f ) {
    $fid   = 'sz_' . $f['id'];
    $fname = 'field_' . $f['id'];
    $req   = ! empty( $f['required'] );
    $rattr = $req ? ' required aria-required="true"' : '';
    $type  = $f['type'] ?? 'text';
    $label = esc_html( $f['label'] ?? '' );
    $hint  = $f['hint'] ?? '';
    $ph    = esc_attr( $f['placeholder'] ?? '' );
    $desc  = esc_attr($fid) . '-err';
    $out   = '<div class="sz-field" data-field-id="' . esc_attr($f['id']) . '">';
    $out  .= '<label for="' . esc_attr($fid) . '">' . $label;
    if ( $req ) $out .= '<span class="req" aria-hidden="true">*</span><span class="screen-reader-text"> (required)</span>';
    $out .= '</label>';
    if ( in_array($type,['text','email','tel','number','url','date'],true) ) {
        $out .= '<input type="' . esc_attr($type) . '" id="' . esc_attr($fid) . '" name="' . esc_attr($fname) . '" placeholder="' . $ph . '"' . $rattr . ' aria-describedby="' . $desc . '">';
    } elseif ( $type === 'textarea' ) {
        $rows = absint($f['rows']??4);
        $out .= '<textarea id="' . esc_attr($fid) . '" name="' . esc_attr($fname) . '" rows="' . $rows . '" placeholder="' . $ph . '"' . $rattr . ' aria-describedby="' . $desc . '"></textarea>';
    } elseif ( $type === 'select' ) {
        $out .= '<select id="' . esc_attr($fid) . '" name="' . esc_attr($fname) . '"' . $rattr . '><option value="">— Select —</option>';
        foreach ( $f['options']??[] as $o ) $out .= '<option value="' . esc_attr($o) . '">' . esc_html($o) . '</option>';
        $out .= '</select>';
    } elseif ( $type === 'checkbox' ) {
        $out .= '<fieldset aria-describedby="' . $desc . '"><legend class="screen-reader-text">' . $label . '</legend><div class="sz-check-group">';
        foreach ( $f['options']??[] as $o ) {
            $oid = sanitize_title($o);
            $out .= '<label class="sz-check-item"><input type="checkbox" name="' . esc_attr($fname) . '[]" value="' . esc_attr($o) . '" id="' . esc_attr($fid.'_'.$oid) . '">' . esc_html($o) . '</label>';
        }
        $out .= '</div></fieldset>';
    } elseif ( $type === 'radio' ) {
        $out .= '<fieldset aria-describedby="' . $desc . '"><legend class="screen-reader-text">' . $label . '</legend><div class="sz-radio-group">';
        foreach ( $f['options']??[] as $o ) {
            $oid = sanitize_title($o);
            $out .= '<label class="sz-check-item"><input type="radio" name="' . esc_attr($fname) . '" value="' . esc_attr($o) . '" id="' . esc_attr($fid.'_'.$oid) . '"' . ($req?' required':'') . '>' . esc_html($o) . '</label>';
        }
        $out .= '</div></fieldset>';
    } elseif ( $type === 'rating' ) {
        $out .= '<div class="sz-rating" role="radiogroup" aria-label="' . $label . '">';
        for ( $i = 5; $i >= 1; $i-- ) {
            $out .= '<input type="radio" id="' . esc_attr($fid.'_'.$i) . '" name="' . esc_attr($fname) . '" value="' . $i . '"' . ($req?' required':'') . '>';
            $out .= '<label for="' . esc_attr($fid.'_'.$i) . '" aria-label="' . $i . ' star">&#9733;</label>';
        }
        $out .= '</div>';
    }
    if ( $hint ) $out .= '<p class="sz-hint">' . esc_html($hint) . '</p>';
    $out .= '<p class="sz-field-error" id="' . esc_attr($fid) . '-err" role="alert" style="display:none"></p>';
    $out .= '</div>';
    return $out;
}
