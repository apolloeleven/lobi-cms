// import ContentEditable from 'ContentEditable';
import ImageEditor from './ImageEditor';
import SingleLineEditor from './SingleLineEditor';
import RichTextEditor from './RichTextEditor';
import SectionEditor from './SectionEditor';
import Modal from './ModalEditor';
import LinkEditor from './LinkEditor';

$(function () {

    if ($('body').hasClass('content-editable')) {
        CKEDITOR.disableAutoInline = true;
    }
    if (sessionStorage.hasOwnProperty('scroll')) {
        $(window).scrollTop(sessionStorage.scroll);
        sessionStorage.removeItem('scroll')
    }

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

    function initModal() {
        return new Modal();
    }

    var modal = true;

    $('[data-type=content-link]').each(function () {
        if (modal === true) {
            modal = initModal();
        }
        var linkEditor = new LinkEditor($(this), modal);
    });

    $('#with-hidden-checkbox').change(function () {
        sessionStorage.scroll = $(window).scrollTop();

        let search = location.search;
        if (search.indexOf('&hidden=1') > -1) {
            search = search.replace('&hidden=1', '')
        } else if (search.indexOf('?hidden=1&') > -1) {
            search = search.replace('?hidden=1&', '')
        } else if (search.indexOf('?hidden=1') > -1) {
            search = '';
        } else {
            if (search === '?' || !search) {
                search = '?hidden=1';
            } else {
                search += '&hidden=1';
            }
        }

        window.location.href = location.origin + location.pathname + search + location.hash;

    });
});