export default class LinkEditor {
    constructor(el, modal) {
        this.$el = el;
        this.$modal = modal;
        this.url = null;
        this.initValues();

    }

    initValues() {
        this.url = this.$el.attr('href');
        this.$el.removeAttr('href');
        this.$link = $(`<i class="fa fa-external-link content-editable-link"></i>`);
        this.$link.click((e) => {
            e.stopPropagation();
            window.open(this.url)
        });
        this.$el.append(this.$link);

        this.$el.click(() => {
            this.$modal.$dialog.modal('show');
            this.$modal.data.parentId = this.$el.data('content-id');
            this.$modal.data.linkId = this.$el.data('link-content-id');
            this.$modal.intElement(this);
        })

    }

}
