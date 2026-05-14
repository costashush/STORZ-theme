<?php
if(!defined('ABSPATH'))exit;
global $wpdb;
$logs=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}storz_automation_log ORDER BY created_at DESC LIMIT 50");
$gm_tok=get_option('storz_gmail_access_token','');$gm_from=get_option('storz_gmail_from_email','');
$cid=get_option('storz_gmail_client_id','');$wa_ok=get_option('storz_wa_token','')&&get_option('storz_wa_phone_id','');
$gm_auth_url='';
if($cid){$p=http_build_query(['client_id'=>$cid,'redirect_uri'=>admin_url('admin.php?page=storz-automation'),'response_type'=>'code','scope'=>'https://www.googleapis.com/auth/gmail.send https://www.googleapis.com/auth/userinfo.email','access_type'=>'offline','prompt'=>'consent']);$gm_auth_url='https://accounts.google.com/o/oauth2/v2/auth?'.$p;}
if(isset($_GET['gmail'])&&$_GET['gmail']==='connected')echo '<div class="notice notice-success is-dismissible"><p>✓ Gmail connected: '.esc_html($gm_from).'</p></div>';
storz_nav('storz-automation');
echo '<div class="sz-content"><div class="sz-ph"><div><h2>Automation Hub</h2><p>Send WhatsApp, Email, and Gmail messages.</p></div></div>';
echo '<div class="sz-auto-grid">';
// WhatsApp
$wab=$wa_ok?'sz-ok-b':'sz-off-b';$wal=$wa_ok?'Connected':'Not configured';
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-wa2)">📱</div><h3>WhatsApp</h3><span class="sz-badge '.$wab.'">'.$wal.'</span></div>';
echo '<div style="padding:16px;display:flex;flex-direction:column;gap:12px"><div class="sz-fg"><label>Recipient Phone</label><input id="sz-rec-whatsapp" placeholder="+1234567890" type="tel"></div>';
echo '<div class="sz-fg"><label>Message</label><textarea id="sz-msg-whatsapp" style="min-height:80px"></textarea></div>';
echo '<button class="sz-btn sz-btn-wa" id="sz-wa-send" style="justify-content:center;padding:10px">📱 Send WhatsApp</button></div></div>';
// Email
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:var(--sz-ad)">✉️</div><h3>Email (wp_mail)</h3><span class="sz-badge sz-ok-b">Ready</span></div>';
echo '<div style="padding:16px;display:flex;flex-direction:column;gap:12px"><div class="sz-fg"><label>To</label><input id="sz-rec-email" placeholder="recipient@example.com" type="email"></div>';
echo '<div class="sz-fg"><label>Subject</label><input id="sz-sub-email" placeholder="Subject"></div>';
echo '<div class="sz-fg"><label>Message</label><textarea id="sz-msg-email" style="min-height:80px"></textarea></div>';
echo '<button class="sz-btn sz-btn-primary" id="sz-em-send" style="justify-content:center;padding:10px">✉️ Send Email</button></div></div>';
// Gmail
$gm_badge=$gm_tok?'sz-gm-b':'sz-off-b';$gm_label=$gm_tok?'✓ '.esc_html($gm_from):'Not connected';
echo '<div class="sz-panel"><div class="sz-card-head"><div class="sz-card-icon" style="background:rgba(234,67,53,.1)">📧</div><h3>Gmail (OAuth2)</h3><span class="sz-badge '.$gm_badge.'">'.$gm_label.'</span></div>';
echo '<div style="padding:16px;display:flex;flex-direction:column;gap:12px">';
if(!$cid){echo '<p style="font-size:.82rem;color:var(--sz-m)">Enter Client ID in ⚙️ Settings first.</p><a href="'.esc_url(admin_url('admin.php?page=storz-settings')).'" class="sz-btn sz-btn-secondary" style="justify-content:center">→ Settings</a>';}
elseif(!$gm_tok){echo '<p style="font-size:.82rem;color:var(--sz-m)">Authorise STORZ to send via Gmail.</p><a href="'.esc_url($gm_auth_url).'" class="sz-btn sz-btn-gmail" style="justify-content:center;padding:10px">📧 Connect Gmail</a>';}
else{echo '<div class="sz-fg"><label>To</label><input id="sz-rec-gmail" placeholder="recipient@example.com" type="email"></div><div class="sz-fg"><label>Subject</label><input id="sz-sub-gmail" placeholder="Subject"></div><div class="sz-fg"><label>Message</label><textarea id="sz-msg-gmail" style="min-height:80px"></textarea></div><button class="sz-btn sz-btn-gmail" id="sz-gm-send" style="justify-content:center;padding:10px">📧 Send via Gmail</button>';}
echo '</div></div>';
echo '</div>';
// Delivery log
echo '<div class="sz-ph" style="margin-bottom:12px;margin-top:8px"><div><h2 style="font-size:1.1rem">📋 Delivery Log</h2></div></div>';
if(empty($logs)){echo '<div class="sz-tw"><div class="sz-empty"><div class="sz-ei">📭</div><p>No messages sent yet.</p></div></div>';}
else{
    echo '<div class="sz-tw"><table class="sz-table"><thead><tr><th>#</th><th>Channel</th><th>Recipient</th><th>Subject</th><th>Status</th><th>Date</th></tr></thead><tbody>';
    foreach($logs as $l){
        $ch_map=['whatsapp'=>'sz-wa-b','gmail'=>'sz-gm-b'];$ch_cls=$ch_map[$l->channel]??'sz-ac-b';
        $st_cls=$l->status==='sent'?'sz-ok-b':'sz-err-b';
        echo '<tr><td style="font-size:.76rem;color:var(--sz-m)">#'.$l->id.'</td>';
        echo '<td><span class="sz-badge '.$ch_cls.'">'.esc_html($l->channel).'</span></td>';
        echo '<td style="font-size:.79rem">'.esc_html($l->recipient??'—').'</td>';
        echo '<td style="font-size:.78rem">'.esc_html(wp_trim_words($l->subject??'—',7)).'</td>';
        echo '<td><span class="sz-badge '.$st_cls.'">'.esc_html($l->status).'</span></td>';
        echo '<td style="font-size:.75rem;color:var(--sz-m)">'.esc_html(date('M j, Y g:i a',strtotime($l->created_at))).'</td></tr>';
    }
    echo '</tbody></table></div>';
}
echo '</div>';
storz_nav_end();
