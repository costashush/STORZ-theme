<?php
if(!defined('ABSPATH'))exit;
$all_roles=get_editable_roles();$all_caps=[];
foreach($all_roles as $r)foreach(array_keys($r['capabilities']) as $c)$all_caps[$c]=1;
ksort($all_caps);
storz_nav('storz-roles');
echo '<div class="sz-content" id="sz-roles-wrap">';
echo '<div class="sz-ph"><div><h2>Role Customizer</h2><p>Create, edit and delete user roles.</p></div></div>';
echo '<div class="sz-roles-grid" style="margin-bottom:24px">';
foreach($all_roles as $key=>$role){
    $caps=array_keys(array_filter($role['capabilities']));$is_admin=$key==='administrator';
    echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">👤</div>';
    echo '<h3>'.esc_html($role['name']).'</h3>'.($is_admin?'<span class="sz-badge sz-ok-b">Protected</span>':'').'</div>';
    echo '<div style="padding:14px;display:flex;flex-direction:column;gap:10px">';
    echo '<p style="font-family:var(--fm);font-size:.72rem;color:var(--sz-m)">'.esc_html($key).'</p>';
    echo '<div class="sz-cap-grid">';
    foreach(array_slice($caps,0,8) as $c)echo '<span style="font-size:.71rem;color:var(--sz-t2)">✓ '.esc_html($c).'</span>';
    if(count($caps)>8)echo '<span style="font-size:.7rem;color:var(--sz-m)">+'.( count($caps)-8).' more</span>';
    echo '</div><div class="sz-ra">';
    echo '<button class="sz-btn sz-btn-secondary sz-btn-sm sz-role-edit" data-k="'.esc_attr($key).'" data-n="'.esc_attr($role['name']).'" data-caps="'.esc_attr(wp_json_encode($caps)).'">✏️ Edit</button>';
    if(!$is_admin)echo '<button class="sz-btn sz-btn-danger sz-btn-sm sz-role-del" data-k="'.esc_attr($key).'">✕ Delete</button>';
    echo '</div></div></div>';
}
echo '</div>';
echo '<div class="sz-panel" id="sz-role-form"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">➕</div><h3>Create / Edit Role</h3></div>';
echo '<div style="padding:18px;display:flex;flex-direction:column;gap:14px">';
echo '<div class="sz-g2"><div class="sz-fg"><label>Role Key</label><input id="sz-rk" placeholder="e.g. store_manager" style="font-family:var(--fm)"></div>';
echo '<div class="sz-fg"><label>Display Name</label><input id="sz-rn" placeholder="e.g. Store Manager"></div></div>';
echo '<div class="sz-fg"><label>Capabilities</label><div class="sz-cap-grid" style="max-height:200px;background:var(--sz-s2);border:1px solid var(--sz-b);border-radius:var(--sz-rs);padding:12px">';
foreach(array_keys($all_caps) as $c)echo '<label class="sz-cap-item"><input type="checkbox" value="'.esc_attr($c).'"> '.esc_html($c).'</label>';
echo '</div></div>';
echo '<div class="sz-fg"><label>Extra Capabilities (one per line)</label><textarea id="sz-extra-caps" style="min-height:72px;font-family:var(--fm);font-size:.8rem"></textarea></div>';
echo '<div><button class="sz-btn sz-btn-primary" id="sz-role-save">💾 Save Role</button></div>';
echo '</div></div></div>';
storz_nav_end();
