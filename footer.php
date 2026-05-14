</main>
<footer class="site-footer" role="contentinfo">
  <div class="container"><div class="footer-inner">
    <p><?php echo wp_kses_post(get_option('storz_brand_footer_text','&copy; '.date('Y').' STORZ. All rights reserved.')); ?></p>
    <nav aria-label="Footer navigation"><?php wp_nav_menu(['theme_location'=>'footer','container'=>false,'items_wrap'=>'%3$s','depth'=>1,'fallback_cb'=>false]); ?></nav>
  </div></div>
</footer>
<?php wp_footer(); ?>
</body></html>
