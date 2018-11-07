/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
//setTimeout(function () {
(function () {
  CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

    // The toolbar groups arrangement, optimized for two toolbar rows.


    config.toolbarGroups = [
      {name: 'clipboard', groups: ['clipboard', 'undo']},
      {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
      {name: 'links'},
      {name: 'insert'},
      {name: 'forms'},
      {name: 'tools'},
      {name: 'document', groups: ['mode', 'document', 'doctools']},
      {name: 'others'},
      '/',
      {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
      {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
      {name: 'styles'},
      {name: 'colors'},
      {name: 'about'}
    ];

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Subscript,Superscript';

    // Set the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';

    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';
  };
})();


(function () {
  var choosenEditor = {};
  var pathHtml = '';
  CKEDITOR.plugins.add('link-tree', {
    init: function (editor) {
      editor.addCommand('showModal', {
        exec: function (editor) {
          LinkedTreeCommand(editor)
        }
      });
      editor.addCommand('linkTree', {
        exec: function (editor) {
          var now = new Date();
          editor.insertHtml(pathHtml);
        }
      });

      editor.ui.addButton('showModal', {
        label: 'Link Tree',
        command: 'showModal',
        toolbar: 'insert',
        icon: '/img/link.png',
      });
    }
  });

  CKEDITOR.config.extraPlugins = 'link-tree';
  CKEDITOR.config.allowedContent = true;

  var $linkModal = $('#link-plugin-modal');
  var $linkButton = $('#link-plugin-button');
  var $jsTree = $("#jstree-link-plugin");

  function LinkedTreeCommand(editor) {
    choosenEditor = editor;
    $linkModal.modal('show');
  }

  $linkModal.on('shown.bs.modal', function () {
    $.ajax({
      url: '/base/tree-for-move',
      type: "POST",
      data: {
        key: parseInt($('#tree-modal-body').attr('data-key')),
      },
      success: function (res) {
        initTreeMove(res);
      }
    });
  });

  $linkButton.click(function () {
    var prependTo = [];
    var path = '';
    var text = choosenEditor.getSelection().getSelectedText();
    $jsTree.jstree("get_checked", this, true).forEach(function (data) {
      path = data.original.path;
      if (!text.length > 0){
        text = data.original.text;
      }
    });



    pathHtml = '<a href="/' + path + '">' + text + '</a>';
    choosenEditor.execCommand('linkTree');
    $linkModal.modal('hide');
  });

  function initTreeMove(res) {
    $jsTree.jstree({
      plugins: ['checkbox', 'rules', 'types', 'wholerow'],
      checkbox: {
        "three_state": false,
      },
      core: {
        multiple: false,
        data: JSON.parse(res)
      },
      types: {
        "website": {icon: "fa fa-globe"},
        "page": {icon: "fa fa-file-powerpoint-o"},
        "video_section": {icon: "fa fa-file-video-o"},
        "content_text": {icon: "fa fa-file-text"},
        "teaser": {icon: "fa fa-file-text"},
        "section": {icon: "fa fa-folder-open-o"},
        "service": {icon: "fa fa-wrench"},
        "pharmaceutical_form": {icon: "fa fa-medkit"},
      }
    });
  }
})();

