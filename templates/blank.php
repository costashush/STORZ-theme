<?php
/**
 * Template Name: Blank Page
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr(get_option('storz_color_theme','dark')); ?>">
<head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class(); ?>><?php wp_body_open(); ?>
<main id="main-content" role="main"><?php while(have_posts()):the_post(); ?><div class="entry-content"><?php the_content(); ?></div><?php endwhile; ?></main>
<?php wp_footer(); ?></body></html>
