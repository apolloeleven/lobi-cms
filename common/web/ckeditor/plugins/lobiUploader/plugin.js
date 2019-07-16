CKEDITOR.plugins.add('lobiUploader', {
    icons: 'lobiUploader',
    init: function (editor) {
        editor.addCommand('lobiUploader', new CKEDITOR.dialogCommand('lobiUploaderDialog'));
        editor.ui.addButton('LobiUploader', {
            label: 'Choose images',
            command: 'lobiUploader',
            toolbar: 'insert',
            icon: this.path + 'images/icon.png'
        });
    }
});

CKEDITOR.dialog.add('lobiUploaderDialog', function (editor) {
    return {
        title: 'Lobi Uploader',
        minWidth: 450,
        minHeight: 150,
        contents: [
            {
                id: 'main-tab',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'id-alt-text',
                        label: 'Alt text'
                    },
                    {
                        type: 'hbox',
                        widths: ['80%', '20%'],
                        children: [
                            {
                                type: 'text',
                                id: 'id-url',
                                label: "Url"
                            },
                            {
                                type: 'button',
                                hidden: true,
                                id: 'id-filebrowser',
                                style: 'margin-top: 20px',
                                label: "Browse",
                                filebrowser: {
                                    action: 'Browse',
                                    onSelect: function (fileUrl, data) {
                                        var urlInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-url');
                                        urlInputElement.setValue(fileUrl);
                                    }
                                }
                            },
                        ]
                    },
                    {
                        id: 'picture',
                        type: 'text',
                        html: '',
                        style: 'visibility: hidden',
                    }
                ]
            }
        ],
        onShow: function () {
            var selection = editor.getSelection();
            var element = selection.getStartElement();
            var pictureTag = element.$;

            for (var i = 0; i < pictureTag.childNodes.length; i++) {
                var child = pictureTag.childNodes[i];
                if (child.localName === 'img') {
                    var urlInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-url');
                    var altTextInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-alt-text');
                    urlInputElement.setValue(child.src);
                    altTextInputElement.setValue(child.getAttribute('alt'));
                }
            }
        },
        onOk: function () {
            var dialog = this;

            var urlInputElement = dialog.getContentElement('main-tab', 'id-url');
            var altTextInput = dialog.getContentElement('main-tab', 'id-alt-text');

            var imgUrl = urlInputElement.getValue();
            var altText = altTextInput.getValue();

            if (imgUrl) {

                var result = imgUrl.match(/(.+)(extra\-small|small|large|medium)(%402x)?(\.\w{2,5})$/);

                if (!result || !result[0]) {
                    return;
                }

                var url = imgUrl.replace(/(.+)(extra-small)(%402x)?(\.\w{2,5})$/, '$1small$4');

                var regex = /(.+)(small|large|medium)(%402x)?(\.\w{2,5})$/;

                var extraSmallImg = url.replace(regex, '$1extra-small$4');
                var mediumImg = url.replace(regex, '$1medium$4');
                var largeImg = url.replace(regex, '$1large$4');
                var smallImg = url.replace(regex, '$1small$4');

                var extraSmallImgRetina = url.replace(regex, '$1extra-small@2x$4');
                var mediumImgRetina = url.replace(regex, '$1medium@2x$4');
                var largeImgRetina = url.replace(regex, '$1large@2x$4');
                var smallImgRetina = url.replace(regex, '$1small@2x$4');

                var content = [];

                var mediaInnerText = "only screen and (-webkit-min-device-pixel-ratio: 2)," +
                    "only screen and (   min--moz-device-pixel-ratio: 2)," +
                    "only screen and (     -o-min-device-pixel-ratio: 2/1)," +
                    "only screen and (        min-device-pixel-ratio: 2)," +
                    "only screen and (                min-resolution: 192dpi)," +
                    "only screen and (                min-resolution: 2dppx)";

                content.push(`\n\t <source media='${mediaInnerText}' srcset='${largeImgRetina}'/>`);

                content.push(`\n\t <source media='(max-width: 768px) and ${mediaInnerText}' srcset='${extraSmallImgRetina}'/>`);
                content.push(`\n\t <source media='(max-width: 768px)' srcset='${extraSmallImg}'/>`);

                content.push(`\n\t <source media='(max-width: 992px) and ${mediaInnerText}' srcset='${smallImgRetina}'/>`);
                content.push(`\n\t <source media='(max-width: 992px)' srcset='${smallImg}'/>`);

                content.push(`\n\t <source media='(max-width: 1200px) and ${mediaInnerText}' srcset='${mediumImgRetina}'/>`);
                content.push(`\n\t <source media='(max-width: 1200px)' srcset='${mediumImg}'/>`);

                content.push(`\n\t <img alt="${altText}" src="${largeImg}"/>`);

                var pictureElement = CKEDITOR.document.createElement('picture');

                console.log(content);

                pictureElement.setHtml(content.join(''));
                editor.insertElement(pictureElement);
            }
        }
    }
});

/* Following command was added due to content filtering reasons. Refer to: https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample_1.html#ckeditor-initialization */
CKEDITOR.config.allowedContent = true;

/* Register plugin to CkEditor */
CKEDITOR.config.extraPlugins = 'lobiUploader';