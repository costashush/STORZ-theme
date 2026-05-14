<?php get_header(); ?>
<section class="hero"><div class="container">
  <div class="hero-badge">&#x1F98B; STORZ Suite v1.0.1</div>
  <h1>Your WordPress.<br><span class="grad">Fully Supercharged.</span></h1>
  <p class="lead">Forms + Gmail, DB Manager, Roles, Rebranding, WhatsApp &amp; Email Automation &#x2014; all in one theme.</p>
  <div class="hero-actions">
    <a href="<?php echo esc_url(admin_url('admin.php?page=storz')); ?>" class="btn btn-primary">Open Dashboard &rarr;</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=storz-builder')); ?>" class="btn btn-secondary">&#x271A; Build a Form</a>
  </div>
</div></section>
<section class="section"><div class="container">
  <span class="section-badge">Everything included</span>
  <h2>One theme. Full power.</h2>
  <div class="features-grid">
    <?php foreach([
      ['&#x1F3AF;','Form Builder','10+ field types, multi-column rows, rating stars, AJAX submission.'],
      ['&#x1F4E7;','Gmail Integration','OAuth2 Gmail API — send notifications directly from Gmail.'],
      ['&#x1F4E4;','Export / Import','Export forms as JSON, submissions as CSV.'],
      ['&#x1F5C4;','DB Manager','Browse and manage any database table from wp-admin.'],
      ['&#x1F464;','Role Customizer','Create, edit and delete roles with capability control.'],
      ['&#x1F3A8;','Rebranding Suite','White-label WP: name, logo, colours, login page.'],
      ['&#x1F4F1;','WhatsApp Hub','Cloud API sender, auto-reply bot, webhook endpoint.'],
      ['&#x2709;&#xFE0F;','Email Automation','Send emails with a full delivery log.'],
      ['&#x1F5A5;&#xFE0F;','Dashboard Widgets','Hardware info, form activity, automation log.'],
      ['&#x1F319;','Light / Dark Mode','System-aware with manual toggle.'],
      ['&#x267F;','Accessibility','WCAG 2.1 AA — skip links, ARIA, focus-visible.'],
      ['&#x1F4CB;','5 Demo Forms','Multi-column forms pre-seeded on activation.'],
    ] as [$i,$t,$d]): ?>
    <div class="card"><div class="feature-icon"><?php echo $i; ?></div>
    <h3 style="margin-bottom:8px;font-size:1rem"><?php echo esc_html($t); ?></h3>
    <p style="font-size:.84rem"><?php echo esc_html($d); ?></p></div>
    <?php endforeach; ?>
  </div>
</div></section>
<section style="padding:80px 0;background:var(--sz-s);border-top:1px solid var(--sz-b);border-bottom:1px solid var(--sz-b)">
  <div class="container"><div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:start">
    <div>
      <span class="section-badge">Live demo</span>
      <h2>Embed anywhere</h2>
      <p style="margin:16px 0 24px;color:var(--sz-t2)">Use <code>[storz_form id="1"]</code> in any page or post. AJAX &#x2014; zero page reload.</p>
    </div>
    <div>
      <?php global $wpdb;
      $f=$wpdb->get_row("SELECT id FROM {$wpdb->prefix}storz_forms WHERE status='active' ORDER BY id ASC LIMIT 1");
      echo $f ? do_shortcode('[storz_form id="'.$f->id.'"]') : '<div class="card" style="text-align:center;padding:40px"><p>Activate theme to seed 5 demo forms!</p><a href="'.esc_url(admin_url('admin.php?page=storz-builder')).'" class="btn btn-primary" style="margin-top:16px;display:inline-flex">Create a Form</a></div>'; ?>
    </div>
  </div></div>
</section>
<?php get_footer(); ?>
