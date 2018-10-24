export default class ModalEditor {
    constructor() {
        this.initDialog()
        this.initTree()
        this.initLinkButton()
        this.data = {};
        this.linkedIds = [];
        this.tree = [];
        this.url = null;
        this.$el = null;
    }

    initDialog() {
        this.dialog = `
    <div id="linked-modal" class="fade modal" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 style="margin-left: 50px">Choose From Pages</h2>
                </div>
                <div id="tree-modal-body" class="modal-body" data-key="2">
                        <div id="jstree-choose"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="linked-button" class="btn btn-primary">Link</button>
                </div>
            </div>
        </div>
    </div>
    `
        this.$dialog = $(this.dialog);
        $('body').append(this.$dialog);
        this.$dialog.on('shown.bs.modal', () => {
            if (this.tree.length === 0) {
                $.ajax({
                    url: '/content-tree/get-tree',
                    type: "POST",
                    data: {},
                    success: (res) => {
                        this.tree = JSON.parse(res);
                        this.applyDataToTree();
                    }
                });
            }
        })
    }

    initLinkButton() {
        this.$linkButton = this.$dialog.find('#linked-button')
        this.$linkButton.click(() => {
            this.$tree.jstree("get_checked", null, true).forEach((id) => {
                this.data.parentLinkId = parseInt(id);
            });
            $.ajax({
                url: '/content-tree/link-tree',
                type: "POST",
                data: this.data,
                success: (res) => {
                    res = JSON.parse(res);
                    if (res.success) {
                        this.$el.url = res.url;
                        this.$dialog.modal('hide');
                        this.successNotify();
                    } else {
                        this.errorNotify();
                    }
                }
            });
        })
    }

    intElement($el) {
        this.$el = $el;
    }

    initTree() {
        this.$tree = this.$dialog.find('#jstree-choose')
    }

    applyDataToTree() {
        this.$tree.jstree({
            plugins: ['checkbox', 'rules', 'types', 'wholerow'],
            checkbox: {
                "three_state": false,
            },
            core: {
                multiple: false,
                data: this.tree
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
        })
    }

    successNotify() {
        $.notify(`Saved`, {
            className: 'success',
            clickToHide: true,
            autoHide: true,
            globalPosition: 'bottom left',
        });
    }

    errorNotify() {
        $.notify(`Not Saved`, {
            className: 'error',
            clickToHide: true,
            autoHide: true,
            globalPosition: 'bottom left'
        });
    }
}
