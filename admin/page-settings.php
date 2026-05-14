<?php
if(!defined('ABSPATH'))exit;
$saved=false;
if(isset($_POST['storz_settings_save'])&&check_admin_referer('storz_settings')){
    foreach(['storz_wa_token','storz_wa_phone_id','storz_wa_verify_token','storz_wa_auto_reply','storz_gmail_client_id','storz_gmail_client_secret','storz_default_email','storz_default_submit','storz_default_success','storz_login_brand_text'] as $o)
        update_option($o,sanitize_textarea_field(wp_unslash($_POST[$o]??'')));
    $saved=true;
}
storz_nav('storz-settings');
echo '<div class="sz-content"><div class="sz-ph"><div><h2>Settings</h2><p>Global configuration for all STORZ modules.</p></div></div>';
if($saved)echo '<div style="background:var(--sz-ok2);border:1px solid rgba(16,185,129,.2);border-radius:var(--sz-rs);padding:12px 16px;color:var(--sz-ok);font-size:.83rem;margin-bottom:18px">✓ Settings saved!</div>';
echo '<form method="post">'.wp_nonce_field('storz_settings',null,true,false).'<input type="hidden" name="storz_settings_save" value="1">';
echo '<div class="sz-rb-grid">';
// Login logo
$logo_id=get_option('storz_login_logo_id','');$logo_url=$logo_id?wp_get_attachment_image_url($logo_id,'thumbnail'):'';
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">🖼</div><h3>Login Page Logo</h3></div>';
echo '<div style="padding:16px;display:flex;flex-direction:column;gap:14px">';
if($logo_url)echo '<img src="'.esc_url($logo_url).'" style="width:80px;height:80px;object-fit:contain;border-radius:12px;background:var(--sz-s3);padding:4px">';
echo '<input type="hidden" id="sz-login-logo-id" value="'.esc_attr($logo_id).'">';
echo '<div style="display:flex;gap:8px"><button type="button" class="sz-btn sz-btn-secondary" id="sz-upload-login-logo">📁 Upload Logo</button>';
if($logo_id)echo '<button type="button" class="sz-btn sz-btn-danger sz-btn-sm" id="sz-remove-login-logo">Remove</button>';
echo '</div><p style="font-size:.76rem;color:var(--sz-m)">Recommended: 200x200px PNG. When no image is set, the text below is shown as a gradient wordmark.</p>';
echo '<div class="sz-fg"><label>Login Page Brand Text</label><input type="text" name="storz_login_brand_text" value="'.esc_attr(get_option('storz_login_brand_text',get_option('storz_brand_name','STORZ'))).'" placeholder="STORZ"></div>';
echo '</div></div>';
// WhatsApp
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-wa2)">📱</div><h3>WhatsApp Cloud API</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
foreach(['storz_wa_token'=>['Access Token','password','Bearer token'],'storz_wa_phone_id'=>['Phone Number ID','text','From Meta Dashboard'],'storz_wa_verify_token'=>['Webhook Verify Token','text','storz_verify']] as $k=>[$l,$t,$ph]){
    echo '<div class="sz-fg"><label>'.esc_html($l).'</label><input type="'.$t.'" name="'.esc_attr($k).'" value="'.esc_attr(get_option($k,'')).'" placeholder="'.esc_attr($ph).'"></div>';
}
echo '<div class="sz-fg"><label>Auto-Reply Message</label><textarea name="storz_wa_auto_reply" style="min-height:64px;font-size:.82rem">'.esc_textarea(get_option('storz_wa_auto_reply','')).'</textarea></div>';
echo '</div></div>';
// Gmail
$gm_redirect=esc_html(admin_url('admin.php?page=storz-automation'));$gm_email=get_option('storz_gmail_from_email','');
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:rgba(234,67,53,.1)">📧</div><h3>Gmail OAuth2</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
echo '<p style="font-size:.8rem;color:var(--sz-m)">Redirect URI: <code>'.esc_html(admin_url('admin.php?page=storz-automation')).'</code></p>';
foreach(['storz_gmail_client_id'=>['Client ID','text','xxxx.apps.googleusercontent.com'],'storz_gmail_client_secret'=>['Client Secret','password','GOCSPX-…']] as $k=>[$l,$t,$ph]){
    echo '<div class="sz-fg"><label>'.esc_html($l).'</label><input type="'.$t.'" name="'.esc_attr($k).'" value="'.esc_attr(get_option($k,'')).'" placeholder="'.esc_attr($ph).'"></div>';
}
if($gm_email)echo '<p style="font-size:.8rem"><span style="color:var(--sz-ok)">✓ Connected:</span> '.esc_html($gm_email).'</p>';
echo '</div></div>';
// Form defaults
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">📋</div><h3>Form Defaults</h3></div><div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
echo '<div class="sz-fg"><label>Default Notify Email</label><input type="email" name="storz_default_email" value="'.esc_attr(get_option('storz_default_email',get_option('admin_email'))).'"></div>';
echo '<div class="sz-fg"><label>Default Submit Label</label><input name="storz_default_submit" value="'.esc_attr(get_option('storz_default_submit','Submit')).'"></div>';
echo '<div class="sz-fg"><label>Default Success Message</label><textarea name="storz_default_success" style="min-height:64px">'.esc_textarea(get_option('storz_default_success','Thank you!')).'</textarea></div>';
echo '</div></div>';
echo '</div>';
echo '<div style="margin-top:18px"><button type="submit" class="sz-btn sz-btn-primary" style="padding:10px 26px">💾 Save Settings</button></div>';
echo '</form></div>';
storz_nav_end();
