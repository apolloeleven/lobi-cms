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

  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  // config.removeButtons = 'Subscript,Superscript';

  // Set the most common block elements.
  config.format_tags = 'p;h1;h2;h3;pre;picture';

  // Simplify the dialog windows.
  config.removeDialogTabs = 'image:advanced;link:advanced';
  config.removeFormatTags = 'picture';

  config.bodyClass = 'xmlblock';
  config.removeButtons = 'Underline';
  // setTimeout(function () {
  //   $('.cke_contents').css('height', '300px');
  // }, 1000);

  // If contentsCss is not an array, we make it array
  if (typeof config.contentsCss !== 'object') {
    if (config.contentsCss){
      config.contentsCss = [config.contentsCss]
    }
  }

  config.contentsCss.push(FRONTEND_HOST+'/bundle/ckeditor.css');
  // If customConfig is not an array, we make it array
  if (typeof config.customConfig !== 'object') {
    if (config.customConfig){
      config.customConfig = [config.customConfig];
    }
  }

  // bootstrapBuilder config
  config.extraPlugins = 'justify,bootstrapBuilder,youtube,lobiUploader,blockquote';
  config.removePlugins = 'image,imageresponsive';

  config.contentsCss.push('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
  config.mj_variables_bootstrap_css_path = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
  config.mj_variables_bootstrap_js_path = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
  config.allowedContent = true;
  config.bootstrapBuilder_container_large_desktop = 1170;
  config.bootstrapBuilder_container_desktop = 970;
  config.bootstrapBuilder_container_tablet = 750;
  config.bootstrapBuilder_grid_columns = 12;
  config.bootstrapBuilder_ckfinder_version = 3;
  config.bootstrapBuilder_ckfinder_path = '/ckeditor/ckfinder3/ckfinder.js';
  config.filebrowserBrowseUrl = '/file/manager/ckeditor';
  config.filebrowserBrowseImageUrl = '/file/manager/ckeditor?filter=image';
  config.pictureTagImageCount = 8;
  config.image_prefillDimensions = false;
})();
