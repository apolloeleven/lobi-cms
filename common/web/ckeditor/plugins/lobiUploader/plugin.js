//TODO change icon image path. Now it comes from backend web/img/ck-editor

CKEDITOR.plugins.add('lobiUploader', {
    icons: 'lobiUploader',
    init: function (editor) {
        editor.addCommand('lobiUploader', new CKEDITOR.dialogCommand('lobiUploaderDialog'));
        editor.ui.addButton('LobiUploader', {
            label: 'Choose images',
            command: 'lobiUploader',
            toolbar: 'insert',
            icon : this.path + 'images/icon.png'
        });
    }
});

CKEDITOR.dialog.add('lobiUploaderDialog', function (editor) {

    var pictureTagImageCount = editor.config.pictureTagImageCount;
    var lobiUploaderDialogElements = [];

    function processMediaText(maxWidth, minWidth) {
        var mediaText = "";
        if (maxWidth && minWidth) {
            mediaText = "(min-width: " + minWidth + "px) and (max-width: " + maxWidth + "px)";
        } else if (minWidth) {
            mediaText = "(min-width: " + minWidth + "px)";
        } else if (maxWidth) {
            mediaText = "(max-width: " + maxWidth + "px)";
        }

        return mediaText;
    }

    lobiUploaderDialogElements.push({
        type: 'hbox',
        widths: ['100%'],
        children: [
            {
                type: 'text',
                id: 'id-alt-text',
                label: 'Alt Text'
            }
        ]
    });

    for (let i = 1; i <= pictureTagImageCount; i++) {
        var topRow = {
            type: 'hbox',
            widths: ['100%'],
            children: [
                {
                    type: 'checkbox',
                    id: 'id-is-default-' + i,
                    label: 'Default',
                    onClick: function () {
                        for (var i = 1; i <= pictureTagImageCount; i++) {
                            var checkbox = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-is-default-' + i);
                            if (checkbox.id !== this.id) {
                                checkbox.setValue(false);
                            }
                        }
                    }
                }
            ]
        };
        var bottomRow = {
            type: 'hbox',
            widths: ['55', '15%', '15%', '15%'],
            children: [
                {
                    type: 'text',
                    id: 'id-url-' + i,
                    label: "Url"
                },
                {
                    type: 'text',
                    id: 'id-max-width-' + i,
                    label: "Max width"
                },
                {
                    type: 'text',
                    id: 'id-min-width-' + i,
                    label: "Min width"
                },
                {
                    type: 'button',
                    hidden: true,
                    id: 'id-filebrowser' + i,
                    style: 'margin-top: 20px',
                    label: "Browse",
                    filebrowser: {
                        action: 'Browse',
                        onSelect: function (fileUrl, data) {
                            var urlInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-url-' + i);
                            urlInputElement.setValue(fileUrl);
                        }
                    }
                },
            ]
        };

        lobiUploaderDialogElements.push(topRow);
        lobiUploaderDialogElements.push(bottomRow);
    }

    lobiUploaderDialogElements.push({
        id: 'picture',
        type: 'text',
        html: '',
        style: 'visibility: hidden',
        setup: function (element) {
            console.log(element);
        }
    });

    return {
        title: 'Lobi Uploader',
        minWidth: 600,
        minHeight: 300,
        contents: [
            {
                id: 'main-tab',
                label: 'Basic Settings',
                elements: lobiUploaderDialogElements
            }
        ],
        onShow: function () {
            var selection = editor.getSelection();
            var element = selection.getStartElement();
            var pictureTag = element.$;

            var imgArray = [];
            var defaultImage = null;

            for (var i = 0; i < pictureTag.childNodes.length; i++) {
                var child = pictureTag.childNodes[i];

                if (child.localName === 'source') {
                    imgArray.push({
                        url: child.srcset,
                        default: false,
                        media: child.media,
                        position: child.getAttribute('position')
                    });
                } else if (child.localName === 'img') {
                    defaultImage = {
                        url: child.src,
                        default: true,
                        media: null,
                        position: child.getAttribute('position'),
                        altText: child.getAttribute('alt')
                    };
                }
            }

            if (defaultImage) {
                var urlInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-url-' + defaultImage.position);
                var checkbox = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-is-default-' + defaultImage.position);
                var altTextInput = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-alt-text');
                altTextInput.setValue(defaultImage.altText);
                urlInputElement.setValue(defaultImage.url);
                checkbox.setValue(true);
            }

            if (imgArray.length) {

                for (var i = 0; i < imgArray.length; i++) {

                    urlInputElement = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-url-' + imgArray[i].position);
                    checkbox = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-is-default-' + imgArray[i].position);
                    var maxWidthInput = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-max-width-' + imgArray[i].position);
                    var minWidthInput = CKEDITOR.dialog.getCurrent().getContentElement('main-tab', 'id-min-width-' + imgArray[i].position);

                    urlInputElement.setValue(imgArray[i].url);
                    checkbox.setValue(false);

                    var maxWidthRegex = /max\-width:\s*(\d+)px/;
                    var minWidthRegex = /min\-width:\s*(\d+)px/;

                    var minWidthResult = imgArray[i].media.match(minWidthRegex);
                    var maxWidthResult = imgArray[i].media.match(maxWidthRegex);

                    if (minWidthResult) {
                        minWidthInput.setValue(minWidthResult[1]);
                    }

                    if (maxWidthResult) {
                        maxWidthInput.setValue(maxWidthResult[1]);
                    }

                }
            }

            console.log(imgArray);
            console.log(defaultImage);
        },
        onOk: function () {
            var dialog = this;

            var imgArray = [];
            var defaultImage = false;

            for (var i = 1; i <= pictureTagImageCount; i++) {

                var urlInputElement = dialog.getContentElement('main-tab', 'id-url-' + i);
                var checkbox = dialog.getContentElement('main-tab', 'id-is-default-' + i);
                var maxWidth = dialog.getContentElement('main-tab', 'id-max-width-' + i);
                var minWidth = dialog.getContentElement('main-tab', 'id-min-width-' + i);

                var urlInputElementValue = urlInputElement.getValue();
                var isDefault = checkbox.getValue();
                var maxWidthValue = maxWidth.getValue();
                var minWidthValue = minWidth.getValue();

                if (!urlInputElementValue || (!isDefault && !maxWidthValue && !minWidthValue)) {
                    continue;
                }

                if (isDefault) {
                    defaultImage = {
                        url: urlInputElementValue,
                        default: isDefault,
                        maxWidth: maxWidthValue,
                        minWidth: minWidthValue,
                        position: i
                    };
                    continue;
                }

                imgArray.push({
                    url: urlInputElementValue,
                    default: isDefault,
                    maxWidth: maxWidthValue,
                    minWidth: minWidthValue,
                    position: i
                });
            }


            if (imgArray.length) {
                if (!defaultImage) {
                    defaultImage = imgArray.shift();
                }

                var pictureTag = "";
                var altTextValue = dialog.getContentElement('main-tab', 'id-alt-text').getValue();

                for (var i = 0; i < imgArray.length; i++) {
                    var mediaText = processMediaText(imgArray[i].maxWidth, imgArray[i].minWidth);
                    pictureTag += "\n\t <source media='" + mediaText + "' srcset='" + imgArray[i].url + "' position='" + imgArray[i].position + "'/>";
                }
                pictureTag += "\n\t <img src='" + defaultImage.url + "' position='" + defaultImage.position + "' alt='" + altTextValue + "'>";

                var customHtmlElement = CKEDITOR.document.createElement('picture');
                customHtmlElement.setHtml(pictureTag);
                editor.insertElement(customHtmlElement);
            }
        }
    }
});

/* Following command was added due to content filtering reasons. Refer to: https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample_1.html#ckeditor-initialization */
CKEDITOR.config.allowedContent = true;

/* Register plugin to CkEditor */
CKEDITOR.config.extraPlugins = 'lobiUploader';
