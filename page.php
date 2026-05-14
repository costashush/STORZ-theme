<?php get_header(); ?>
<div class="container" style="padding:60px 24px;max-width:820px">
  <?php while(have_posts()):the_post(); ?>
  <h1 style="margin-bottom:32px"><?php the_title(); ?></h1>
  <div class="entry-content" style="color:var(--sz-t2);line-height:1.8"><?php the_content(); ?></div>
  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
