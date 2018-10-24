import ContentEditable from './ContentEditable';

export default class ImageEditor extends ContentEditable {

    constructor(el) {
        super(el);
    }

    initValues() {
        super.initValues();
        this.$el.closest('a').removeAttr('href');
        this.chooseImageTemplate = `<div class="upload-btn-wrapper">
                    <button class="upload-btn btn btn-default">Choose</button>
                    <input type="file"/>
                </div>`;
    }

    prepareRequestData() {
        super.prepareRequestData();
        this.requestData.append(this.attribute, this.$chooseBtn.find('input[type=file]')[0].files[0]);
    }


    afterSave() {
        super.afterSave();
        this.originalUrl = this.tempUrl
    }

    cancel() {
        this.$el.attr('src', this.originalUrl);
    }

    createParentContainer() {
        super.createParentContainer();
        this.addControls();
    }

    addControls() {
        var me = this;
        this.$chooseBtn = $(this.chooseImageTemplate);
        this.$container.append(this.$chooseBtn);
        this.$file = $(this.$chooseBtn.find('input[type=file]')[0]);
        this.originalUrl = this.$el.attr('src');
        this.$file.change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    me.$el.attr('src', e.target.result);
                    me.tempUrl = e.target.result;
                }

                reader.readAsDataURL(this.files[0]);
            }
        })
    }
}
