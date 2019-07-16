const $window = $(window);

export class NavbarMenu {
  constructor($navbar) {
    this.$navbar = $navbar;
    this.$dropdowns = this.$navbar.find('.dropdown');
    this.$activeSubMenuItem = this.$navbar.find('.dropdown-menu > li.active');
    this.openFirstLevelMenu();
    this.initSubmenuAnimation();
    this.initMobileMenu();
    $window.on('resize', this.onWindowResize.bind(this));
  }

  onWindowResize() {
    this.initSubmenuAnimation();
    this.openFirstLevelMenu();
  }

  openFirstLevelMenu() {
    if (NavbarMenu.isMobile()) {
      if (this.$activeSubMenuItem.length) {
        this.$activeSubMenuItem.parent().closest('.active').addClass('open');
        this.$activeSubMenuItem.closest('.dropdown-menu').css('display', 'block');
      }
    } else {
      this.$activeSubMenuItem.parent().closest('.active').removeClass('open');
      this.$activeSubMenuItem.closest('.dropdown-menu').css('display', '');
    }
  }

  initSubmenuAnimation() {
    if (NavbarMenu.isMobile()) {
      this.$dropdowns.off('show.bs.dropdown.NavbarMenu').on('show.bs.dropdown.NavbarMenu', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
      });
      this.$dropdowns.off('hide.bs.dropdown.NavbarMenu').on('hide.bs.dropdown.NavbarMenu', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
      });
    } else {
      this.$dropdowns.off('show.bs.dropdown.NavbarMenu');
      this.$dropdowns.off('hide.bs.dropdown.NavbarMenu');
    }
  }

  initMobileMenu() {
    // this.$navbar.find(".dropdown-toggle").removeAttr('data-toggle');
    this.$navbar.find(".dropdown-toggle").click((ev) => {
      if (ev.target.tagName.toLowerCase() === 'a'){
        ev.stopPropagation();
        window.location.href = ev.target.href;
      }

    });
    // this.$navbar.find('.navbar-nav li.dropdown .dropdown-caret').click(function (ev) {
    //   ev.preventDefault();
    //   ev.stopPropagation();
    //   console.log("Toggle");
    //   const $li = $(this).closest('li');
    //   if ($li.hasClass('open')) {
    //     $li.find('.dropdown-menu').first().stop(true, true).slideUp(() => {
    //       $li.removeClass('open');
    //     });
    //   } else {
    //     $li.find('.dropdown-menu').first().stop(true, true).slideDown(() => {
    //       $li.addClass('open');
    //     });
    //   }
    // });

  }

  static isMobile() {
    return $window.outerWidth() < 992;
  }
}