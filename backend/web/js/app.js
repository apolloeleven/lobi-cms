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


$(document).ready(function () {

//   var tour = new Tour({
//     backdrop: true,
//     steps: [
//       {
//         element: ".sidebar-menu",
//         title: "Side Bar Menu",
//         content: "This is Side Bar Menu"
//       },
//       {
//         element: "#content-tree",
//         title: "Content Tree",
//         content: "This is Content Tree"
//       },
//       {
//         element: "#",
//         title: "Content Tree",
//         content: "This is Content Tree"
//       },
//     ]
//   });
//
// // Initialize the tour
//   tour.init();
//
// // Start the tour
//   tour.start();

  var Tree;
  var TreeMove;
  var fullUrl = decodeURIComponent(window.location.href);
  var url = fullUrl.split('&');
  var searchParam = url[0].split('Search[content]=')[1];
  if (searchParam) {
    console.log(searchParam);
    var $context = $(".search-cont");
    $context.each(function () {
      var instance = new Mark(this);
      instance.mark(searchParam.replace('+', ' '));
      var instance2 = new Mark(this);
      instance2.mark(searchParam.replace('+', '  '));
    });
  }

  $('#linked').on('shown.bs.modal', function () {
    $.ajax({
      url: '/base/tree',
      type: "POST",
      data: {
        key: parseInt($('#tree-modal-body').attr('data-key')),
      },
      success: function (res) {
        initTree(res);
      }
    });
  });


  $('#move-modal').on('shown.bs.modal', function () {
    $.ajax({
      url: '/base/tree-for-move',
      type: "POST",
      data: {
        key: parseInt($('#tree-modal-body').attr('data-key')),
      },
      success: function (res) {
        initTreeMove(res);
      }
    });
  });

  function initTree(res) {
    Tree = JSON.parse(res);
    $('#jstree-choose').jstree({
      plugins: ['checkbox', 'types', 'wholerow'],
      checkbox: {
        "three_state": false
      },
      core: {
        data: Tree
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
    });
  }

  function initTreeMove(res) {
    TreeMove = JSON.parse(res);
    $('#jstree-move').jstree({
      plugins: ['checkbox', 'rules', 'types', 'wholerow'],
      checkbox: {
        "three_state": false,
      },
      core: {
        multiple: false,
        data: JSON.parse(res)
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
    });
  }

  setTimeout(function () {
    var $deleteButton = $(".kv-file-remove");
    $deleteButton.each(function () {
      var $deleteButton = $(this)

      $deleteButton.click(function () {
        var $this = $(this);
        var id = $this.data('key').toString();
        var $deleteInput = $('[name*=deletedImages]');
        var deleteInputVal = $deleteInput.val();
        var deletedArray = [];

        if (deleteInputVal.length > 0) {
          deletedArray = deleteInputVal.split(',')
          if (!deletedArray.includes(id)) {
            deletedArray.push(id)
          }
        } else {
          deletedArray.push(id)
        }
          deletedArray= deletedArray.join();
          deletedArray = deletedArray.toString();
          $deleteInput.val(deletedArray);
          console.log($deleteInput.value);
      })
    });
  }, 1000);

  $('#linked-button').click(function () {
    var LinkedIds = [];
    $("#jstree-choose").jstree("get_checked", null, true).forEach(function (id) {
      LinkedIds.push(id);
    });

    $.ajax({
      url: '/base/link-tree',
      type: "POST",
      data: {
        ids: LinkedIds,
        tree: parseInt($('#tree-modal-body').attr('data-key'))
      },
      success: function (res) {
        res = JSON.parse(res);
        if (res.code == 1) {
          $('#linked').modal('hide');
          lobiNotify('success', 'Link Object', 'Successfully Linked');
          //TODO append to ui-sortable;
        } else {
          lobiNotify('error', 'Link Object', res.message);
        }
      }
    });
  });

  $('#move-button').click(function () {
    var prependTo = [];
    $("#jstree-move").jstree("get_checked", null, true).forEach(function (id) {
      prependTo.push(id);
    })

    $.ajax({
      url: '/base/move-tree',
      type: "POST",
      data: {
        prepend_to: prependTo,
        moved: [parseInt($('#move-modal-body').attr('data-key'))]
      },
      success: function (res) {
        res = JSON.parse(res);
        if (res.code == 1) {
          $('#move-modal').modal('hide');
          lobiNotify('success', 'Link Object', 'Successfully Linked');
          //TODO append to ui-sortable;
        } else {
          lobiNotify('error', 'Link Object', res.message);
        }
      }
    });

  });

  //
  // $('#jstree-demo').on('select_node.jstree', function (e, data) {
  //   //selectedObject[data.node.id]  = data.node.id;
  //
  //   console.log(selectedObject);
  // });
  //
  // $('#jstree-demo').on('deselect_node.jstree', function (e, data) {
  //   selectedObject.splice(data.node.id, 1);
  //   console.log(selectedObject);
  // });

  $('#show_in_menu :checkbox').change(function () {
    var form = $('#show_in_menu');
    var formData = form.serialize();

    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: formData,
      success: function (res) {
        console.log(res);
        if (res == false) {
          lobiNotify('error', 'Show In Menu', 'Changes not Saved')
        } else {
          lobiNotify('success', 'Show In Menu', 'Saved');
        }
      },
      error: function (err) {
        lobiNotify('error', 'Show In Menu', 'Changes not Saved')
      }
    })
  });


  function filter(tree, selected) {

    var newTree = tree.filter(function (nt) {
      return selected.includes(nt.type);
    });

    for (t of newTree) {
      if (t.hasOwnProperty('children')) {
        t.children = filter(t.children, selected)
      }
    }

    return newTree;
  }

  function deepCopy(Tree) {
    var copyArray = [];
    for (t of Tree) {
      var copyObject = Object.assign({}, t)
      copyArray.push(copyObject);
      if (t.hasOwnProperty('children')) {
        t.children = deepCopy(t.children)
      }
    }

    return copyArray;
  }

  $('#table_names_tree :checkbox').change(function () {
    var selected = [];
    if ($(this).val() === 'all') {
      $('#table_names_tree input:checkbox').prop('checked', this.checked)
    } else {
      $('#table_names_tree input:checked').each(function () {
        selected.push($(this).val());
      });
    }
    $.ajax({
      url: '/base/tree',
      type: "POST",
      data: {
        table_names: selected,
      },
      success: function (res) {
        $('#jstree-choose').jstree(true).settings.core.data = JSON.parse(res)
        $('#jstree-choose').jstree(true).refresh();
      }
    });


  });

  $('#table_names_for_move :checkbox').change(function () {
    var selected = [];
    if ($(this).val() === 'all') {
      $('#table_names_for_move input:checkbox').prop('checked', this.checked)
    } else {
      $('#table_names_for_move input:checked').each(function () {
        selected.push($(this).val());
      });
    }
    $.ajax({
      url: '/base/tree-for-move',
      type: "POST",
      data: {
        table_names: selected,
      },
      success: function (res) {
        $('#jstree-move').jstree(true).settings.core.data = JSON.parse(res)
        $('#jstree-move').jstree(true).refresh();
      }
    });
  });

  function lobiNotify(type, title, msg) {
    Lobibox.notify(type, {
      sound: false,
      position: 'top right',
      delay: 1500,
      showClass: 'fadeInDown',
      title: title,
      msg: msg
    });
  }

  var fixHelperModified = function (e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function (index) {
      $(this).width($originals.eq(index).width());
    });
    return $helper;
  };


  //Make diagnosis table sortable
  $("#content_tree_child tbody").sortable({
    //helper: fixHelperModified,
    handle: '.tree-children-draggable',
    start: function (event, ui) {
      ui.item.data('start_pos', ui.item.index());
    },
    stop: function (event, ui) {
      var start_pos = ui.item.data('start_pos');
      if (start_pos != ui.item.index()) {
        var element = 0, prev = 0, next = 0;

        if (typeof ui.item.prev('tr').attr("data-key") !== 'undefined')
          prev = ui.item.prev('tr').attr("data-key");

        if (typeof ui.item.next('tr').attr("data-key") !== 'undefined')
          next = ui.item.next('tr').attr("data-key");

        element = ui.item.attr("data-key");

        $.ajax({
          url: '/base/swap',
          type: 'POST',
          data: {
            prev: prev,
            element: element,
            next: next
          },
          success: function (res) {
            if (res == false) {
              lobiNotify('error', 'Child Hierarchy', 'Changes not Saved')
            } else {
              lobiNotify('success', 'Child Hierarchy', 'Saved');
            }
          },
          error: function (err) {
            lobiNotify('error', 'Child Hierarchy', 'Changes not Saved')
          }
        });
      }
    }
  });

  $('.view-dropdown').change(function () {
    var val = $(this).val();
    var id = $(this).closest('tr').data('key');
    $.ajax({
      url: '/base/update-view',
      type: 'POST',
      data: {
        id: id,
        value: val
      },
      success: function (res) {
        if (res == false) {
          lobiNotify('error', 'View', 'Changes not Saved');
        } else {
          lobiNotify('success', 'View', 'Changes Saved')
        }
      },
      error: function (err) {
        lobiNotify('error', 'View', 'Changes not Saved');
      }
    });
  });

  $('.hide-dropdown').change(function () {
    var val = $(this).val();
    var id = $(this).closest('tr').data('key');
    $.ajax({
      url: '/base/update-hide',
      type: 'POST',
      data: {
        id: id,
        value: val
      },
      success: function (res) {
        if (res == false) {
          lobiNotify('error', 'Hidden Option', 'Changes not Saved');
        } else {
          lobiNotify('success', 'Hidden Option', 'Changes Saved')
        }
      },
      error: function (err) {
        lobiNotify('error', 'Hidden Option', 'Changes not Saved');
      }
    });
  });

  $('.widget-text-form select[name*=\"[language]\"]').change(function () {
    var option = $(this).find('option[value=\"' + this.value + '\"]');
    window.location.href = option.attr('data-url')
  });

  (function () {

    var $codes = $('.highlight code');
    $codes.each(function (index, el) {
      hljs.highlightBlock(el);
    });
  })();
});
