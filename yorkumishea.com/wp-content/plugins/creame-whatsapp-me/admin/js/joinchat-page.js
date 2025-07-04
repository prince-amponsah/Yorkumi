(function ($, window, document) {
  'use strict';

  function textarea_autoheight() {
    $(this).height(0).height(this.scrollHeight);
  }

  // View Joinchat_Util::clean_whatsapp() for regex clean info
  function phone_to_whatsapp(phone) {
    return phone.replace(/^0+|\D/, '')
      .replace(/^54(0|1|2|3|4|5|6|7|8)/, '549$1')
      .replace(/^(54\d{5})15(\d{6})/, '$1$2')
      .replace(/^52(0|2|3|4|5|6|7|8|9)/, '521$1');
  }

  function debounce(callback, wait) {
    let timeoutId = null;
    return (...args) => {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(() => callback.apply(null, args), wait);
    };
  }

  $(function () {
    var media_frame;
    var has_iti = typeof intlTelInput === 'function' && intl_tel_l10n;
    var $phone = $('#joinchat_phone');

    if (has_iti) {
      // Set intlTelInput config (make global)
      var country_request = JSON.parse(localStorage.joinchat_country_code || '{}');
      var country_code = (country_request.code && country_request.date == new Date().toDateString()) ? country_request.code : false;

      window.joinchat_intl_tel_config = {
        hiddenInput: () => ({ phone: $phone.data('name') || 'joinchat[telephone]' }),
        strictMode: true,
        separateDialCode: true,
        initialCountry: country_code || 'auto',
        geoIpLookup: country_code ? null : (success, failure) => {
          fetch("https://ipapi.co/json")
            .then((res) => res.json())
            .then((data) => {
              localStorage.joinchat_country_code = JSON.stringify({ code: data.country_code, date: new Date().toDateString() });
              success(data.country_code);
            }).catch(() => failure());
        },
        customPlaceholder: (country_ph) => `${intl_tel_l10n.placeholder} ${country_ph}`,
        i18n: intl_tel_l10n,
      };

      // Apply intlTelInput to phone input
      if ($phone.length) {
        var iti = intlTelInput($phone[0], joinchat_intl_tel_config);
        iti.promise.then(() => { $phone.trigger('input'); });

        $phone.on('input countrychange', function () {
          var is_valid = iti.isValidNumber(true); // check for mobile

          $(this).css('color', this.value.trim() && !is_valid ? '#ca4a1f' : '');
          // Ensures number it's updated
          iti.hiddenInput.value = iti.getNumber();
          // Enable/disable phone test
          $('#joinchat_phone_test').attr('disabled', !is_valid);
        });
      }
    }

    // Tabs
    $('.nav-tab').on('click', function (e) {
      e.preventDefault();
      var $navtab = $(this);
      var href = $navtab.attr('href');
      var $referer = $('input[name=_wp_http_referer]');
      var ref_val = $referer.val();

      // Update form referer to open same tab on submit
      $referer.val(ref_val.substr(0, ref_val.indexOf('page=joinchat')) + 'page=joinchat&tab=' + href.substr(14));

      $('.nav-tab').removeClass('nav-tab-active').attr('aria-selected', 'false');
      $navtab.addClass('nav-tab-active').attr('aria-selected', 'true').get(0).blur();
      $('.joinchat-tab').removeClass('joinchat-tab-active');
      $(href).addClass('joinchat-tab-active');
      // Trigger event
      $(document).trigger('navtabchange', [$(href), href]);
    });

    $(document).on('navtabchange', function (e, $tab) { $tab.find('textarea').each(textarea_autoheight); });

    // Test phone number
    if ($phone.length) {
      // Enable/disable phone test
      if (!has_iti) {
        $phone.on('input change', function () {
          $('#joinchat_phone_test').attr('disabled', this.value.length < 7);
        });
      }

      $('#joinchat_phone_test').on('click', function () {
        var phone = has_iti ? intlTelInput.getInstance($phone[0]).getNumber() : $phone.val();
        window.open('https://wa.me/' + encodeURIComponent(phone_to_whatsapp(phone)), 'joinchat', 'noopener');
      });
    }

    // Toggle WhatsApp web option
    $('#joinchat_mobile_only').on('change', function () {
      $('#joinchat_whatsapp_web').closest('tr').toggleClass('joinchat-dimmed', this.checked);
    }).trigger('change');

    $('input[name="joinchat[header]"]').on('change', function () {
      $('#joinchat_header_custom').toggleClass('joinchat-dimmed', this.value != '__custom__');
    }).trigger('change');

    // Toggle cookies notice
    $('#joinchat_message_delay_on').on('change', function () {
      $('#joinchat_message_delay, #joinchat_message_views, #joinchat_message_badge').parent().toggleClass('joinchat-dimmed', !this.checked);
      $('.joinchat-cookies-notice').toggleClass('joinchat-hidden', !this.checked);
    }).trigger('change');

    // Show help
    $('.joinchat-show-help').on('click', function (e) {
      e.preventDefault();
      var help_tab = $(this).attr('href');
      if ($('#contextual-help-wrap').is(':visible')) {
        $("html, body").animate({ scrollTop: 0 });
      } else {
        $('#contextual-help-link').trigger('click');
      }
      $(help_tab != '#' ? help_tab : '#tab-link-styles-and-vars').find('a').trigger('click');
    });

    // Texarea focus and auto height
    $('textarea', '#joinchat_form')
      .on('focus', function () { $(this).closest('tr').addClass('joinchat--focus'); })
      .on('blur', function () { $(this).closest('tr').removeClass('joinchat--focus'); })
      .on('input', textarea_autoheight)
      .each(textarea_autoheight);

    // Show title when placeholder
    $('#joinchat_form').find('.autofill')
      .on('change', function () { this.title = this.value == '' ? joinchat_admin.example : ''; })
      .on('dblclick', function () { if (this.value == '') { this.value = this.placeholder; this.title = ''; $(this).trigger('change'); } })
      .trigger('change');

    // Visibility view inheritance
    var $tab_visibility = $('#joinchat_tab_visibility');
    var inheritance = $('.joinchat_view_all').data('inheritance') || {
      'all': ['front_page', 'blog_page', '404_page', 'search', 'archive', 'singular', 'cpts'],
      'archive': ['date', 'author'],
      'singular': ['page', 'post'],
    };

    function propagate_inheritance(field, show) {
      field = field || 'all';
      show = show || $('input[name="joinchat[view][' + field + ']"]:checked').val();

      $('.view_inheritance_' + field)
        .toggleClass('dashicons-visibility', show == 'yes')
        .toggleClass('dashicons-hidden', show == 'no');

      if (field == 'cpts') {
        $('[class*=view_inheritance_cpt_]')
          .toggleClass('dashicons-visibility', show == 'yes')
          .toggleClass('dashicons-hidden', show == 'no');
      } else if (field in inheritance) {
        var value = $('input[name="joinchat[view][' + field + ']"]:checked').val();
        value = value === '' ? show : value;

        $.each(inheritance[field], function () { propagate_inheritance(this, value); });
      }
    }

    $('input', $tab_visibility).on('change', function () { propagate_inheritance(); });

    $('.joinchat_view_reset').on('click', function (e) {
      e.preventDefault();
      $('input[value=""]', $tab_visibility).prop('checked', true);
      $('.joinchat_view_all input', $tab_visibility).first().prop('checked', true);
      propagate_inheritance();
    });

    propagate_inheritance();

    // Button image
    $('#joinchat_button_image_add').on('click', function (e) {
      e.preventDefault();

      if (!media_frame) {
        // Define media_frame as wp.media object
        media_frame = wp.media({
          title: $(this).data('title') || 'Select button image',
          button: { text: $(this).data('button') || 'Use Image' },
          library: { type: 'image,video' },
          multiple: false,
        });

        // When an image is selected in the media library...
        media_frame.on('select', function () {
          // Get media attachment details from the frame state
          var attachment = media_frame.state().get('selection').first().toJSON();
          var url = attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url || attachment.url;
          var tag = attachment.type == 'video' ? '<video autoplay loop muted playsinline src="' + url + '"></video>' : '<img src="' + url + '">';

          $('#joinchat_button_image_holder').html(tag);
          $('#joinchat_button_image').val(attachment.id);
          $('#joinchat_button_image_wrapper').removeClass('no-image');
          if (prev_jc) {
            prev_jc.chatbox_hide();
            prev_jc.$('.joinchat__button__image').innerHTML = tag;
          }
        });

        media_frame.on('open', function () {
          // Pre-selected attachment
          var attachment = wp.media.attachment($('#joinchat_button_image').val());
          media_frame.state().get('selection').add(attachment ? [attachment] : []);
        });
      }

      media_frame.open();
    });

    $('#joinchat_button_image_remove').on('click', function (e) {
      e.preventDefault();

      $('#joinchat_button_image_holder').empty();
      $('#joinchat_button_image').val('');
      $('#joinchat_button_image_wrapper').addClass('no-image');
      if (prev_jc) prev_jc.$('.joinchat__button__image').replaceChildren();
    });

    // Init ColorPicker with "changecolor" trigger event on change
    $('#joinchat_color').wpColorPicker({ change: function (e, ui) { $(this).trigger('changecolor', [ui.color.toHsl()]); } });
    $('#joinchat_color').on('changecolor', function (e, hsl) {
      var style = $('#joinchat_form').get(0).style;
      style.setProperty('--ch', hsl.h);
      style.setProperty('--cs', `${hsl.s}%`);
      style.setProperty('--cl', `${hsl.l}%`);
    });

    $('input[name="joinchat[color][text]"]').on('change', function () {
      $('#joinchat_form').get(0).style.setProperty('--bw', this.value);
    });

    $('#joinchat_header_custom').on('click', function () { $(this).prev().find('input').trigger('click'); });

    // Focus Opt-in editor
    $('label[for="joinchat_optin_text"]').on('click', function () { tinymce.get('joinchat_optin_text').focus(); });

    // Toggle Woo Product Button text
    $('#joinchat_woo_btn_position').on('change', function () {
      $('#joinchat_woo_btn_text').closest('tr').toggleClass('joinchat-hidden', $(this).val() == 'none');
    }).trigger('change');

    // Custom CSS
    var custom_css_editor = wp.codeEditor.initialize($('#joinchat_custom_css'), custom_css_settings);
    $(document).on('navtabchange', function (e, $tab, id) { if (id == '#joinchat_tab_advanced') custom_css_editor.codemirror.refresh(); });
    $('label[for="joinchat_custom_css"]').on('click', function () { custom_css_editor.codemirror.focus(); });
    $('.joinchat_custom_css_prefill').on('click', function (e) { e.preventDefault(); custom_css_editor.codemirror.setValue(joinchat_admin.example_css); });


    /*************************************
     * MARK: Preview Sync
     *************************************/

    $(document).on('navtabchange', function (e, $tab, id) {
      if (id == '#joinchat_tab_general' || id == '#joinchat_tab_advanced') {
        $('#joinchat_preview_show').removeClass('disabled');
      } else {
        $('body').removeClass('jcpreview');
        $('#joinchat_preview_show').addClass('disabled').removeClass('active');
      }
    });

    var prev_jc = null; // joinchat_obj of preview iframe
    var chatbox_on = true;

    function prev_width(width) {
      if (width === undefined) return parseInt(getComputedStyle(document.documentElement).getPropertyValue('--preview-width'));
      else {
        var w = Math.min(Math.max(width, 360), 680);
        document.documentElement.style.setProperty('--preview-width', `${w}px`);
        $('#joinchatprev__devices .desktop').toggleClass('active', w > 480);
        $('#joinchatprev__devices .mobile').toggleClass('active', w <= 480);
      }
    }
    function update_has_chatbox() {
      prev_jc.has_chatbox = prev_jc.has_cta || prev_jc.has_optin;
      prev_jc.$div.classList.toggle('joinchat--btn', !prev_jc.has_chatbox);
    }
    function view_chatbox() {
      chatbox_on && prev_jc.has_chatbox ? prev_jc.chatbox_show() : prev_jc.chatbox_hide();
    }

    $('#joinchat_preview_show').on('click', function (e) {
      e.preventDefault();
      if ($(this).hasClass('disabled')) return;

      var is_off = $(this).hasClass('active');
      $(this).toggleClass('active', !is_off);
      $('body').toggleClass('jcpreview', !is_off);

      if (!is_off && $('#joinchatprev').length == 0) {
        // Add preview
        $('#wpwrap').append(`
          <div id="joinchatprev">
            <div id="joinchatprev__resize"></div>
            <div id="joinchatprev__devices">
              <div class="button-group">
                <button class="button desktop" title="Desktop"><span class="dashicons dashicons-desktop"></span></button>
                <button class="button active mobile" title="Mobile"><span class="dashicons dashicons-smartphone"></span></button>
              </div>
            </div>
            <iframe id="joinchat_preview" src="${joinchat_admin.home}?joinchat-preview=1" scrolling="no"></iframe>
          </div>`);

        $('#joinchat_preview').on('load', function () {
          prev_jc = this.contentWindow.joinchat_obj;
          prev_jc.has_cta = $('#joinchat_message_text').val().trim() != '';
          prev_jc.has_optin = tinymce.get('joinchat_optin_text').getContent() != '';
          $(document).trigger('preview', [this, prev_jc]); // Trigger preview ready!
        });

        // Toggle devices
        $('#joinchatprev__devices .desktop').on('click', function () { if (prev_width() <= 480) prev_width(500); });
        $('#joinchatprev__devices .mobile').on('click', function () { if (prev_width() > 480) prev_width(380); });

        // Resizable preview
        var start_x, start_w, is_rtl = $('[dir=rtl]').length > 0 ? -1 : 1;
        $('#joinchatprev__resize').on('mousedown', start_resize);

        function start_resize(e) {
          e.preventDefault();
          start_x = e.clientX;
          start_w = prev_width();

          $('body')
            .addClass('jcpreview-resize')
            .on('mousemove mouseup', do_resize)
            .on('mouseup mouseleave', end_resize);
        }
        function do_resize(e) {
          e.preventDefault();
          prev_width(start_w + (start_x - e.clientX) * is_rtl);
        }
        function end_resize(e) {
          e.preventDefault();
          $('body')
            .removeClass('jcpreview-resize')
            .off('mousemove mouseup', do_resize)
            .off('mouseup mouseleave', end_resize);
        }
      }
    });

    $(document).on('preview', function () {
      update_has_chatbox();

      // Contact
      $phone.on('change', function () {
        prev_jc.settings.telephone = phone_to_whatsapp(has_iti ? intlTelInput.getInstance(this).getNumber() : $(this).val());
        prev_jc.$div.classList.toggle('joinchat--disabled', prev_jc.settings.telephone == '');
      });
      $('#joinchat_message_send').on('change', function () { prev_jc.settings.message_send = $(this).val(); });

      // Button
      $('#joinchat_mobile_only').on('change', function () { prev_jc.$div.classList.toggle('joinchat--mobile_only', this.checked); });
      $('#joinchat_button_tip')
        .on('focus blur', e => {
          if (e.type == 'focus') prev_jc.chatbox_hide();
          prev_jc.$('.joinchat__tooltip').classList.toggle('joinchat--show', e.type == 'focus');
        })
        .on('input change', debounce(e => {
          prev_jc.$('.joinchat__tooltip').classList.toggle('joinchat--hidden', $(e.target).val().trim() == '');
          prev_jc.$('.joinchat__tooltip div').textContent = $(e.target).val();
        }, 100));
      $('input[name="joinchat[position]"]').on('change', function () {
        prev_jc.$div.classList.toggle('joinchat--right', this.value == 'right');
        prev_jc.$div.classList.toggle('joinchat--left', this.value == 'left');
      });

      // Fixed image
      $('input[name="joinchat[button_image_fixed]"]').on('change', function () {
        prev_jc.chatbox_hide();
        prev_jc.$div.classList.toggle('joinchat--img', this.value == 'yes');
      });

      // QR
      var qr_show_timeout;
      $('#joinchat_qr').on('change', function () {
        clearTimeout(qr_show_timeout);
        if ($('#joinchat_mobile_only')[0].checked) return;

        if (this.checked) {
          prev_jc.$('.joinchat__qr canvas')?.remove();
          prev_jc.$('.joinchat__qr').appendChild(prev_jc.qr(prev_jc.get_wa_link(undefined, undefined, false)));
        }
        if (chatbox_on && this.checked && prev_width() <= 480) prev_width(481);
        if (chatbox_on && this.checked && prev_jc.has_chatbox) prev_jc.chatbox_show();
        if (chatbox_on) {
          prev_jc.$('.joinchat__qr').classList.toggle('joinchat--show', this.checked);
          qr_show_timeout = setTimeout(function () { prev_jc.$('.joinchat__qr').classList.remove('joinchat--show'); }, 5000);
        }
      });

      // Chatbox show (if available)
      $('#joinchat_message_text,#joinchat_message_start,input[name="joinchat[color][text]"],input[name="joinchat[dark_mode]"],input[name="joinchat[header]"],#joinchat_header_custom').on('focus', view_chatbox);

      function change_message_text(e) {
        prev_jc.has_cta = $(e.target).val().trim() != '';
        update_has_chatbox();
        prev_jc.update_cta($(e.target).val().trim());
        view_chatbox();
      }
      $('#joinchat_message_text').on('input', debounce(change_message_text, 500)).on('change', change_message_text);

      $('#joinchat_message_start').on('input change', debounce(e => {
        prev_jc.$('.joinchat__open__text').textContent = $(e.target).val().trim();
        view_chatbox();
      }, 100));
      $('input[name="joinchat[button_ico]"]').on('change', function () {
        prev_jc.$('.joinchat__button__ico')?.remove();
        if (this.value != 'app') prev_jc.$('.joinchat__button').insertAdjacentHTML('afterbegin', `<div class="joinchat__button__ico">${this.nextElementSibling.firstElementChild.outerHTML}</div>`);
        prev_jc.chatbox_hide();
      });
      $('#joinchat_color').on('changecolor', function (e, hsl) {
        var style = prev_jc.$div.style;
        style.setProperty('--ch', hsl.h);
        style.setProperty('--cs', `${hsl.s}%`);
        style.setProperty('--cl', `${hsl.l}%`);
        view_chatbox();
      });
      $('input[name="joinchat[color][text]"]').on('change', function () {
        prev_jc.$div.style.setProperty('--bw', this.value);
        view_chatbox();
      });
      $('input[name="joinchat[dark_mode]"]').on('change', function () {
        prev_jc.$div.classList.toggle('joinchat--dark', this.value == 'yes');
        prev_jc.$div.classList.toggle('joinchat--dark-auto', this.value == 'auto');
        view_chatbox();
      });
      $('input[name="joinchat[header]"]').on('change', function () {
        prev_jc.$('#joinchat__label a').classList.toggle('joinchat--hidden', this.value != '__jc__');
        prev_jc.$('#joinchat__label span').classList.toggle('joinchat--hidden', this.value != '__custom__');
        prev_jc.$('#joinchat__label .joinchat__wa').classList.toggle('joinchat--hidden', this.value != '__wa__');
        view_chatbox();
      });
      $('#joinchat_header_custom').on('input change', debounce(e => {
        prev_jc.$('#joinchat__label span').textContent = $(e.target).val();
        view_chatbox();
      }, 100));

      // Badge
      $('#joinchat_message_badge').on('change', function () {
        prev_jc.settings.message_badge = this.checked;
        if (!prev_jc.has_cta) return;

        this.checked ? prev_jc.chatbox_hide() : prev_jc.chatbox_show();
        prev_jc.$('.joinchat__badge').classList.toggle('joinchat__badge--in', this.checked);
      });

      // Optin
      tinymce.get('joinchat_optin_text').on('change', update_optin);
      $('#joinchat_optin_check').on('change', update_optin);

      // Custom CSS (strip tags)
      custom_css_editor.codemirror.on('change', function (ed) {
        $('#joinchat_preview')[0].contentDocument.getElementById('joinchat-inline-css').innerHTML = ed.getValue().replace(/(<([^>]+)>)/gi, "");
      });

      // Trigger change to force updated settings on preview
      chatbox_on = false;
      $('#joinchat_tab_general').find('input[type="text"],input[type="number"],input[type="checkbox"],input[type="radio"]:checked,textarea').trigger('change');
      $('#joinchat_color').wpColorPicker('color', $('#joinchat_color').val());
      var temp = custom_css_editor.codemirror.getValue();
      custom_css_editor.codemirror.setValue(temp + ' ');
      custom_css_editor.codemirror.setValue(temp);
      chatbox_on = true;
    });

    function update_optin() {
      var text = tinymce.get('joinchat_optin_text').getContent();
      var check = $('#joinchat_optin_check')[0].checked;
      prev_jc.has_optin = text != '';
      update_has_chatbox();
      prev_jc.$div.classList.toggle('joinchat--optout', text != '' && check);
      if (text == '') {
        prev_jc.$('.joinchat__optin').replaceChildren();
      } else {
        text = text.replaceAll('<p>', '').replaceAll('</p>', '<br><br>').replace(/<br><br>$/, '');
        text = check ? '<label for="joinchat_optin">' + text + '</label>' : '<span>' + text + '</span>';
        prev_jc.$('.joinchat__optin').innerHTML = '<input type="checkbox" id="joinchat_optin">' + text;
        prev_jc.$('#joinchat_optin').addEventListener('change', e => prev_jc.$div.classList.toggle('joinchat--optout', !e.target.checked));
      }
      view_chatbox();
    }

    $('.nav-tab-active').trigger('click');
  });
}(jQuery, window, document));
