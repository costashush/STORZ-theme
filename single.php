<?php get_header(); ?>
<div class="container content-card storz-form-page-center">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
