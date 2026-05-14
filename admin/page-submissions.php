<?php
if(!defined('ABSPATH'))exit;
$form_id=isset($_GET['form_id'])?absint($_GET['form_id']):0;
$subs=storz_get_submissions($form_id,200);$total=storz_count_submissions($form_id);
$forms=storz_get_forms(['status'=>'all','limit'=>200]);
storz_nav('storz-submissions');
echo '<div class="sz-content">';
echo '<div class="sz-ph"><div><h2>Submissions</h2><p>Click any row to expand. Export as CSV.</p></div>';
echo '<div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">';
if($forms){
    echo '<select id="sz-filter-form" style="background:var(--sz-s2);border:1px solid var(--sz-b);color:var(--sz-t);padding:7px 12px;border-radius:var(--sz-rs);font-size:.82rem;outline:none">';
    echo '<option value="0">— All Forms —</option>';
    foreach($forms as $f){$sel=selected($form_id,(int)$f->id,false);echo '<option value="'.$f->id.'"'.$sel.'>'.esc_html($f->name).'</option>';}
    echo '</select>';
    $subs_url=esc_js(admin_url('admin.php?page=storz-submissions'));
    echo '<script>document.getElementById("sz-filter-form").addEventListener("change",function(){location.href="'.$subs_url.'&form_id="+this.value;});</script>';
}
echo '<button class="sz-btn sz-btn-success" id="sz-export-csv-btn">⬇️ Export CSV</button>';
echo '<input type="hidden" id="sz-csv-form-select" value="'.esc_attr($form_id).'">';
echo '</div></div>';
echo '<div class="sz-stats"><div class="sz-stat"><span class="sz-si">📥</span><div class="sz-sv">'.$total.'</div><div class="sz-sl">'.($form_id?'Responses':'Total').'</div></div></div>';
if(empty($subs)){
    echo '<div class="sz-tw"><div class="sz-empty"><div class="sz-ei">📬</div><h3>No submissions yet</h3><p>Responses appear here when users submit your forms.</p></div></div>';
}else{
    echo '<div class="sz-tw"><table class="sz-table"><thead><tr><th>#</th><th>Form</th><th>Preview</th><th>Date</th><th>IP</th></tr></thead><tbody>';
    foreach($subs as $s){
        $data=json_decode($s->data,true)?:[];$prev='';
        foreach(array_slice($data,0,2) as $l=>$v){$prev.='<span style="font-size:.75rem;color:var(--sz-m)">'.esc_html($l).':</span> <span style="font-size:.75rem;color:var(--sz-t2);margin-right:8px">'.esc_html(is_array($v)?implode(', ',$v):wp_trim_words($v,5)).'</span>';}
        if(count($data)>2)$prev.='<span style="font-size:.7rem;color:var(--sz-m)">+'.(count($data)-2).' more</span>';
        echo '<tr class="sz-sub-row" style="cursor:pointer">';
        echo '<td style="font-size:.79rem;color:var(--sz-m)">#'.$s->id.'</td>';
        echo '<td style="font-size:.79rem">'.esc_html($s->form_name??'—').'</td>';
        echo '<td>'.$prev.'</td>';
        echo '<td style="font-size:.76rem;color:var(--sz-m)">'.esc_html(date('M j, Y g:i a',strtotime($s->created_at))).'</td>';
        echo '<td style="font-size:.75rem;color:var(--sz-m)">'.esc_html($s->ip_address??'').'</td></tr>';
        $dl='<dl style="display:grid;grid-template-columns:160px 1fr;gap:6px 14px;font-size:.83rem">';
        foreach($data as $l=>$v){$dl.='<dt style="color:var(--sz-m);font-weight:600">'.esc_html($l).'</dt><dd style="color:var(--sz-t2)">'.esc_html(is_array($v)?implode(', ',$v):$v).'</dd>';}
        $dl.='</dl>';
        echo '<tr class="sz-sub-detail" style="display:none"><td colspan="5" style="padding:0 16px 14px"><div style="background:var(--sz-s2);border-left:3px solid var(--sz-a);padding:14px 18px;border-radius:0 var(--sz-rs) var(--sz-rs) 0">'.$dl.'</div></td></tr>';
    }
    echo '</tbody></table></div>';
}
echo '</div>';
storz_nav_end();
