</main>
<?php if (storz_is_footer_enabled()) : ?>
<footer class="site-footer">
    <div class="container footer-centered">
        <p><?php echo esc_html(storz_get_option_value('footer_text', 'Built by STORZ')); ?></p>
    </div>
</footer>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
