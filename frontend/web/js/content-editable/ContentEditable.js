export default class ContentEditable {
    constructor(el) {
        this.$el = el;
        this.initValues();
        this.attribute = this.$el.data('attr');
        this.createParentContainer();
        this.addToolbar();
        this.addButtonListener();
    }

    initValues() {
        this.requestData = new FormData();
        this.containerTemplate = '<div class="content-editable-container"></div>';
        this.$container = null;
        this.originalUrl = null;
        this.$globalContainer = $('.content-editable-container');
        this.toolbarTemplate = `<div class="button-toolbar">
                                <button class="btn btn-sm btn-primary btn-save">Save</button>
                                <button class="btn btn-sm btn-default btn-cancel">Cancel</button>
                            </div>`;
        this.$toolbar = null;
        this.$saveBtn = null;
        this.$cancelBtn = null;
    }


    createParentContainer() {
        this.$container = $(this.containerTemplate);
        this.$container.insertBefore(this.$el);
        this.$container.append(this.$el);
        this.$container.click(() => {
            this.contentClick();
        })
        this.$container.focusout(() => {
            setTimeout(() => {
                var $focus = $(document.activeElement);
                var $focusParent = $focus.closest('.button-toolbar');
                if (!(this.$el.html() === $focus.html() || this.$toolbar.data('content-id') === $focusParent.data('content-id'))) {
                    this.$container.removeClass('active');
                    this.$el.html(this.$el.data('originalContent'));
                }
            }, 1);
        })

    }

    addToolbar() {
        this.$toolbar = $(this.toolbarTemplate);
        this.$container.append(this.$toolbar);
        this.$toolbar.data('content-id', this.$el.data('content-id'))
    }

    addButtonListener() {
        this.$saveBtn = this.$container.find('.btn-save');
        this.$cancelBtn = this.$container.find('.btn-cancel');
        this.$editBtn = this.$container.find('.btn-edit-backend');
        this.$saveBtn.click(() => {
            this.save();
        })
        this.$cancelBtn.click(() => {
            this.cancel();
        })
    }

    cancel() {
        this.$el.html(this.$el.data('originalContent'));
    }

    contentClick() {
        this.$globalContainer.removeClass('active');
        this.$el.data('originalContent', this.$el.html());
        this.$container.addClass('active');
    }

    save() {
        this.prepareRequestData();
        $.ajax({
            url: '/content-tree/edit-content',
            method: 'POST',
            data: this.requestData,
            cache: false,
            contentType: false,
            processData: false,
            success: (res) => {
                res.success ? this.successNotify() : this.errorNotify()
            },
            error: () => {
                this.errorNotify()
            }
        });
        this.afterSave();
    }

    afterSave() {
        this.$el.data('originalContent', this.$el.html());
    }

    prepareRequestData() {
        this.requestData.append('language', this.$el.data('language'));
        this.requestData.append('content-id', this.$el.data('content-id'));
        this.requestData.append('attribute', this.$el.data('attr'));
        this.requestData.append('type', this.$el.data('type'));
        this.requestData.append('content', this.$el.html());
    }

    successNotify() {
        $.notify(`${this.$el.data('attr')} Saved`, {
            className: 'success',
            clickToHide: true,
            autoHide: true,
            globalPosition: 'bottom left',
        });
    }

    errorNotify() {
        $.notify(`${this.$el.data('attr')} Not Saved`, {
            className: 'error',
            clickToHide: true,
            autoHide: true,
            globalPosition: 'bottom left'
        });
    }
}
