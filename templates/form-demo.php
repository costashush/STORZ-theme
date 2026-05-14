<?php
/**
 * Template Name: Form Demo Page
 */
get_header();
$forms = storz_get_forms(["status"=>"active","limit"=>20]);
?>
<div class="container" style="padding:60px 24px">
  <span class="section-badge">STORZ Forms</span>
  <h1 style="margin-bottom:8px"><?php the_title(); ?></h1>
  <?php if(have_posts()):while(have_posts()):the_post(); ?>
    <div class="entry-content" style="color:var(--sz-t2);margin-bottom:40px"><?php the_content(); ?></div>
  <?php endwhile;endif; ?>
  <?php if(empty($forms)): ?>
    <div class="card" style="text-align:center;padding:48px"><h3>No active forms yet</h3>
    <a href="<?php echo esc_url(admin_url('admin.php?page=storz-builder')); ?>" class="btn btn-primary" style="margin-top:16px;display:inline-flex">Create a Form</a></div>
  <?php else: ?>
    <div role="tablist" aria-label="Forms" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:28px">
      <?php foreach($forms as $i=>$f): ?>
        <button role="tab" id="tab-<?php echo $f->id; ?>" aria-selected="<?php echo $i===0?'true':'false'; ?>"
                aria-controls="panel-<?php echo $f->id; ?>"
                class="btn <?php echo $i===0?'btn-primary':'btn-secondary'; ?> sz-tab-btn"
                data-target="panel-<?php echo $f->id; ?>" style="font-size:.84rem;padding:8px 16px">
          <?php echo esc_html($f->name); ?>
        </button>
      <?php endforeach; ?>
    </div>
    <?php foreach($forms as $i=>$f): $sets=json_decode($f->settings,true)?:[]; ?>
    <div role="tabpanel" id="panel-<?php echo $f->id; ?>" aria-labelledby="tab-<?php echo $f->id; ?>" style="<?php echo $i===0?'':'display:none'; ?>">
      <div style="display:grid;grid-template-columns:1fr 300px;gap:40px;align-items:start">
        <div><?php echo do_shortcode('[storz_form id="' . $f->id . '" title="yes"]'); ?></div>
        <aside class="card" style="padding:20px">
          <h3 style="margin-bottom:14px;font-size:.95rem">Form Info</h3>
          <dl style="font-size:.82rem;display:flex;flex-direction:column;gap:10px">
            <div><dt style="color:var(--sz-m);font-weight:600;margin-bottom:3px">Shortcode</dt>
              <dd><code>[storz_form id="<?php echo $f->id; ?>"]</code></dd></div>
            <div><dt style="color:var(--sz-m);font-weight:600;margin-bottom:3px">Submissions</dt>
              <dd style="color:var(--sz-t2)"><?php echo storz_count_submissions($f->id); ?></dd></div>
          </dl>
          <?php if(is_user_logged_in()&&current_user_can('manage_options')): ?>
          <a href="<?php echo esc_url(admin_url('admin.php?page=storz-builder&form_id='.$f->id)); ?>"
             class="btn btn-secondary" style="width:100%;justify-content:center;font-size:.82rem;margin-top:16px">Edit in Builder</a>
          <?php endif; ?>
        </aside>
      </div>
    </div>
    <?php endforeach; ?>
    <script>
    document.querySelectorAll(".sz-tab-btn").forEach(function(btn){
      btn.addEventListener("click",function(){
        document.querySelectorAll(".sz-tab-btn").forEach(function(b){b.setAttribute("aria-selected","false");b.className="btn btn-secondary sz-tab-btn";b.style.cssText="font-size:.84rem;padding:8px 16px";});
        document.querySelectorAll("[role=tabpanel]").forEach(function(p){p.style.display="none";});
        btn.setAttribute("aria-selected","true");btn.className="btn btn-primary sz-tab-btn";btn.style.cssText="font-size:.84rem;padding:8px 16px";
        var panel=document.getElementById(btn.dataset.target);if(panel)panel.style.display="";
      });
    });
    </script>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
