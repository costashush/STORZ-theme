<?php
if(!defined('ABSPATH'))exit;
storz_nav('storz-db-manager');
echo '<div class="sz-content" id="sz-db-wrap">';
echo '<div class="sz-ph"><div><h2>DB Manager</h2><p>Browse and delete rows from any database table.</p></div></div>';
echo '<div style="display:flex;gap:10px;align-items:center;margin-bottom:14px;flex-wrap:wrap">';
echo '<input type="text" id="sz-db-srch" class="sz-dbsrch" placeholder="🔍 Filter tables…" style="width:200px">';
echo '<span id="sz-db-info" style="font-size:.78rem;color:var(--sz-m)">Select a table</span>';
echo '<div class="sz-dbpager"><input type="hidden" id="sz-db-pg" value="1">';
echo '<button class="sz-btn sz-btn-secondary sz-btn-sm" id="sz-db-prev" disabled>&#8592; Prev</button>';
echo '<button class="sz-btn sz-btn-secondary sz-btn-sm" id="sz-db-next" disabled>Next &#8594;</button></div></div>';
echo '<div class="sz-db"><div class="sz-panel"><div class="sz-panel-head">Tables</div><div class="sz-db-list" id="sz-db-list"><p style="color:var(--sz-m);font-size:.8rem;padding:8px">Loading…</p></div></div>';
echo '<div id="sz-db-content"><div class="sz-empty"><div class="sz-ei">🗄</div><h3>Select a table</h3><p>Click a table to view its rows.</p></div></div></div>';
echo '</div>';
storz_nav_end();
