<?php get_header(); ?>
<div class="container" style="padding:60px 24px">
  <?php if(have_posts()):while(have_posts()):the_post(); ?>
  <article class="card" style="margin-bottom:24px">
    <h2 style="margin-bottom:10px"><a href="<?php the_permalink(); ?>" style="color:var(--sz-t);text-decoration:none"><?php the_title(); ?></a></h2>
    <p style="font-size:.8rem;color:var(--sz-m);margin-bottom:14px"><?php echo get_the_date(); ?> &middot; <?php the_author(); ?></p>
    <?php the_excerpt(); ?>
  </article>
  <?php endwhile; else: ?><p>No posts found.</p><?php endif; ?>
</div>
<?php get_footer(); ?>
