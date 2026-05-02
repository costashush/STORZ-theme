<?php
/**
 * Template Name: Blank Page (No Header/Footer)
 * Description: Full blank page template for landing pages, embedded forms, and custom layouts.
 *
 * This template intentionally does not call get_header() or get_footer(). It still calls
 * wp_head() and wp_footer() so WordPress, plugins, and theme assets continue to work.
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('storz-blank-page'); ?>>
    <main class="storz-blank-content">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </main>
    <?php wp_footer(); ?>
</body>
</html>
