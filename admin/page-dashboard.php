<?php
if(!defined('ABSPATH'))exit;
global $wpdb;
$forms  = storz_get_forms(['status'=>'all','limit'=>200]);
$total  = count($forms);
$active = count(array_filter($forms,fn($f)=>$f->status==='active'));
$subs   = storz_count_submissions();
$today  = (int)$wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}storz_submissions WHERE DATE(created_at)=CURDATE()");
$gm_ok  = get_option('storz_gmail_access_token','') ? true : false;
$wa_ok  = get_option('storz_wa_token','') ? true : false;
storz_nav('storz');
echo '<div class="sz-content">';
echo '<div class="sz-ph"><div><h2>Dashboard</h2><p>STORZ Suite v'.STORZ_VER.'</p></div></div>';
echo '<div class="sz-stats">';
foreach([['📋','Forms',$total],['✅','Active',$active],['📥','Submissions',$subs],['📆','Today',$today],['📧','Gmail',$gm_ok?'ON':'OFF'],['📱','WhatsApp',$wa_ok?'ON':'OFF']] as [$i,$l,$v]){
    echo '<div class="sz-stat"><span class="sz-si">'.$i.'</span><div class="sz-sv">'.esc_html($v).'</div><div class="sz-sl">'.esc_html($l).'</div></div>';
}
echo '</div>';
echo '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:12px;margin-bottom:28px">';
foreach([['🎯','Form Builder','storz-builder'],['📤','Export/Import','storz-forms'],['🗄','DB Manager','storz-db-manager'],['👤','Roles','storz-roles'],['🎨','Rebranding','storz-rebranding'],['🤖','Automation','storz-automation']] as [$i,$t,$s]){
    $url=esc_url(admin_url('admin.php?page='.$s));
    echo '<div class="sz-stat" style="cursor:pointer" onclick="location.href=\''.$url.'\'">';
    echo '<span class="sz-si">'.$i.'</span><div style="font-family:var(--fd);font-size:.9rem;font-weight:700;color:var(--sz-t)">'.esc_html($t).'</div></div>';
}
echo '</div>';
// Demo pages
$demo_pages=[['Contact Us','contact','📬'],['Newsletter','newsletter','📰'],['STORZ Summit','event','📅'],['Careers','careers','🚀'],['Form Demo','forms','📋']];
echo '<div class="sz-ph" style="margin-bottom:12px"><div><h2 style="font-size:1.1rem">🗂 Demo Pages</h2></div><a href="'.esc_url(admin_url('edit.php?post_type=page')).'" class="sz-btn sz-btn-secondary sz-btn-sm">Manage All</a></div>';
echo '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;margin-bottom:28px">';
foreach($demo_pages as [$title,$slug,$icon]){
    $page=get_page_by_path($slug);
    echo '<div style="background:var(--sz-s);border:1px solid var(--sz-b);border-radius:var(--sz-r);padding:16px">';
    echo '<div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">';
    echo '<span style="font-size:1.2rem">'.$icon.'</span>';
    echo '<div style="flex:1;font-weight:700;color:var(--sz-t);font-size:.9rem">'.esc_html($title).'</div>';
    echo $page?'<span class="sz-badge sz-ok-b">Live</span>':'<span class="sz-badge sz-off-b">Pending</span>';
    echo '</div>';
    if($page){
        echo '<div class="sz-ra">';
        echo '<a href="'.esc_url(get_permalink($page->ID)).'" target="_blank" rel="noopener" class="sz-btn sz-btn-primary sz-btn-sm" style="flex:1;justify-content:center">👁 View</a>';
        echo '<a href="'.esc_url(get_edit_post_link($page->ID)).'" class="sz-btn sz-btn-secondary sz-btn-sm" style="flex:1;justify-content:center">✏️ Edit</a>';
        echo '</div>';
    }
    echo '</div>';
}
echo '</div>';
if($forms){
    echo '<div class="sz-ph" style="margin-bottom:12px"><div><h2 style="font-size:1.1rem">Recent Forms</h2></div><a href="'.esc_url(admin_url('admin.php?page=storz-forms')).'" class="sz-btn sz-btn-secondary sz-btn-sm">View All</a></div>';
    echo '<div class="sz-tw"><table class="sz-table"><thead><tr><th>Form</th><th>Shortcode</th><th>Subs</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
    foreach(array_slice($forms,0,5) as $f){
        $sc='[storz_form id="'.$f->id.'"]';
        $badge=$f->status==='active'?'sz-ok-b':'sz-off-b';$blabel=$f->status==='active'?'● Active':'○ Off';
        echo '<tr><td class="sz-tdn">'.esc_html($f->name).'</td>';
        echo '<td><span class="sz-sc" data-sc="'.esc_attr($sc).'">📋 '.esc_html($sc).'</span></td>';
        echo '<td>'.storz_count_submissions($f->id).'</td>';
        echo '<td><span class="sz-badge '.$badge.'">'.$blabel.'</span></td>';
        echo '<td><div class="sz-ra"><a href="'.esc_url(admin_url('admin.php?page=storz-builder&form_id='.$f->id)).'" class="sz-btn sz-btn-secondary sz-btn-sm">✏️</a><a href="'.esc_url(admin_url('admin.php?page=storz-submissions&form_id='.$f->id)).'" class="sz-btn sz-btn-secondary sz-btn-sm">📥</a></div></td></tr>';
    }
    echo '</tbody></table></div>';
}
echo '</div>';
storz_nav_end();
