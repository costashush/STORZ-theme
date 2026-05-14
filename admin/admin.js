/* STORZ Admin JS v1.0.1 */
(function($){
'use strict';

const B={id:0,fields:[],active:null,ctr:0,dirty:false,types:{
  text:{l:'Short Text',i:'📝',opts:false,rows:false},
  textarea:{l:'Long Text',i:'📄',opts:false,rows:true},
  email:{l:'Email',i:'✉️',opts:false,rows:false},
  tel:{l:'Phone',i:'📞',opts:false,rows:false},
  number:{l:'Number',i:'🔢',opts:false,rows:false},
  url:{l:'URL',i:'🔗',opts:false,rows:false},
  date:{l:'Date',i:'📅',opts:false,rows:false},
  select:{l:'Dropdown',i:'⬇️',opts:true,rows:false},
  checkbox:{l:'Checkboxes',i:'☑️',opts:true,rows:false},
  radio:{l:'Radio',i:'🔘',opts:true,rows:false},
  rating:{l:'Rating Stars',i:'⭐',opts:false,rows:false},
  row:{l:'Column Row',i:'⊞',opts:false,rows:false},
}};

$(function(){
  if($('#sz-builder').length)  initBuilder();
  if($('#sz-db-wrap').length)  initDB();
  if($('#sz-roles-wrap').length) initRoles();
  initGlobal(); initAuto(); initBrand(); initExport();
});

/* ── BUILDER ── */
function initBuilder(){
  try{const raw=$('#sz-form-data').val();if(raw){const d=JSON.parse(raw);B.id=d.id||0;B.fields=d.fields||[];B.ctr=flatFields(B.fields).reduce((m,f)=>Math.max(m,+f.id||0),0);}}catch(e){}
  renderCanvas();
  $(document).on('click','.sz-pi',function(){addField($(this).data('type'));});
  initSortable();
  $('#sz-save-btn').on('click',saveForm);
  $(document).on('keydown',function(e){if((e.ctrlKey||e.metaKey)&&e.key==='s'){e.preventDefault();saveForm();}});
}

function initSortable(){
  var $c=$('#sz-canvas-body');
  if(!$c.length||!$.fn.sortable)return;
  try{$c.sortable('destroy');}catch(e){}
  $c.sortable({items:'>.sz-fc',handle:'.sz-dh',placeholder:'sz-sph',tolerance:'pointer',axis:'y',revert:100,
    update:function(){syncOrder();markDirty();}
  });
  $c.disableSelection();
}

function flatFields(f){const r=[];(f||[]).forEach(x=>{if(x.type==='row')(x.children||[]).forEach(c=>r.push(c));else r.push(x);});return r;}

function addField(type){
  B.ctr++;const d=B.types[type]||{l:type,i:'❓',opts:false,rows:false};
  const f={id:''+B.ctr,type,label:d.l,placeholder:'',hint:'',required:false,options:d.opts?['Option 1','Option 2','Option 3']:[]};
  if(type==='row'){f.label='2-Column Row';f.cols=2;f.children=[{id:''+(++B.ctr),type:'text',label:'Field A',placeholder:'',hint:'',required:false,options:[]},{id:''+(++B.ctr),type:'text',label:'Field B',placeholder:'',hint:'',required:false,options:[]}];}
  else if(d.rows)f.rows=4;
  B.fields.push(f);renderCanvas();selectField(f.id);markDirty();
  var $el=$(`.sz-fc[data-fid="${esc(f.id)}"]`);if($el.length)$el[0].scrollIntoView({behavior:'smooth',block:'nearest'});
}

function renderCanvas(){
  var $b=$('#sz-canvas-body'),$e=$('#sz-ce');
  $b.find('.sz-fc').remove();
  if(!B.fields.length){$e.show();initSortable();return;}$e.hide();
  B.fields.forEach(function(f){
    var d=B.types[f.type]||{i:'❓',l:f.type};
    var extra='';
    if(f.type==='row'){extra='<div style="margin-top:5px">'+(f.children||[]).map(c=>'<span style="font-size:.68rem;background:var(--sz-ad);color:#a78bfa;padding:2px 6px;border-radius:3px;margin-right:3px">'+esc(c.label)+'</span>').join('')+'</div>';}
    var $c=$('<div class="sz-fc'+(f.type==='row'?' sz-row-card':'')+(f.id===B.active?' sz-act':'')+'" data-fid="'+esc(f.id)+'">\
      <div class="sz-fch"><div class="sz-fcl"><span class="sz-dh" title="Drag">⠿</span>\
      <div><div class="sz-fcn">'+esc(f.label)+'</div><div class="sz-fct">'+d.i+' '+d.l+(f.type==='row'?' ('+f.cols+' cols)':'')+'</div></div></div>\
      <div class="sz-fca">'+(f.required?'<span class="sz-badge sz-ok-b" style="font-size:.6rem;padding:2px 5px">Req</span>':'')+'\
      <button type="button" class="sz-btn sz-btn-ghost sz-btn-sm sz-dup" title="Duplicate">⧉</button>\
      <button type="button" class="sz-btn sz-btn-ghost sz-btn-sm sz-delc" title="Delete">✕</button>\
      </div></div>'+extra+'</div>');
    $c.on('click',function(e){if(!$(e.target).is('button')&&!$(e.target).closest('button').length)selectField(f.id);});
    $c.find('.sz-delc').on('click',function(e){e.stopPropagation();if(!confirm('Delete this field?'))return;B.fields=B.fields.filter(x=>x.id!==f.id);if(B.active===f.id){B.active=null;propsEmpty();}renderCanvas();markDirty();});
    $c.find('.sz-dup').on('click',function(e){e.stopPropagation();B.ctr++;var cl=JSON.parse(JSON.stringify(f));cl.id=''+B.ctr;cl.label+=' (copy)';if(cl.children)cl.children=cl.children.map(ch=>{B.ctr++;return{...ch,id:''+B.ctr};});B.fields.splice(B.fields.findIndex(x=>x.id===f.id)+1,0,cl);renderCanvas();selectField(cl.id);markDirty();});
    $b.append($c);
  });
  initSortable();
}

function selectField(id){B.active=id;var f=B.fields.find(x=>x.id===id);if(!f)return;$('.sz-fc').removeClass('sz-act');$(`.sz-fc[data-fid="${esc(id)}"]`).addClass('sz-act');renderProps(f);}

function renderProps(f){
  var $b=$('#sz-props-body'),d=B.types[f.type]||{};
  var html='<div class="sz-sect"><div class="sz-sect-title">Basic</div>\
    <div class="sz-fg"><label>Label</label><input id="pp-l" value="'+esc(f.label)+'"></div>\
    '+(f.type!=='row'?'<div class="sz-fg"><label>Placeholder</label><input id="pp-p" value="'+esc(f.placeholder||'')+'"></div>':'')+'\
    <div class="sz-fg"><label>Helper Text</label><input id="pp-h" value="'+esc(f.hint||'')+'"></div>\
    '+(d.rows?'<div class="sz-fg"><label>Rows</label><input type="number" id="pp-r" value="'+(f.rows||4)+'" min="2" max="20"></div>':'')+'\
    </div>';
  if(f.type!=='row')html+='<div class="sz-sect"><div class="sz-sect-title">Validation</div>\
    <div class="sz-toggle"><label for="pp-req">Required</label><label class="sz-sw"><input type="checkbox" id="pp-req" '+(f.required?'checked':'')+'/><span class="sz-swr"></span></label></div></div>';
  if(f.type==='row')html+='<div class="sz-sect"><div class="sz-sect-title">Columns</div>\
    <div class="sz-fg"><label>Number of Columns</label><select id="pp-cols"><option value="2" '+(f.cols==2?'selected':'')+'>2 Columns</option><option value="3" '+(f.cols==3?'selected':'')+'>3 Columns</option></select></div></div>';
  if(d.opts){var opts=(f.options||[]).map((o,i)=>'<div class="sz-or" data-i="'+i+'"><input class="sz-oi" value="'+esc(o)+'" placeholder="Option '+(i+1)+'"><button type="button" class="sz-od" data-i="'+i+'">✕</button></div>').join('');
    html+='<div class="sz-sect"><div class="sz-sect-title">Options</div><div class="sz-opts" id="pp-opts">'+opts+'</div><button type="button" class="sz-btn sz-btn-secondary sz-btn-sm" id="pp-ao" style="width:100%;justify-content:center;margin-top:4px">+ Add Option</button></div>';}
  $b.html(html);
  $b.off('.props');
  $b.on('input.props change.props','#pp-l',function(){upd(f.id,'label',$(this).val());});
  $b.on('input.props change.props','#pp-p',function(){upd(f.id,'placeholder',$(this).val());});
  $b.on('input.props change.props','#pp-h',function(){upd(f.id,'hint',$(this).val());});
  $b.on('input.props change.props','#pp-r',function(){upd(f.id,'rows',parseInt($(this).val())||4);});
  $b.on('change.props','#pp-req',function(){upd(f.id,'required',$(this).is(':checked'));renderCanvas();selectField(f.id);});
  $b.on('change.props','#pp-cols',function(){upd(f.id,'cols',parseInt($(this).val()));renderCanvas();selectField(f.id);});
  $b.on('input.props','.sz-oi',function(){var i=+$(this).closest('.sz-or').data('i');var o=[...(f.options||[])];o[i]=$(this).val();upd(f.id,'options',o);});
  $b.on('click.props','.sz-od',function(){var i=+$(this).data('i');var o=[...(f.options||[])];o.splice(i,1);upd(f.id,'options',o);renderProps(B.fields.find(x=>x.id===f.id));});
  $b.on('click.props','#pp-ao',function(){var o=[...(f.options||[])];o.push('Option '+(o.length+1));upd(f.id,'options',o);renderProps(B.fields.find(x=>x.id===f.id));});
}
function propsEmpty(){$('#sz-props-body').html('<div class="sz-pe"><span class="pi">👈</span><p>Select a field to edit its properties</p></div>');}
function upd(id,k,v){var f=B.fields.find(x=>x.id===id);if(!f)return;f[k]=v;if(k==='label')$(`.sz-fc[data-fid="${esc(id)}"] .sz-fcn`).text(v);markDirty();}
function syncOrder(){var o=[];$('#sz-canvas-body>.sz-fc').each(function(){var id=$(this).data('fid');var f=B.fields.find(x=>x.id===''+id);if(f)o.push(f);});B.fields=o;}
function saveForm(){
  var name=$('#sz-form-name').val().trim();if(!name){toast('Enter a form name','err');$('#sz-form-name').focus();return;}
  var sets={submit_label:$('#sz-submit-label').val()||'Submit',success_message:$('#sz-success-msg').val()||'Thank you!',notification_email:$('#sz-notify-email').val()||'',gmail_enabled:$('#sz-gmail-enabled').is(':checked')?'1':'0'};
  var $btn=$('#sz-save-btn');$btn.prop('disabled',true).text('Saving…');
  $.post(StorzAdmin.ajaxUrl,{action:'storz_save_form',nonce:StorzAdmin.nonce,form_id:B.id,name,description:$('#sz-form-desc').val(),fields:JSON.stringify(B.fields),settings:JSON.stringify(sets)},function(r){
    if(r.success){B.id=r.data.id;var u=new URL(location.href);u.searchParams.set('form_id',B.id);history.replaceState({},'',u);markClean();toast('Saved! [storz_form id="'+B.id+'"]','ok');}
    else toast(r.data||'Save error','err');
  }).fail(()=>toast('Network error','err')).always(()=>$btn.prop('disabled',false).text('💾 Save Form'));
}
function markDirty(){B.dirty=true;$('#sz-ss').text('Unsaved changes').removeClass('saved');}
function markClean(){B.dirty=false;$('#sz-ss').text('✓ Saved').addClass('saved');}
window.onbeforeunload=function(){if(B.dirty)return 'Unsaved changes!';};

/* ── DB MANAGER ── */
function initDB(){
  $.post(StorzAdmin.ajaxUrl,{action:'storz_db',nonce:StorzAdmin.nonce,db_action:'list'},function(r){
    if(!r.success)return;var $l=$('#sz-db-list');$l.empty();
    r.data.tables.forEach(t=>$l.append('<div class="sz-dbt" data-t="'+esc(t)+'" title="'+esc(t)+'">'+esc(t)+'</div>'));
    if(r.data.tables.length)$l.find('.sz-dbt:first').trigger('click');
  });
  $(document).on('click','.sz-dbt',function(){$('.sz-dbt').removeClass('act');$(this).addClass('act');loadRows($(this).data('t'),1);});
  $(document).on('click','#sz-db-prev',function(){var p=+$('#sz-db-pg').val()||1;if(p>1)loadRows($('.sz-dbt.act').data('t'),p-1);});
  $(document).on('click','#sz-db-next',function(){var p=+$('#sz-db-pg').val()||1;loadRows($('.sz-dbt.act').data('t'),p+1);});
  $(document).on('input','#sz-db-srch',function(){var q=$(this).val().toLowerCase();$('.sz-dbt').each(function(){$(this).toggle($(this).text().toLowerCase().includes(q));});});
  $(document).on('click','.sz-db-del',function(e){e.stopPropagation();if(!confirm('Delete this row?'))return;
    $.post(StorzAdmin.ajaxUrl,{action:'storz_db',nonce:StorzAdmin.nonce,db_action:'delete_row',table:$(this).data('t'),pk:$(this).data('pk'),val:$(this).data('v')},function(r){if(r.success){toast('Deleted','ok');$('.sz-dbt.act').trigger('click');}else toast('Failed','err');});
  });
}
function loadRows(table,page){
  var $w=$('#sz-db-content');$w.html('<p style="color:var(--sz-m);padding:20px">Loading…</p>');$('#sz-db-pg').val(page);
  $.post(StorzAdmin.ajaxUrl,{action:'storz_db',nonce:StorzAdmin.nonce,db_action:'rows',table,page},function(r){
    if(!r.success){$w.html('<p style="color:var(--sz-err);padding:20px">Error loading.</p>');return;}
    var{rows,cols,total,per}=r.data;
    if(!rows.length){$w.html('<div class="sz-empty"><div class="sz-ei">📭</div><p>No rows.</p></div>');return;}
    var pk=cols[0]||'id';
    var h='<div class="sz-tw"><table class="sz-table"><thead><tr>'+cols.map(c=>'<th>'+esc(c)+'</th>').join('')+'<th></th></tr></thead><tbody>';
    rows.forEach(row=>{h+='<tr>'+cols.map(c=>'<td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="'+esc(String(row[c]??''))+'">'+esc(String(row[c]??'').substring(0,60))+'</td>').join('')+'<td><button type="button" class="sz-btn sz-btn-danger sz-btn-sm sz-db-del" data-t="'+esc(table)+'" data-pk="'+esc(pk)+'" data-v="'+esc(String(row[pk]||''))+'">✕</button></td></tr>';});
    h+='</tbody></table></div>';$w.html(h);
    var pages=Math.ceil(total/per);$('#sz-db-info').text(total+' rows · Page '+page+'/'+pages);
    $('#sz-db-prev').prop('disabled',page<=1);$('#sz-db-next').prop('disabled',page>=pages);
  });
}

/* ── ROLES ── */
function initRoles(){
  $(document).on('click','#sz-role-save',function(){
    var k=$('#sz-rk').val().trim(),n=$('#sz-rn').val().trim();if(!k||!n){toast('Key and name required','err');return;}
    var caps=[];$('.sz-cap-item input:checked').each(function(){caps.push($(this).val());});
    $.post(StorzAdmin.ajaxUrl,{action:'storz_save_role',nonce:StorzAdmin.nonce,role_key:k,display_name:n,caps,extra_caps:$('#sz-extra-caps').val()},function(r){if(r.success){toast(r.data.message,'ok');setTimeout(()=>location.reload(),800);}else toast(r.data||'Error','err');});
  });
  $(document).on('click','.sz-role-del',function(){var k=$(this).data('k');if(!confirm('Delete "'+k+'"?'))return;$.post(StorzAdmin.ajaxUrl,{action:'storz_delete_role',nonce:StorzAdmin.nonce,role_key:k},function(r){if(r.success){toast(r.data.message,'ok');setTimeout(()=>location.reload(),800);}else toast(r.data||'Error','err');});});
  $(document).on('click','.sz-role-edit',function(){$('#sz-rk').val($(this).data('k')).prop('readonly',true);$('#sz-rn').val($(this).data('n'));var caps=$(this).data('caps')||[];$('.sz-cap-item input').prop('checked',false);caps.forEach(c=>$(`.sz-cap-item input[value="${c}"]`).prop('checked',true));$('html,body').animate({scrollTop:$('#sz-role-form').offset().top-80},300);});
}

/* ── AUTOMATION ── */
function initAuto(){
  $(document).on('click','#sz-wa-send',()=>sendMsg('whatsapp'));
  $(document).on('click','#sz-em-send',()=>sendMsg('email'));
  $(document).on('click','#sz-gm-send',()=>sendMsg('gmail'));
}
function sendMsg(ch){var rec=$('#sz-rec-'+ch).val().trim(),sub=($('#sz-sub-'+ch).val()||'').trim(),msg=$('#sz-msg-'+ch).val().trim();if(!rec||!msg){toast('Recipient and message required','err');return;}$.post(StorzAdmin.ajaxUrl,{action:'storz_send',nonce:StorzAdmin.nonce,channel:ch,recipient:rec,subject:sub,message:msg},function(r){if(r.success){toast(r.data.message,'ok');$('#sz-msg-'+ch).val('');}else toast(r.data||'Failed','err');});}

/* ── BRANDING ── */
function initBrand(){$(document).on('click','#sz-brand-save',function(){var data={action:'storz_save_brand',nonce:StorzAdmin.nonce};$('#sz-brand-form input,#sz-brand-form textarea').each(function(){if($(this).attr('name'))data[$(this).attr('name')]=$(this).val();});$.post(StorzAdmin.ajaxUrl,data,function(r){if(r.success)toast(r.data.message,'ok');else toast('Failed','err');});});}

/* ── EXPORT / IMPORT ── */
function initExport(){
  $(document).on('click','#sz-export-btn',function(){var ids=[];$('.sz-form-check:checked').each(function(){ids.push($(this).data('id'));});$.post(StorzAdmin.ajaxUrl,{action:'storz_export_forms',nonce:StorzAdmin.nonce,ids},function(r){if(r.success){$('#sz-export-out').val(r.data.json).show();toast('JSON ready','ok');}else toast(r.data||'Failed','err');});});
  $(document).on('click','#sz-export-csv-btn',function(){var fid=$('#sz-csv-form-select').val();$.post(StorzAdmin.ajaxUrl,{action:'storz_export_csv',nonce:StorzAdmin.nonce,form_id:fid},function(r){if(r.success){var a=document.createElement('a');a.href=URL.createObjectURL(new Blob([r.data.csv],{type:'text/csv'}));a.download=r.data.filename;a.click();toast('CSV downloaded','ok');}else toast(r.data||'No data','err');});});
  $(document).on('click','#sz-download-json',function(){var t=$('#sz-export-out').val();if(!t)return;var a=document.createElement('a');a.href=URL.createObjectURL(new Blob([t],{type:'application/json'}));a.download='storz-forms-'+Date.now()+'.json';a.click();});
  $(document).on('click','#sz-import-btn',function(){var j=$('#sz-import-in').val().trim();if(!j){toast('Paste JSON first','err');return;}$.post(StorzAdmin.ajaxUrl,{action:'storz_import_forms',nonce:StorzAdmin.nonce,import_json:j},function(r){if(r.success){toast(r.data.message,'ok');$('#sz-import-in').val('');}else toast(r.data||'Failed','err');});});
  $(document).on('click','#sz-seed-forms-btn',function(){if(!confirm('Re-seed 5 demo forms? All existing forms and submissions will be deleted.'))return;$.post(StorzAdmin.ajaxUrl,{action:'storz_reseed_forms',nonce:StorzAdmin.nonce},function(r){if(r.success){toast(r.data.message,'ok');setTimeout(()=>location.reload(),1200);}else toast(r.data||'Failed','err');});});
}

/* ── GLOBAL ── */
function initGlobal(){
  $(document).on('click','.sz-del-form',function(e){e.preventDefault();if(!confirm('Delete this form and all its submissions?'))return;var id=$(this).data('id'),$r=$(this).closest('tr');$.post(StorzAdmin.ajaxUrl,{action:'storz_delete_form',nonce:StorzAdmin.nonce,form_id:id},function(r){if(r.success){$r.fadeOut(280,function(){$(this).remove();});toast('Deleted','ok');}else toast(r.data||'Error','err');});});
  $(document).on('click','.sz-sc',function(){var t=$(this).data('sc')||$(this).text().trim();if(navigator.clipboard)navigator.clipboard.writeText(t);else{var $i=$('<input>').val(t).appendTo('body').select();document.execCommand('copy');$i.remove();}toast('Copied!','ok');});
  $(document).on('click','.sz-sub-row',function(){$(this).next('.sz-sub-detail').toggle();});
  /* Login logo upload */
  $(document).on('click','#sz-upload-login-logo',function(){
    var frame;
    if(!frame){frame=wp.media({title:'Select Login Logo',button:{text:'Use as Login Logo'},multiple:false});
    frame.on('select',function(){var att=frame.state().get('selection').first().toJSON();$('#sz-login-logo-id').val(att.id);$.post(StorzAdmin.ajaxUrl,{action:'storz_save_login_logo',nonce:StorzAdmin.nonce,logo_id:att.id},function(r){if(r.success){toast(r.data.message,'ok');setTimeout(()=>location.reload(),900);}else toast('Error','err');});});}
    frame.open();
  });
  $(document).on('click','#sz-remove-login-logo',function(){$.post(StorzAdmin.ajaxUrl,{action:'storz_save_login_logo',nonce:StorzAdmin.nonce,logo_id:0},function(r){if(r.success){toast('Logo removed','ok');setTimeout(()=>location.reload(),800);}});});
}

/* ── UTILS ── */
function toast(msg,type){type=type||'ok';var $w=$('#sz-toasts');if(!$w.length)$w=$('<div id="sz-toasts"></div>').appendTo('body');var $t=$('<div class="sz-toast '+type+'"><span class="sz-ti">'+(type==='ok'?'✓':'✕')+'</span><span>'+msg+'</span></div>');$w.append($t);setTimeout(function(){$t.fadeOut(280,function(){$t.remove();});},3800);}
function esc(s){if(s==null)return'';return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');}
window.szToast=toast;
})(jQuery);
