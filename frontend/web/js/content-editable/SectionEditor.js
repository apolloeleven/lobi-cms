export default class SectionEditor {
  constructor(el) {
    this.$el = el;
    this.initValues();
    this.init();
  }

  initValues() {
    this.toolbar = `<div class="upper-button-toolbar">
                              
                                <button class="btn btn-warning btn-pretty btn-xs btn-edit">Edit</button>
                            </div>`;
    this.hideBtn = `<button class="btn btn-success btn-pretty btn-xs btn-hide"></button>`
    this.withHidden = null;
    this.$toolbar = $(this.toolbar);
    this.$hideBtn = $(this.hideBtn);
    this.$editBtn = this.$toolbar.find('.btn-edit');
  }

  init() {
    this.$el.addClass('content-editable-section');
    if (this.$el.hasClass('content-hidden')) {
      this.$hideBtn.html('Unhide');
      this.$hideBtn.data('state', 0)
    } else {
      this.$hideBtn.html('hide')
      this.$hideBtn.data('state', 1)
    }

    this.$toolbar.prepend(this.$hideBtn);
    this.$el.prepend(this.$toolbar);

    this.$hideBtn.click(() => {
      this.sectionHideButtonClick()
    })

    this.$editBtn.click(() => {
      window.open(this.$el.data('backend-url'));
    })
  }

  sectionHideButtonClick() {
    if (confirm(`You Want To Hide ${this.$el.data('title').trim()} Section`)) {
      this.withHidden = $('#with-hidden-checkbox:checked').length > 0;
      this.hide();
    }
  }

  successResponse() {
    if (this.$hideBtn.data('state') === 0) {
      this.$hideBtn.data('state', 1)
      this.$hideBtn.html('hide');
      this.$el.removeClass('content-hidden');
    } else {
      this.$hideBtn.data('state', 0)
      this.$hideBtn.html('unhide');
      this.$el.addClass(this.withHidden ? 'content-hidden' : 'hidden');
    }
  }

  hide() {
    $.ajax({
      url: '/content-tree/hide-section',
      method: 'POST',
      data: {contentId: this.$el.data('content-id'), 'state': this.$hideBtn.data('state')},
      success: (res) => {
        res.success ? this.successResponse() : this.errorNotify();
      },
      error: () => {
        this.errorNotify()
      }
    });
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
