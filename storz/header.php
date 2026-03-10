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
<header class="site-header site-header-minimal">
    <div class="container site-header-inner site-header-row">
        <div class="site-branding site-branding-side">
            <div class="site-logo-wrap"><?php echo storz_get_logo_markup(); ?></div>
            <?php if (storz_is_header_text_enabled()) : ?>
                <p class="site-tagline"><?php echo esc_html(storz_get_header_text()); ?></p>
            <?php endif; ?>
        </div>
        <?php if (storz_is_search_enabled()) : ?>
            <div class="site-search-wrap site-search-wrap-inline">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</header>
<?php endif; ?>
<main class="site-main">
