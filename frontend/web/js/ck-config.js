/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

(function () {
  const config = CKEDITOR.config;
  config.extraAllowedContent = 'div(*);picture';

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
    {name: 'about'},
    {name: 'insert', items: ['BootstrapBuilder', 'Source']}
  ];

  config.inlainsave = {
    postUrl: '/myurl',
    postData: {test: true},
    onSave: function (editor) {
      console.log('clicked save', editor);
      return true;
    },
    onSuccess: function (editor, data) {
      console.log('save successful', editor, data);
    },
    onFailure: function (editor, status, request) {
      console.log('save failed', editor, status, request);
    },
    successMessage: 'Yay we saved it!',
    errorMessage: 'Something went wrong :(',
    useJSON: false,
    useColorIcon: false
  };
  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  // config.removeButtons = 'Subscript,Superscript';
  config.extraPlugins = 'justify,bootstrapBuilder,youtube,lobiUploader,blockquote';
  // Set the most common block elements.
  config.format_tags = 'p;h1;h2;h3;pre';

  // Simplify the dialog windows.
  config.removeDialogTabs = 'image:advanced;link:advanced';

})();
