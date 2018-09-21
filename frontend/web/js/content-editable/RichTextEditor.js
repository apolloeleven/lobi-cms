import ContentEditable from './ContentEditable';

export default class RichTextEditor extends ContentEditable {
  constructor(el) {
    super(el);
    this.initialize();
  }

  initialize() {
    CKEDITOR.inline(this.$el.get(0))
  }
}
