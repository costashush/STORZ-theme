<?php
/**
 * STORZ Front Page
 *
 * FormCraft-inspired homepage UI merged into STORZ.
 * Keeps STORZ form builder, drag/drop, AJAX preview, presets, export/import and submissions logic.
 */

get_header();

$create_form_url = admin_url('admin.php?page=storz-add-form');
$forms_url       = admin_url('admin.php?page=storz-forms');
$options_url     = admin_url('admin.php?page=storz');
?>

<main class="storz-fc-home">
    <section class="storz-fc-hero">
        <div class="storz-fc-container">
            <div class="storz-fc-badge">⚡ STORZ v2.9 · FormCraft UI</div>

            <h1>
                Build <span>beautiful forms</span><br>
                with STORZ
            </h1>

            <p class="storz-fc-lead">
                A modern WordPress theme with a visual form builder, drag-and-drop fields,
                live AJAX preview, custom CSS per form, presets, export/import and blank pages.
            </p>

            
<button class="storz-theme-toggle front-toggle" type="button">
    <span class="storz-theme-toggle-icon">☾</span>
</button>

<div class="storz-fc-actions">
                <a class="storz-fc-btn storz-fc-btn-primary" href="<?php echo esc_url($create_form_url); ?>">
                    ✚ Create Form
                </a>
                <a class="storz-fc-btn storz-fc-btn-secondary" href="<?php echo esc_url($forms_url); ?>">
                    Manage Forms →
                </a>
                <a class="storz-fc-btn storz-fc-btn-secondary" href="#storz-features">
                    View Features
                </a>
            </div>
        </div>
    </section>

    <section id="storz-features" class="storz-fc-section">
        <div class="storz-fc-container">
            <h2>Everything your form workflow needs</h2>
            <p class="storz-fc-section-intro">
                The UI is upgraded, but the existing STORZ features stay in place.
                This merge is visual-first and safe for your current builder logic.
            </p>

            <div class="storz-fc-grid">
                <article class="storz-fc-card">
                    <div class="storz-fc-icon">🎯</div>
                    <h3>Drag & Drop Builder</h3>
                    <p>Arrange form fields visually and keep the existing STORZ builder behavior.</p>
                </article>

                <article class="storz-fc-card">
                    <div class="storz-fc-icon">🎨</div>
                    <h3>Custom CSS Per Form</h3>
                    <p>Add scoped styling for each form directly inside the builder.</p>
                </article>

                <article class="storz-fc-card">
                    <div class="storz-fc-icon">⚡</div>
                    <h3>Live AJAX Preview</h3>
                    <p>Preview form changes instantly without leaving the builder screen.</p>
                </article>

                <article class="storz-fc-card">
                    <div class="storz-fc-icon">🧩</div>
                    <h3>Form Presets</h3>
                    <p>Use clean visual presets as a starting point for different business cases.</p>
                </article>

                <article class="storz-fc-card">
                    <div class="storz-fc-icon">📦</div>
                    <h3>Export / Import</h3>
                    <p>Move forms between sites using JSON exports and imports.</p>
                </article>

                <article class="storz-fc-card">
                    <div class="storz-fc-icon">📄</div>
                    <h3>Blank Pages</h3>
                    <p>Create focused landing pages without header or footer using the blank template.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="storz-fc-section storz-fc-demo">
        <div class="storz-fc-container">
            <div class="storz-fc-demo-wrap">
                <div class="storz-fc-demo-copy">
                    <h2>Ready for real business pages</h2>
                    <p>
                        Use this homepage as a polished landing page for your theme.
                        The cards, buttons, forms, and builder now share the same visual language.
                    </p>
                    <div class="storz-fc-actions" style="justify-content:flex-start;">
                        <a class="storz-fc-btn storz-fc-btn-primary" href="<?php echo esc_url($options_url); ?>">
                            Open STORZ Settings
                        </a>
                    </div>
                </div>

                <div class="storz-fc-form-shell">
                    <div class="storz-fc-card">
                        <div class="storz-fc-icon">📝</div>
                        <h3>Embed any STORZ form</h3>
                        <p>
                            Add your form shortcode here or use the builder to create a landing-page form.
                        </p>
                        <p style="margin-top:14px;">
                            <code style="background:rgba(15,23,42,.72);color:#dbeafe;padding:4px 8px;border-radius:8px;">[storz_form id="1"]</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
