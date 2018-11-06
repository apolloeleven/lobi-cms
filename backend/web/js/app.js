$(function () {
  "use strict";
  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  }).disableSelection();
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  $('.sidebar-menu .opened').each(function () {
    $(this).children('a').children('.menu-item-toggle-icon').removeClass('fa-plus-square-o');
    $(this).children('a').children('.menu-item-toggle-icon').addClass('fa-minus-square-o');
    $(this).children('ul').css('display', 'block');
  });

  $('#idRemoveVideoButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveVideo').val('1');
    $('#idVideoFileInput').val('');
  });

  $('#idRemoveMobileVideoButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveMobileVideo').val('1');
    $('#idMobileVideoFileInput').val('');
  });

  $('#idRemoveFileButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveFile').val('1');
    $('#idFileInput').val('');
  });
});
