jQuery(function ($) {
  const fieldsWrap = $('#storz-fields');
  const hiddenInput = $('#fields_json');
  const previewWrap = $('#storz-live-preview');
  let fields = [];
  let previewTimer = null;

  function esc(value) {
    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function normalizeFields(list) {
    if (!Array.isArray(list)) {
      return [];
    }

    return list.map((field) => ({
      label: field && field.label ? field.label : '',
      name: field && field.name ? field.name : '',
      type: field && field.type ? field.type : 'text',
      data_source: field && field.data_source ? field.data_source : 'manual',
      options: Array.isArray(field && field.options) ? field.options : [],
      step: field && field.step ? parseInt(field.step, 10) : 1
    }));
  }

  function loadInitialFields() {
    const raw = hiddenInput.val();
    if (!raw) {
      fields = [];
      return;
    }

    try {
      fields = normalizeFields(JSON.parse(raw));
    } catch (e) {
      fields = [];
    }
  }

  function render() {
    fieldsWrap.html('');

    fields.forEach((field, index) => {
      const html = `
        <div class="storz-field-card" data-index="${index}">
          <p>
            <input type="text" class="storz-label" placeholder="Label" value="${esc(field.label)}">
            <input type="text" class="storz-name" placeholder="Name" value="${esc(field.name)}">
          </p>
          <p>
            <select class="storz-type">
              <option value="text" ${field.type === 'text' ? 'selected' : ''}>Text</option>
              <option value="email" ${field.type === 'email' ? 'selected' : ''}>Email</option>
              <option value="number" ${field.type === 'number' ? 'selected' : ''}>Number</option>
              <option value="date" ${field.type === 'date' ? 'selected' : ''}>Date</option>
              <option value="tel" ${field.type === 'tel' ? 'selected' : ''}>Tel</option>
              <option value="password" ${field.type === 'password' ? 'selected' : ''}>Password</option>
              <option value="textarea" ${field.type === 'textarea' ? 'selected' : ''}>Textarea</option>
              <option value="select" ${field.type === 'select' ? 'selected' : ''}>Select</option>
              <option value="radio" ${field.type === 'radio' ? 'selected' : ''}>Radio</option>
              <option value="checkbox" ${field.type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
            </select>
            <select class="storz-data-source">
              <option value="manual" ${field.data_source === 'manual' ? 'selected' : ''}>Manual Options</option>
              <option value="countries" ${field.data_source === 'countries' ? 'selected' : ''}>Countries</option>
              <option value="user_roles" ${field.data_source === 'user_roles' ? 'selected' : ''}>User Roles</option>
              <option value="pages" ${field.data_source === 'pages' ? 'selected' : ''}>Pages</option>
              <option value="posts" ${field.data_source === 'posts' ? 'selected' : ''}>Posts</option>
              <option value="categories" ${field.data_source === 'categories' ? 'selected' : ''}>Categories</option>
              <option value="products" ${field.data_source === 'products' ? 'selected' : ''}>WooCommerce Products</option>
              <option value="product_categories" ${field.data_source === 'product_categories' ? 'selected' : ''}>WooCommerce Categories</option>
            </select>
          </p>
          <p>
            <input type="number" min="1" class="storz-step" placeholder="Step" value="${esc(field.step || 1)}">
          </p>
          <p>
            <textarea class="storz-options" placeholder="One option per line">${esc((field.options || []).join('\n'))}</textarea>
          </p>
          <p>
            <button type="button" class="button storz-remove-field">Remove</button>
          </p>
        </div>
      `;
      fieldsWrap.append(html);
    });

    hiddenInput.val(JSON.stringify(fields));
    queuePreview();
  }

  $('#storz-add-field').on('click', function () {
    fields.push({ label: '', name: '', type: 'text', data_source: 'manual', options: [], step: 1 });
    render();
  });

  fieldsWrap.on('input change', '.storz-label, .storz-name, .storz-type, .storz-data-source, .storz-options, .storz-step', function () {
    const card = $(this).closest('.storz-field-card');
    const index = parseInt(card.data('index'), 10);

    fields[index].label = card.find('.storz-label').val();
    fields[index].name = card.find('.storz-name').val();
    fields[index].type = card.find('.storz-type').val();
    fields[index].data_source = card.find('.storz-data-source').val();
    fields[index].step = parseInt(card.find('.storz-step').val(), 10) || 1;
    fields[index].options = card.find('.storz-options').val().split('\n').map(v => v.trim()).filter(Boolean);

    hiddenInput.val(JSON.stringify(fields));
    queuePreview();
  });

  fieldsWrap.on('click', '.storz-remove-field', function () {
    const index = parseInt($(this).closest('.storz-field-card').data('index'), 10);
    fields.splice(index, 1);
    render();
  });

  /**
   * Request an AJAX preview from WordPress.
   * The preview uses the same PHP renderer as the public shortcode.
   */
  function refreshPreview() {
    if (!previewWrap.length || typeof STORZ_FORM_BUILDER === 'undefined') {
      return;
    }

    previewWrap.addClass('is-loading').html('<p>Loading preview...</p>');

    $.post(STORZ_FORM_BUILDER.ajaxUrl, {
      action: 'storz_form_preview',
      nonce: STORZ_FORM_BUILDER.previewNonce,
      form_name: $('#form_name').val(),
      fields_json: hiddenInput.val(),
      theme: $('#form_theme').val(),
      ajax: $('#form_ajax').is(':checked') ? 1 : 0,
      custom_css: $('#form_custom_css').val()
    }).done(function (response) {
      if (response && response.success && response.data && response.data.html) {
        previewWrap.html(response.data.html);
      } else {
        previewWrap.html('<p>Preview failed.</p>');
      }
    }).fail(function () {
      previewWrap.html('<p>Preview request failed.</p>');
    }).always(function () {
      previewWrap.removeClass('is-loading');
    });
  }

  /**
   * Debounce preview updates so typing CSS does not spam admin-ajax.php.
   */
  function queuePreview() {
    if (!previewWrap.length) {
      return;
    }
    window.clearTimeout(previewTimer);
    previewTimer = window.setTimeout(refreshPreview, 350);
  }

  $('#storz-refresh-preview').on('click', refreshPreview);
  $('#form_name, #form_theme, #form_ajax, #form_custom_css').on('input change', queuePreview);

  loadInitialFields();
  render();
  refreshPreview();
});
