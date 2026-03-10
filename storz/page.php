<?php get_header(); ?>
<div class="container content-card storz-form-page-center">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content', 'page'); ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
