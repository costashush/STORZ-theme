<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (storz_is_header_enabled()) : ?>
<header class="site-header storz-site-header">
    <div class="container storz-header-inner">
        <a class="storz-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <span class="storz-brand-logo"><?php echo storz_get_logo_markup(); ?><?php ?></span>
            <?php if (storz_is_header_text_enabled()) : ?>
                <span class="storz-brand-text">
                    <strong><?php echo esc_html(get_bloginfo('name')); ?></strong>
                    <small><?php echo esc_html(storz_get_header_text()); ?></small>
                </span>
            <?php endif; ?>
        </a>

        <div class="storz-header-actions">
            <?php if (has_nav_menu('primary')) : ?>
                <nav class="storz-main-nav" aria-label="<?php esc_attr_e('Primary menu', 'storz'); ?>">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'storz-nav-menu',
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ]);
                    ?>
                </nav>
            <?php endif; ?>

            
            <button class="storz-theme-toggle" type="button" aria-label="<?php esc_attr_e('Toggle dark and light mode', 'storz'); ?>">
                <span class="storz-theme-toggle-icon" aria-hidden="true">☾</span>
            </button>

            <?php if (storz_is_search_enabled()) : ?>
                <button class="storz-search-toggle" type="button" aria-expanded="false" aria-controls="storz-header-search">
                    <span aria-hidden="true">⌕</span>
                    <span class="screen-reader-text"><?php esc_html_e('Search', 'storz'); ?></span>
                </button>

                <div id="storz-header-search" class="storz-header-search">
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php endif; ?>

<main class="site-main storz-site-main">
