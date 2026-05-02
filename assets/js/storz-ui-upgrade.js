
/**
 * STORZ Theme UI Upgrade JS
 * Version: 2.9.0
 *
 * Lightweight UX helpers only.
 * Does not change form data structure or submission logic.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        // Add a ready class for CSS hooks and visual transitions.
        document.documentElement.classList.add('storz-ui-ready');

        // Improve admin builder panels when the markup uses generic STORZ class names.
        var builder = document.querySelector('.storz-builder, .storz-form-builder, .storz-admin');
        if (builder && !builder.classList.contains('storz-builder-enhanced')) {
            builder.classList.add('storz-builder-enhanced');
        }

        // Give frontend STORZ forms a safe class if they are detected by class name.
        document.querySelectorAll('form[class*="storz"]').forEach(function (form) {
            form.classList.add('storz-form-enhanced');
        });

        // Small UX: disable submit button shortly after submit to reduce double submissions.
        document.querySelectorAll('.storz-form form, form[class*="storz"]').forEach(function (form) {
            form.addEventListener('submit', function () {
                var btn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (btn) {
                    setTimeout(function () {
                        btn.disabled = true;
                        btn.classList.add('is-loading');
                    }, 20);
                }
            });
        });
    });
})();
