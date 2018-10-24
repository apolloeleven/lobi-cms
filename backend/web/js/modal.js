$(function () {

    $('#move-modal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let dataKey = button.data('key');
        var modal = $(this);
        modal.find('#move-modal-body').attr('data-key',dataKey);
    });
    $('#linked').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let dataKey = button.data('key');
        var modal = $(this);
        modal.find('#tree-modal-body').attr('data-key',dataKey);
    });
});