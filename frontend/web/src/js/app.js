$(document).ready(function () {
  var $raisingNumber = $('.raising-number'),
    $shoppingCart = $('.green-shopping-cart'),
    $mainNav = $('#menuNav'),
    $video = $('video'),
    $window = $(window),
    $matchHeight = $('.matchHeight'),
    mobileMenu;

  let myRating;

  if ($matchHeight.length > 0) {
    $matchHeight.matchHeight({
      byRow: false,
    });
  }
  // $('.header_cart_mobile').click(function () {
  //   $('#cartModal').modal();
  // });
  //
  // $('.header_cart img').click(function () {
  //   $('#cartModal').modal();
  // });

  $('#confirm_terms').change(() => {

    if ($('#confirm_terms:checked').length > 0) {
      $('#confirm_terms').val(1)
    } else {
      $('#confirm_terms').val(0)
    }

  })

  $('.minus-btn').on('click', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    $.ajax({
      url: '/cart/change-amount',
      method: 'POST',
      data: {id: $(this).data('id'), action: 'decrease'}
    }).done(function () {
      if (arguments[0].success === true) {
        value = value - 1;
        if (!arguments[0].counter > 0) {
          $shoppingCart.hide();
          $raisingNumber.hide();
        } else {
          $raisingNumber.show();
          $raisingNumber.html(arguments[0].counter);
          $shoppingCart.show();
        }
      } else {
        console.log(arguments[0].message);
      }

      $input.val(value);
    });
  });


  // $('.pdf-image-modal').on('click', function () {
  //   var $this = $(this);
  //   // $('.pdf-modal-open #myCarousel .item').remove();
  //
  //   $.ajax({
  //     url: "/service/images?id=" + $this.data('id'), success: function (result) {
  //
  //       var $pdfCarouselModal = $('#pdfCarouselModal');
  //       $pdfCarouselModal.find('.modal-body').html('').append(result);
  //       $pdfCarouselModal.modal();
  //     }
  //   });
  // });



  var $pdfCarouselModal = $('#pdfCarouselModal');
  $pdfCarouselModal.on('shown.bs.modal', function(){
    initWeelzoom();
    $('.carousel').on('slid.bs.carousel', function(){
      console.log("slid");
      initWeelzoom();
    });
    function initWeelzoom(){
      var $activeItem = $pdfCarouselModal.find('.item.active');
      if (!$activeItem.hasClass('has-zoom-image')){
        $activeItem.find('img').ImageViewer();
      }
      $activeItem.addClass('has-zoom-image');
    }
  });
  $('.pdf-image-modal').on('click', function () {
    var $this = $(this);
    // $('.pdf-modal-open #myCarousel .item').remove();
    $.ajax({
      url: "/service/images?id=" + $this.data('id'), success: function (result) {
        $pdfCarouselModal.find('.modal-body').html('').append(result);
        $pdfCarouselModal.modal();
      }
    });
  });

  $('.trash').on('click', function (e) {
    e.preventDefault();
    var $this = $(this);
    $.ajax({
      url: '/cart/delete',
      method: 'POST',
      data: {id: $(this).data('id')}
    }).done(function () {
      if (arguments[0].success === true) {
        var $removedService = $this.closest('.cart-page-teaser');
        $removedService.remove();
        if (!arguments[0].counter > 0) {
          $shoppingCart.hide();
          $raisingNumber.hide();
        } else {
          $raisingNumber.show();
          $raisingNumber.html(arguments[0].counter);
          $shoppingCart.show();
        }
      }
    });
  });

  $('.plus-btn').on('click', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('div').find('input');
    var value = parseInt($input.val());

    $.ajax({
      url: '/cart/change-amount',
      method: 'POST',
      data: {id: $(this).data('id'), action: 'increase'}
    }).done(function () {
      if (arguments[0].success === true) {
        value = value + 1;
        if (!arguments[0].counter > 0) {
          $shoppingCart.hide();
          $raisingNumber.hide();
        } else {
          $raisingNumber.show();
          $raisingNumber.html(arguments[0].counter);
          $shoppingCart.show();
        }
      } else {
        console.log(arguments[0].message);
      }
      $input.val(value);
    });
  });

  checkScroll();

  $window.scroll(checkScroll);

  mobileMenu = {
    init: function () {
      $("#mobile-menu-toggle").click(function () {
        $("#mobile-menu, #mobile-menu-toggle , .global-wrapper-inner , footer , #menuNav").toggleClass("activated");
      });

      $('#mobile-menu').find('ul.navbar-nav li.dropdown > ul > li > a.active').closest('li.dropdown').addClass('open').find('ul').addClass('active').css("display", "block");

      $('#mobile-menu ul.navbar-nav li.dropdown > div > a').on('click', function (e) {
        e.preventDefault();
        var parentLi = $(this).closest('li.dropdown');

        parentLi.siblings().removeClass('open').find('ul.active').removeClass('active').slideUp();
        if (parentLi.find('ul').hasClass('active')) {
          parentLi.removeClass('open').find('ul').removeClass('active').slideUp();
        } else {
          parentLi.addClass('open').find('ul').addClass('active').slideDown();
        }
      });

      $("#navbar a.dropdown-toggle").click(function (e) {
        if ($("#navbar").siblings(".is-tablet").is(":visible") && $(this).hasClass("no-url")) {
          e.preventDefault();
        }

        // $(this).parent(".dropdown").on("mouseleave", function(){
        // 	$(this).removeClass("open").children("a.dropdown-toggle").attr("aria-expanded", "false");
        // });
      });

      if ($(".imagegroup").length) {
        $(".imagegroup").fancybox();
      }
    }
  };

  mobileMenu.init();


  myRating = raterJs({
    element: document.querySelector("#rater"),
    rateCallback: function rateCallback(rating, done) {
      this.setRating(rating);
      done();
    }
  });

  myRating.enable();

  $('.add-to-cart').click(function (ev) {
    ev.preventDefault();

    $.ajax({
      url: '/cart/add-to-cart',
      method: 'POST',
      data: {id: $(this).data('id')}
    }).done(function () {
      if (arguments[0].success === true) {
        if (!arguments[0].counter > 0) {
          $shoppingCart.hide();
          $raisingNumber.hide();
        } else {
          $raisingNumber.show();
          $raisingNumber.html(arguments[0].counter);
          $shoppingCart.show();
        }
        $(document).scrollTop(0);
        $('#cartModal').modal('show');
      } else {
      }

    });
  });

  // calculateItems();

  // $('#idCard').click(function (ev) {
  //   ev.preventDefault();
  //   $('#cartModal').modal('show');
  // });


  $window.resize(handleVideoResize);

  initVideo();
  $video.on('loadedmetadata', handleVideoResize);

  // $video.on("loadeddata", handleVideoResize());
  (function () {

    $('.content-section-accordion-section .collapse').on('shown.bs.collapse', function (ev) {
      var $this = $(this);
      $('html,body').animate({scrollTop: $this.offset().top - 160}, 500);
    });

    var hash = window.location.hash;
    if (hash) {
      var $a = $('[href="' + hash + '"]');
      $a.click();
    }
  })();

  function createSource(video, src) {
    if (video.attr('src') === src) {
      return;
    }
    video.empty();
    video.attr('src', src);
    video[0].play();
  }

  function initVideo() {
    $video.each(function () {
      var video = $(this);
      var currentSrc = video.attr('src');
      if ($window.width() > 480 && currentSrc !== video.attr('main-src')) {
        createSource(video, video.attr('main-src'));
      } else if ($window.width() <= 480 && currentSrc !== video.attr('mobile-src')) {
        if (video.attr('mobile-src') && video.attr('mobile-src').length) {
          createSource(video, video.attr('mobile-src'));
        } else {
          createSource(video, video.attr('main-src'));
        }
      }
    });

  }

  function handleVideoResize() {
    // var height = $window.height();

    // $video.css('height', height);
    // $video.css('width', Math.max($video.width(), $window.width()));
    var parentWidth = $video.parent().outerWidth(),
      parentHeight = $video.parent().outerHeight(),
      videoWidth = Math.max($video.outerWidth(), parentWidth),
      videoHeight = $video.outerHeight(),
      marginTop = (parentHeight - videoHeight) / 2,
      marginLeft = (parentWidth - videoWidth) / 2;
    initVideo();
    $video.css({
      'width': videoWidth,
      marginTop: marginTop,
      marginLeft: marginLeft
      // 'marginLeft' : marginLeftAdjust
    });
  }

  function calculateItems() {
    let items = localStorage.getItem('esp-cart') ? JSON.parse(localStorage.getItem('esp-cart')) : {};
    let number = Object.keys(items).length;
    if (number) {
      $raisingNumber.html(number);
      $raisingNumber.show();
      $shoppingCart.show();
    } else {
      $raisingNumber.html('');
      $raisingNumber.hide();
      $shoppingCart.hide();
    }
    $('#idCartData').val(window.btoa(JSON.stringify(items)));
  }

  function checkScroll() {
    if ($window.scrollTop() > 150) {
      $('body').addClass('navbar-fixed');
      $mainNav.addClass('fixed');
    } else if ($window.scrollTop() < 150) {
      $mainNav.removeClass('fixed');
      $('body').removeClass('navbar-fixed');
    }
  }

  $window.trigger('scroll');
  $window.trigger('resize');
});

