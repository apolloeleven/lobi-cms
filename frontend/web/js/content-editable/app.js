// import ContentEditable from 'ContentEditable';
import ImageEditor from './ImageEditor';
import SingleLineEditor from './SingleLineEditor';
import RichTextEditor from './RichTextEditor';
import SectionEditor from './SectionEditor';
// console.log(ImageEditor);

if ($('body').hasClass('content-editable')){
  CKEDITOR.disableAutoInline = true;
}
if (sessionStorage.hasOwnProperty('scroll')) {
  $(window).scrollTop(sessionStorage.scroll);
  sessionStorage.removeItem('scroll')
}

setTimeout(() => {

  $('[data-editable=true]').each(function () {
    var $this = $(this);
    if ($this.data('type') === 'rich-text') {
      var richText = new RichTextEditor($this)
    } else if ($this.data('type') === 'single-line') {
      var singleLine = new SingleLineEditor($this);
    } else if ($this.data('type') === 'image') {
      var imageEditor = new ImageEditor($this);
    }
  })

  $('[data-type=section]').each(function () {
    var section = new SectionEditor($(this));
  })

  $('#with-hidden-checkbox').change(() => {
    sessionStorage.scroll =  $(window).scrollTop();
    var urlString = window.location.href.toString();
    var param = urlString.indexOf('?') > -1 ? '&hidden=1' : '?hidden=1';
    var replaceParam = urlString.indexOf('&hidden=1') > -1 ? '&hidden=1' : urlString.indexOf('&') > -1 ? 'hidden=1' : '?hidden=1';

    if ($('#with-hidden-checkbox:checked').length > 0) {
      window.location.href = urlString + param;
    } else {
      window.location.href = urlString.replace(replaceParam, '');
    }

  })

}, 100)

