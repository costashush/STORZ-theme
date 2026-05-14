<?php
if(!defined('ABSPATH'))exit;
$forms=storz_get_forms(['status'=>'all','limit'=>200]);
storz_nav('storz-forms');
echo '<div class="sz-content">';
echo '<div class="sz-ph"><div><h2>All Forms</h2><p>Manage, export, import forms.</p></div>';
echo '<div style="display:flex;gap:8px">';
echo '<a href="'.esc_url(admin_url('admin.php?page=storz-builder')).'" class="sz-btn sz-btn-primary">+ Create Form</a>';
echo '<button class="sz-btn sz-btn-secondary" id="sz-export-btn">📤 Export Selected</button>';
echo '<button class="sz-btn sz-btn-secondary" id="sz-seed-forms-btn">🌱 Seed Demo Forms</button>';
echo '</div></div>';
echo '<div class="sz-stats">';
echo '<div class="sz-stat"><span class="sz-si">📋</span><div class="sz-sv">'.count($forms).'</div><div class="sz-sl">Forms</div></div>';
echo '<div class="sz-stat"><span class="sz-si">✅</span><div class="sz-sv">'.count(array_filter($forms,fn($f)=>$f->status==='active')).'</div><div class="sz-sl">Active</div></div>';
echo '<div class="sz-stat"><span class="sz-si">📥</span><div class="sz-sv">'.storz_count_submissions().'</div><div class="sz-sl">Submissions</div></div>';
echo '</div>';
// Export section
echo '<div id="sz-export-section" style="margin-bottom:16px;display:none"><div class="sz-panel"><div class="sz-panel-head">📤 Export JSON</div><div style="padding:14px;display:flex;flex-direction:column;gap:8px">';
echo '<textarea id="sz-export-out" class="sz-export-area" style="display:none;min-height:100px" placeholder="Click Export to generate JSON"></textarea>';
echo '<div style="display:flex;gap:8px"><button class="sz-btn sz-btn-secondary" id="sz-download-json">⬇️ Download .json</button></div>';
echo '</div></div></div>';
// Import section
echo '<div class="sz-panel" style="margin-bottom:20px"><div class="sz-panel-head">📥 Import Forms (JSON)</div><div style="padding:14px;display:flex;flex-direction:column;gap:8px">';
echo '<textarea id="sz-import-in" class="sz-export-area" placeholder="Paste exported JSON here"></textarea>';
echo '<button class="sz-btn sz-btn-success" id="sz-import-btn">📥 Import Forms</button>';
echo '</div></div>';
if(empty($forms)){
    echo '<div class="sz-tw"><div class="sz-empty"><div class="sz-ei">📋</div><h3>No forms yet</h3>';
    echo '<a href="'.esc_url(admin_url('admin.php?page=storz-builder')).'" class="sz-btn sz-btn-primary">Create First Form</a></div></div>';
}else{
    echo '<div class="sz-tw"><table class="sz-table">';
    echo '<thead><tr><th><input type="checkbox" id="sz-check-all" style="accent-color:var(--sz-a)"></th><th>Form</th><th>Shortcode</th><th>Fields</th><th>Subs</th><th>Gmail</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead><tbody>';
    foreach($forms as $f){
        $flds=json_decode($f->fields,true)?:[];$sets=json_decode($f->settings,true)?:[];
        $gm=!empty($sets['gmail_enabled'])&&$sets['gmail_enabled']==='1';
        $sc='[storz_form id="'.$f->id.'"]';
        $badge=$f->status==='active'?'sz-ok-b':'sz-off-b';$blabel=$f->status==='active'?'● Active':'○ Off';
        echo '<tr><td><input type="checkbox" class="sz-form-check" data-id="'.$f->id.'" style="accent-color:var(--sz-a)"></td>';
        echo '<td class="sz-tdn">'.esc_html($f->name).($f->description?'<small>'.esc_html(wp_trim_words($f->description,7)).'</small>':'').'</td>';
        echo '<td><span class="sz-sc" data-sc="'.esc_attr($sc).'">📋 '.esc_html($sc).'</span></td>';
        echo '<td>'.count($flds).'</td>';
        echo '<td><a href="'.esc_url(admin_url('admin.php?page=storz-submissions&form_id='.$f->id)).'" class="sz-badge sz-ac-b">'.storz_count_submissions($f->id).'</a></td>';
        echo '<td><span class="sz-badge '.($gm?'sz-gm-b':'sz-off-b').'">'.($gm?'✓ Gmail':'—').'</span></td>';
        echo '<td><span class="sz-badge '.$badge.'">'.$blabel.'</span></td>';
        echo '<td style="font-size:.76rem;color:var(--sz-m)">'.esc_html(date('M j, Y',strtotime($f->created_at))).'</td>';
        echo '<td><div class="sz-ra"><a href="'.esc_url(admin_url('admin.php?page=storz-builder&form_id='.$f->id)).'" class="sz-btn sz-btn-secondary sz-btn-sm">✏️ Edit</a>';
        echo '<button class="sz-btn sz-btn-danger sz-btn-sm sz-del-form" data-id="'.$f->id.'">✕</button></div></td></tr>';
    }
    echo '</tbody></table></div>';
    echo '<script>document.getElementById("sz-check-all").addEventListener("change",function(){document.querySelectorAll(".sz-form-check").forEach(c=>c.checked=this.checked);});';
    echo 'document.getElementById("sz-export-btn").addEventListener("click",function(){document.getElementById("sz-export-section").style.display="";});</script>';
}
echo '<input type="hidden" id="sz-csv-form-select" value="0">';
echo '</div>';
storz_nav_end();
