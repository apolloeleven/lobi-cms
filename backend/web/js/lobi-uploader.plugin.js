//TODO change icon image path. Now it comes from backend web/img/ck-editor

CKEDITOR.plugins.add('lobiUploader', {
    icons: 'lobiUploader',
    init: function (editor) {
        editor.addCommand('lobiUploader', new CKEDITOR.dialogCommand('lobiUploaderDialog'));
        editor.ui.addButton('LobiUploader', {
            label: 'Choose file',
            command: 'lobiUploader',
            toolbar: 'insert',
            icon: '/img/ck-editor/icon-image.png'
        });
    }
});

CKEDITOR.dialog.add('lobiUploaderDialog', function (editor) {
    var previewImageId = CKEDITOR.tools.getNextId() + "_previewImage";

    return {
        title: 'Lobi Uploader',
        minWidth: 300,
        minHeight: 100,
        contents: [
            {
                id: 'main-tab',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'file',
                        id: 'fileUploadInput',
                        onChange: function (e) {
                            var maxsize = 1024000;
                            var filesSelected = this.getInputElement().$.files;

                            /* Read img only if selected file exists, it suits max size and its img type */
                            if (filesSelected.length > 0 && filesSelected[0].size < maxsize && filesSelected[0].type.match('image*')) {
                                var fileToLoad = filesSelected[0];
                                var fileReader = new FileReader();
                                fileReader.onload = function (fileLoadedEvent) {
                                    var image = new Image();
                                    image.src = fileLoadedEvent.target.result;
                                    e.sender.getDialog().getContentElement('main-tab', 'base64_placeholder').setValue(fileLoadedEvent.target.result);
                                    CKEDITOR.document.getById(previewImageId).setAttribute('src', fileLoadedEvent.target.result);
                                };
                                fileReader.readAsDataURL(fileToLoad);
                            }
                        }
                    },
                    {
                        type: 'html',
                        id: 'htmlPreview',
                        style: 'width:95%;',
                        html: '<div><img id="' + previewImageId + '" src="" style="width:200px!important; max-width:100%!important;max-height:100%!important;" /></div>'
                    },
                    {
                        id: 'base64_placeholder',
                        type: 'textarea',
                        hidden: true,
                        required: false
                    }
                ]
            }
        ],
        onShow: function () {
            /* Emptying previous preview image src */
            CKEDITOR.document.getById(previewImageId).setAttribute('src', '');
        },
        onOk: function () {
            var dialog = this;

            /* Retrieving img base64 and return it as HTML img element */
            var base64String = dialog.getValueOf('main-tab', 'base64_placeholder');
            editor.insertHtml('<img src="' + base64String + '">');
        }
    }
});

/* Following command was added due to content filtering reasons. Refer to: https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample_1.html#ckeditor-initialization */
CKEDITOR.config.allowedContent = true;

/* Register plugin to CkEditor */
CKEDITOR.config.extraPlugins = 'lobiUploader';