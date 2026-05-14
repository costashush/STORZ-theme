<?php
if(!defined('ABSPATH'))exit;
$form_id=isset($_GET['form_id'])?absint($_GET['form_id']):0;
$form=$form_id?storz_get_form($form_id):null;
$name=$form?$form->name:'';$desc=$form?$form->description:'';
$sets=$form?(json_decode($form->settings,true)?:[]):[];
$sl=$sets['submit_label']??'Submit';$sm=$sets['success_message']??'Thank you!';
$ne=$sets['notification_email']??get_option('admin_email');$gm=($sets['gmail_enabled']??'0')==='1';
$js_data=wp_json_encode(['id'=>$form_id,'fields'=>json_decode($form?$form->fields:'[]')]);
$types=['text'=>['Short Text','📝'],'textarea'=>['Long Text','📄'],'email'=>['Email','✉️'],'tel'=>['Phone','📞'],'number'=>['Number','🔢'],'url'=>['URL','🔗'],'date'=>['Date','📅'],'select'=>['Dropdown','⬇️'],'checkbox'=>['Checkboxes','☑️'],'radio'=>['Radio','🔘'],'rating'=>['Rating Stars','⭐'],'row'=>['Column Row','⊞']];
storz_nav('storz-builder');
echo '<input type="hidden" id="sz-form-data" value="'.esc_attr($js_data).'">';
echo '<div class="sz-content">';
// Save bar
$sc_html=$form_id?('<span class="sz-sc" data-sc="[storz_form id=&quot;'.$form_id.'&quot;]">📋 [storz_form id=&quot;'.$form_id.'&quot;]</span>'):'';
echo '<div class="sz-save-bar"><div style="display:flex;align-items:center;gap:12px;flex:1">';
echo '<input type="text" id="sz-form-name" value="'.esc_attr($name).'" placeholder="Form name (required)" style="background:var(--sz-s2);border:1px solid var(--sz-b);border-radius:var(--sz-rs);color:var(--sz-t);font-family:var(--fd);font-size:1rem;font-weight:700;padding:7px 14px;outline:none;width:260px">';
echo $sc_html;
echo '</div><div class="sz-bacts"><span class="sz-ss" id="sz-ss">'.($form_id?'✓ Saved':'Not saved').'</span>';
echo '<button class="sz-btn sz-btn-primary" id="sz-save-btn">💾 Save Form</button></div></div>';
// Builder
echo '<div class="sz-builder" id="sz-builder">';
// Palette
echo '<div class="sz-panel"><div class="sz-panel-head">📦 Field Types</div><div class="sz-palette-list">';
foreach($types as $tk=>[$tl,$ti]){echo '<div class="sz-pi" data-type="'.esc_attr($tk).'"><span class="fi">'.$ti.'</span>'.esc_html($tl).'</div>';}
echo '</div><div class="sz-panel-head" style="border-top:1px solid var(--sz-b)">⚙️ Form Settings</div>';
echo '<div style="padding:10px;display:flex;flex-direction:column;gap:9px">';
echo '<div class="sz-fg"><label>Description</label><textarea id="sz-form-desc" style="min-height:48px;font-size:.82rem">'.esc_textarea($desc).'</textarea></div>';
echo '<div class="sz-fg"><label>Submit Label</label><input id="sz-submit-label" value="'.esc_attr($sl).'" placeholder="Submit"></div>';
echo '<div class="sz-fg"><label>Success Message</label><textarea id="sz-success-msg" style="min-height:48px;font-size:.82rem">'.esc_textarea($sm).'</textarea></div>';
echo '<div class="sz-fg"><label>Notify Email</label><input type="email" id="sz-notify-email" value="'.esc_attr($ne).'"></div>';
echo '<div class="sz-toggle" style="padding:4px 0"><label for="sz-gmail-enabled" style="font-size:.82rem">Send via Gmail</label>';
echo '<label class="sz-sw"><input type="checkbox" id="sz-gmail-enabled"'.($gm?' checked':'').'><span class="sz-swr"></span></label></div>';
if(!get_option('storz_gmail_access_token','')){echo '<p style="font-size:.72rem;color:var(--sz-m)">⚠️ <a href="'.esc_url(admin_url('admin.php?page=storz-settings')).'" style="color:#a78bfa">Connect Gmail in Settings</a></p>';}
echo '</div></div>';
// Canvas
echo '<div class="sz-panel"><div class="sz-panel-head">🎨 Canvas — click to add &middot; drag ⠿ to reorder</div>';
echo '<div class="sz-canvas-body" id="sz-canvas-body" style="min-height:460px;position:relative">';
echo '<div class="sz-ce" id="sz-ce"><div class="ci">👈</div><p>Click a field type to start</p></div>';
echo '</div></div>';
// Properties
echo '<div class="sz-panel" style="display:flex;flex-direction:column"><div class="sz-panel-head">🔧 Field Properties</div>';
echo '<div class="sz-props-body" id="sz-props-body"><div class="sz-pe"><span class="pi">👈</span><p>Select a field to edit</p></div></div></div>';
echo '</div></div>';
storz_nav_end();
