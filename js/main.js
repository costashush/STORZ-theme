/* STORZ Front-end JS v1.0.1 */
(function(){
'use strict';

/* Theme toggle */
(function(){
  var html=document.documentElement;
  var btn=document.getElementById('theme-toggle');
  var saved=localStorage.getItem('storz-theme')||(window.StorzCfg&&StorzCfg.theme)||'dark';
  html.setAttribute('data-theme',saved);
  if(btn){
    btn.setAttribute('aria-pressed',saved==='light'?'true':'false');
    btn.addEventListener('click',function(){
      var next=html.getAttribute('data-theme')==='dark'?'light':'dark';
      html.setAttribute('data-theme',next);
      localStorage.setItem('storz-theme',next);
      btn.setAttribute('aria-pressed',next==='light'?'true':'false');
    });
  }
})();

/* Mobile nav */
(function(){
  var btn=document.getElementById('menu-toggle');
  var nav=document.getElementById('primary-nav');
  if(!btn||!nav)return;
  btn.addEventListener('click',function(){
    var open=nav.classList.toggle('open');
    btn.setAttribute('aria-expanded',open?'true':'false');
    btn.textContent=open?'\u2715':'\u2630';
  });
  document.addEventListener('keydown',function(e){
    if(e.key==='Escape'&&nav.classList.contains('open')){nav.classList.remove('open');btn.setAttribute('aria-expanded','false');btn.textContent='\u2630';}
  });
})();

/* Form AJAX */
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.storz-form').forEach(function(form){
    var fid=form.dataset.formId,btn=form.querySelector('.sz-submit-btn'),msgs=form.querySelector('.sz-messages');
    if(!btn||!fid)return;
    btn.addEventListener('click',function(){submit(form,fid,btn,msgs);});
    form.querySelectorAll('input:not([type=checkbox]):not([type=radio])').forEach(function(inp){
      inp.addEventListener('keydown',function(e){if(e.key==='Enter')submit(form,fid,btn,msgs);});
    });
  });
});

function submit(form,fid,btn,msgs){
  form.querySelectorAll('.sz-field-error').forEach(function(el){el.style.display='none';el.textContent='';});
  form.querySelectorAll('input,textarea,select').forEach(function(el){el.classList.remove('has-error');});
  msgs.innerHTML='';
  var data=new FormData();
  data.append('action','storz_submit');data.append('nonce',StorzCfg.nonce);data.append('form_id',fid);
  form.querySelectorAll('.sz-field[data-field-id]').forEach(function(fe){
    var key='field_'+fe.dataset.fieldId;
    var checks=fe.querySelectorAll('input[type=checkbox]:checked,input[type=radio]:checked');
    if(checks.length)checks.forEach(function(c){data.append(key+'[]',c.value);});
    else{var inp=fe.querySelector('input,textarea,select');if(inp)data.append(key,inp.value);}
  });
  btn.disabled=true;
  var lbl=btn.querySelector('.btn-lbl'),spin=btn.querySelector('.btn-spin');
  if(lbl)lbl.style.display='none';if(spin)spin.style.display='inline';
  fetch(StorzCfg.ajaxUrl,{method:'POST',body:data}).then(function(r){return r.json();})
    .then(function(res){
      if(res.success){
        form.querySelector('.sz-fields').style.display='none';
        form.querySelector('.sz-submit-wrap').style.display='none';
        msgs.innerHTML='<div class="sz-msg-success">\u2713 '+h(res.data.message)+'</div>';
        msgs.firstElementChild.focus();
      } else {
        var errs=res.data&&res.data.errors?res.data.errors:{};
        var first=true;
        Object.keys(errs).forEach(function(id){
          var fe=form.querySelector('.sz-field[data-field-id="'+id+'"]');
          if(fe){var ee=fe.querySelector('.sz-field-error'),inp=fe.querySelector('input,textarea,select');
            if(ee){ee.textContent=errs[id];ee.style.display='block';}
            if(inp)inp.classList.add('has-error');
            if(first){fe.scrollIntoView({behavior:'smooth',block:'center'});if(inp)inp.focus();first=false;}
          }
        });
        if(first){msgs.innerHTML='<div class="sz-msg-error">'+h(res.data&&typeof res.data==='string'?res.data:'Please check the form.')+'</div>';msgs.firstElementChild.focus();}
      }
    })
    .catch(function(){msgs.innerHTML='<div class="sz-msg-error">Network error. Please try again.</div>';})
    .finally(function(){btn.disabled=false;if(lbl)lbl.style.display='';if(spin)spin.style.display='none';});
}
function h(s){var d=document.createElement('div');d.textContent=String(s);return d.innerHTML;}
})();
