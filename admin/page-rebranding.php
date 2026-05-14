<?php
if(!defined('ABSPATH'))exit;
storz_nav('storz-rebranding');
echo '<div class="sz-content"><div class="sz-ph"><div><h2>Rebranding Suite</h2><p>White-label your WordPress installation.</p></div></div>';
echo '<form id="sz-brand-form"><div class="sz-rb-grid">';
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">🏷</div><h3>Brand Identity</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
foreach(['storz_brand_name'=>'Site / Brand Name','storz_brand_tagline'=>'Tagline','storz_brand_email'=>'Contact Email','storz_brand_phone'=>'Phone','storz_brand_address'=>'Address'] as $k=>$l){
    echo '<div class="sz-fg"><label>'.esc_html($l).'</label><input type="text" name="'.esc_attr($k).'" value="'.esc_attr(get_option($k,'')).'" ></div>';
}
echo '</div></div>';
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">🖥</div><h3>Admin UI</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
foreach(['storz_admin_bar_label'=>'Admin Bar Label','storz_login_message'=>'Login Page Message','storz_brand_footer_text'=>'Footer Text','storz_brand_color_primary'=>'Primary Colour (hex)','storz_brand_color_accent'=>'Accent Colour (hex)'] as $k=>$l){
    echo '<div class="sz-fg"><label>'.esc_html($l).'</label><input type="text" name="'.esc_attr($k).'" value="'.esc_attr(get_option($k,'')).'" ></div>';
}
echo '</div></div>';
echo '<div class="sz-panel" style="grid-column:1/-1"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">💅</div><h3>Custom CSS</h3></div><div style="padding:16px">';
echo '<div class="sz-fg"><label>Injected into every page (front-end + admin)</label>';
echo '<textarea name="storz_custom_css" class="sz-export-area" style="min-height:150px;font-family:var(--fm);font-size:.82rem">'.esc_textarea(get_option('storz_custom_css','')).'</textarea></div>';
echo '</div></div></div>';
echo '<div style="margin-top:18px"><button type="button" class="sz-btn sz-btn-primary" id="sz-brand-save" style="padding:10px 26px">💾 Save Branding</button></div>';
echo '</form></div>';
storz_nav_end();
