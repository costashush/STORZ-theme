
/**
 * STORZ + FormCraft UI Merge
 * Version: 2.9.0
 *
 * Adds visual/UX helpers only.
 * STORZ builder logic, drag/drop data handling, AJAX preview and export/import stay in existing files.
 */
(function () {
  'use strict';

  function qs(selector, root) {
    return (root || document).querySelector(selector);
  }

  function qsa(selector, root) {
    return Array.prototype.slice.call((root || document).querySelectorAll(selector));
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.documentElement.classList.add('storz-formcraft-ui-ready');

    // Add helpful classes to existing STORZ builder screens without changing markup logic.
    qsa('.wrap, .storz-admin, .storz-builder, .storz-form-builder').forEach(function (el) {
      var text = (el.className || '') + ' ' + (document.body.className || '');
      if (/storz/i.test(text)) {
        el.classList.add('storz-formcraft-admin-skin');
      }
    });

    // Add drag labels/affordance to draggable builder rows where possible.
    qsa('.storz-field-item, [data-field-id], .field-item').forEach(function (field) {
      if (!field.querySelector('.storz-drag-handle')) {
        var handle = document.createElement('span');
        handle.className = 'storz-drag-handle';
        handle.setAttribute('aria-hidden', 'true');
        handle.textContent = '⋮⋮';
        handle.style.marginInlineEnd = '8px';
        handle.style.fontWeight = '800';
        if (field.firstChild) {
          field.insertBefore(handle, field.firstChild);
        } else {
          field.appendChild(handle);
        }
      }
    });

    // Better frontend form submission feedback without interfering with submit handlers.
    qsa('.storz-form form, form[class*="storz"]').forEach(function (form) {
      form.addEventListener('submit', function () {
        var btn = qs('button[type="submit"], input[type="submit"]', form);
        if (!btn) return;

        btn.classList.add('is-loading');
        btn.setAttribute('aria-busy', 'true');

        // Do not permanently lock the button; existing AJAX validation may need retry.
        setTimeout(function () {
          btn.classList.remove('is-loading');
          btn.removeAttribute('aria-busy');
        }, 3500);
      });
    });

    // Smooth-scroll for homepage anchor links.
    qsa('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (event) {
        var target = qs(link.getAttribute('href'));
        if (!target) return;
        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  });
})();



// Header search toggle for the fixed frontend header.
document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.querySelector('.storz-search-toggle');
  var search = document.querySelector('#storz-header-search');

  if (!toggle || !search) return;

  toggle.addEventListener('click', function () {
    var isOpen = search.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    var input = search.querySelector('input[type="search"]');
    if (isOpen && input) input.focus();
  });
});



// STORZ dark/light toggle. Default is dark; user choice is saved locally.
document.addEventListener('DOMContentLoaded', function () {
  var root = document.documentElement;
  var toggle = document.querySelector('.storz-theme-toggle');
  var icon = document.querySelector('.storz-theme-toggle-icon');
  var saved = localStorage.getItem('storzColorMode');

  function applyMode(mode) {
    if (mode === 'light') {
      root.classList.add('storz-light-mode');
      if (icon) icon.textContent = '☀';
    } else {
      root.classList.remove('storz-light-mode');
      if (icon) icon.textContent = '☾';
    }
  }

  applyMode(saved || 'dark');

  if (!toggle) return;

  toggle.addEventListener('click', function () {
    var next = root.classList.contains('storz-light-mode') ? 'dark' : 'light';
    localStorage.setItem('storzColorMode', next);
    applyMode(next);
  });
});
