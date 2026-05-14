<?php
/**
 * Template Name: Landing — Event Registration
 */
get_header();
global $wpdb;
$form=$wpdb->get_row("SELECT id FROM {$wpdb->prefix}storz_forms WHERE name='Event Registration' AND status='active' LIMIT 1");
$fid=$form?$form->id:4;
?>
<section style="padding:80px 0;position:relative;overflow:hidden">
  <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(124,58,237,.08),transparent);pointer-events:none"></div>
  <div class="container" style="position:relative">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">
      <div>
        <div class="hero-badge" style="background:rgba(249,115,22,.1);border-color:rgba(249,115,22,.25);color:#fb923c">&#x1F4C5; Live Event</div>
        <h1 style="margin-bottom:20px;margin-top:16px">STORZ <span class="grad">Summit 2025</span></h1>
        <p style="font-size:1.05rem;color:var(--sz-t2);margin-bottom:32px">A full-day conference on web technology, automation, and product design.</p>
        <?php foreach([["&#x1F4C5;","Date","Saturday, December 14, 2025"],["&#x1F4CD;","Venue","Grand Hyatt, New York City"],["&#x23F0;","Time","9:00 AM – 8:00 PM EST"],["&#x1F39F;","Capacity","Limited to 500 attendees"]] as [$i,$l,$v]): ?>
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px">
          <div style="width:36px;height:36px;border-radius:8px;background:var(--sz-ad);display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0"><?php echo $i; ?></div>
          <div><span style="font-size:.75rem;font-weight:700;color:var(--sz-m);text-transform:uppercase;letter-spacing:.05em"><?php echo esc_html($l); ?></span><br><span style="font-size:.9rem;color:var(--sz-t2)"><?php echo esc_html($v); ?></span></div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="card" style="padding:32px">
        <h3 style="margin-bottom:6px;font-size:1.15rem">Reserve Your Spot</h3>
        <p style="font-size:.83rem;color:var(--sz-m);margin-bottom:24px">Seats filling fast.</p>
        <?php echo do_shortcode('[storz_form id="' . $fid . '" title="no"]'); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
