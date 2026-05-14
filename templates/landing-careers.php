<?php
/**
 * Template Name: Landing — Careers
 */
get_header();
global $wpdb;
$form=$wpdb->get_row("SELECT id FROM {$wpdb->prefix}storz_forms WHERE name='Job Application' AND status='active' LIMIT 1");
$fid=$form?$form->id:5;
?>
<section style="padding:80px 0 60px;text-align:center;position:relative;overflow:hidden">
  <div class="container" style="position:relative">
    <div class="hero-badge" style="background:rgba(249,115,22,.1);border-color:rgba(249,115,22,.25);color:#fb923c">&#x1F680; We're Hiring</div>
    <h1 style="margin-bottom:16px;margin-top:16px">Build the Future <span class="grad">With Us</span></h1>
    <p style="font-size:1.1rem;color:var(--sz-t2);max-width:520px;margin:0 auto">Small team, hard problems, fast shipping. If that sounds like you — apply below.</p>
  </div>
</section>
<section style="padding:0 0 80px">
  <div class="container">
    <div class="features-grid" style="margin-top:0;margin-bottom:60px">
      <?php foreach([["&#x1F30D;","Fully Remote","Work from anywhere."],["&#x1F4B0;","Competitive Pay","Market rate + equity."],["&#x1F3D6;","Unlimited PTO","Take the time you need."],["&#x26A1;","Fast Shipping","Ship weekly, no sprints."]] as [$i,$t,$d]): ?>
      <div class="card" style="display:flex;gap:14px;align-items:flex-start;padding:20px">
        <span style="font-size:1.3rem;flex-shrink:0"><?php echo $i; ?></span>
        <div><div style="font-weight:700;color:var(--sz-t);font-size:.9rem;margin-bottom:4px"><?php echo esc_html($t); ?></div><p style="font-size:.8rem;margin:0"><?php echo esc_html($d); ?></p></div>
      </div>
      <?php endforeach; ?>
    </div>
    <div style="display:grid;grid-template-columns:1fr 420px;gap:56px;align-items:start">
      <div>
        <h2 style="margin-bottom:24px">Open Roles</h2>
        <?php foreach([["Frontend Developer","Engineering","Remote","Full-time"],["Product Designer","Design","Remote","Full-time"],["Backend Engineer","Engineering","Remote","Full-time"],["Growth Marketer","Marketing","Remote","Part-time"]] as [$t,$d,$l,$type]): ?>
        <div class="card" style="margin-bottom:12px;padding:20px 24px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
          <div>
            <div style="font-weight:700;color:var(--sz-t);margin-bottom:6px"><?php echo esc_html($t); ?></div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              <?php foreach([$d,$l,$type] as $tag): ?><span style="background:var(--sz-s2);color:var(--sz-m);font-size:.72rem;padding:3px 9px;border-radius:100px;font-weight:600"><?php echo esc_html($tag); ?></span><?php endforeach; ?>
            </div>
          </div>
          <a href="#apply" class="btn btn-primary" style="font-size:.82rem;padding:8px 16px">Apply &rarr;</a>
        </div>
        <?php endforeach; ?>
      </div>
      <div id="apply" class="card" style="padding:32px;position:sticky;top:80px">
        <h3 style="margin-bottom:6px;font-size:1.1rem">Apply Now</h3>
        <p style="font-size:.83rem;color:var(--sz-m);margin-bottom:24px">Tell us about yourself.</p>
        <?php echo do_shortcode('[storz_form id="' . $fid . '" title="no"]'); ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
