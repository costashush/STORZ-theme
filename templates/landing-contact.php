<?php
/**
 * Template Name: Landing — Contact
 */
get_header();
global $wpdb;
$form=$wpdb->get_row("SELECT id FROM {$wpdb->prefix}storz_forms WHERE name='Contact Us' AND status='active' LIMIT 1");
$fid=$form?$form->id:1;
?>
<section style="padding:80px 0 60px;text-align:center;position:relative;overflow:hidden">
  <div style="position:absolute;top:-150px;left:50%;transform:translateX(-50%);width:700px;height:500px;background:radial-gradient(ellipse,rgba(124,58,237,.15) 0%,transparent 70%);pointer-events:none"></div>
  <div class="container" style="position:relative">
    <div class="hero-badge">&#x1F4EC; Get In Touch</div>
    <h1 style="margin-bottom:16px">Let's <span class="grad">Start a Conversation</span></h1>
    <p style="font-size:1.05rem;color:var(--sz-t2);max-width:520px;margin:0 auto">Have a question or project idea? Fill in the form and we'll reply within 24 hours.</p>
  </div>
</section>
<section style="padding:0 0 100px">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 340px;gap:56px;align-items:start;max-width:960px;margin:0 auto">
      <div class="card" style="padding:36px"><?php echo do_shortcode('[storz_form id="' . $fid . '" title="no"]'); ?></div>
      <div style="display:flex;flex-direction:column;gap:20px">
        <?php foreach([["&#x1F4CD;","Office","123 Creative Street, New York, NY"],["&#x1F4DE;","Phone","+1 (555) 000-0000"],["&#x2709;&#xFE0F;","Email","hello@storz.dev"],["&#x1F550;","Hours","Mon–Fri, 9am–6pm EST"]] as [$i,$l,$v]): ?>
        <div style="display:flex;gap:16px;align-items:flex-start">
          <div style="width:42px;height:42px;border-radius:10px;background:var(--sz-ad);display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0"><?php echo $i; ?></div>
          <div><div style="font-size:.78rem;font-weight:700;color:var(--sz-m);text-transform:uppercase;letter-spacing:.06em;margin-bottom:3px"><?php echo esc_html($l); ?></div>
          <div style="color:var(--sz-t2);font-size:.9rem"><?php echo esc_html($v); ?></div></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
