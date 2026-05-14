<?php
/**
 * Template Name: Landing — Newsletter
 */
get_header();
global $wpdb;
$form=$wpdb->get_row("SELECT id FROM {$wpdb->prefix}storz_forms WHERE name='Newsletter Signup' AND status='active' LIMIT 1");
$fid=$form?$form->id:2;
?>
<section style="padding:90px 0 80px;text-align:center;background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(192,38,211,.05),rgba(249,115,22,.04));border-bottom:1px solid var(--sz-b)">
  <div class="container">
    <div style="font-size:3rem;margin-bottom:20px">&#x1F98B;</div>
    <h1 style="margin-bottom:16px;font-size:clamp(2.2rem,5vw,3.8rem)">Stay in the <span class="grad">Loop</span></h1>
    <p style="font-size:1.1rem;color:var(--sz-t2);max-width:500px;margin:0 auto 40px">Curated insights on technology, design, and building great products.</p>
    <div style="max-width:600px;margin:0 auto" class="card"><?php echo do_shortcode('[storz_form id="' . $fid . '" title="no"]'); ?></div>
    <p style="font-size:.78rem;color:var(--sz-m);margin-top:18px">No spam. Unsubscribe any time.</p>
  </div>
</section>
<section style="padding:80px 0">
  <div class="container"><div style="text-align:center;margin-bottom:48px"><h2>Every issue includes</h2></div>
  <div class="features-grid">
    <?php foreach([["&#x1F3AF;","Deep Dives","Long-form analysis on the topics that matter."],["&#x26A1;","Quick Tips","Actionable techniques you can use today."],["&#x1F517;","Curated Links","The best tools and resources we found."],["&#x1F3A4;","Interviews","Conversations with practitioners."]] as [$i,$t,$d]): ?>
    <div class="card"><div class="feature-icon"><?php echo $i; ?></div><h3 style="font-size:1rem;margin-bottom:8px"><?php echo esc_html($t); ?></h3><p style="font-size:.84rem"><?php echo esc_html($d); ?></p></div>
    <?php endforeach; ?>
  </div></div>
</section>
<?php get_footer(); ?>
