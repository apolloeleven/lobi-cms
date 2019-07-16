import {NavbarMenu} from './components/NavbarMenu'

$(function () {
  const $headerBottom = $('#headerBottom'),
    $window = $(window);

  //disable bootstrap default toggle as far as we are using our toggle
  $("#mobile-menu-toggle").click(function (ev) {
    ev.stopPropagation();
    $(document.body).toggleClass("mobile-menu-activated");
  });


  new NavbarMenu($headerBottom);

  $('#searchBtn').click(function () {
    let $this = $(this);
    $this.closest('.form-search').toggleClass('opened');
    $this.closest('.form-search').find('input')[0].focus();

  });
});

