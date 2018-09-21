import ContentEditable from './ContentEditable';

export default class SingleLineEditor extends ContentEditable {
  constructor(el) {
    super(el);
  }
  createParentContainer(){
    super.createParentContainer();
    this.$el.attr('contenteditable', true);
  }
}
