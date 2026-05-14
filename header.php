<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr(get_option('storz_color_theme','dark')); ?>">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to main content','storz'); ?></a>
<header class="site-header" role="banner">
  <div class="container"><div class="header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
      <span class="sz-logo-icon" aria-hidden="true">&#x1F98B;</span>
      <span class="sz-logo-text-wrap" style="display:flex;flex-direction:column">
        <span class="sz-logo-word"><?php echo esc_html(get_option('storz_brand_name','STORZ')); ?></span>
        <?php if(get_option('storz_brand_tagline','')): ?><span class="sz-logo-sub"><?php echo esc_html(get_option('storz_brand_tagline','')); ?></span><?php endif; ?>
      </span>
    </a>
    <nav class="main-nav" id="primary-nav" role="navigation" aria-label="Primary navigation">
      <?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'items_wrap'=>'%3$s','fallback_cb'=>false]); ?>
    </nav>
    <div class="header-ctrl">
      <button class="theme-toggle" id="theme-toggle" aria-label="Switch colour theme" aria-pressed="false" type="button">
        <span class="icon-moon" aria-hidden="true">&#127769;</span>
        <span class="icon-sun" aria-hidden="true">&#9728;&#65039;</span>
      </button>
      <button class="menu-toggle" id="menu-toggle" type="button" aria-controls="primary-nav" aria-expanded="false" aria-label="Open menu">&#9776;</button>
    </div>
  </div></div>
</header>
<main id="main-content" tabindex="-1">
