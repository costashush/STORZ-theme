</main>

<?php if (storz_is_footer_enabled()) : ?>
<footer class="site-footer storz-site-footer">
    <div class="container storz-footer-inner">
        <div class="storz-footer-brand">
            <strong><?php echo esc_html(get_bloginfo('name')); ?></strong>
            <span><?php echo esc_html(storz_get_option_value('footer_text', 'Built by STORZ')); ?></span>
        </div>

        <?php if (has_nav_menu('footer')) : ?>
            <nav class="storz-footer-nav" aria-label="<?php esc_attr_e('Footer menu', 'storz'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'storz-footer-menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </nav>
        <?php endif; ?>

        <div class="storz-footer-meta">
            <span>&copy; <?php echo esc_html(date('Y')); ?></span>
        </div>
    </div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
