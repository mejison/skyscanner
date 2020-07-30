$(document).ready(function() {
    //------------------------------------------------------------------------------------side-options
    $('.nav-bar-menu').click(function() {
        $('.side_menu').toggleClass('show');
        $('#ref').toggleClass('rez');
        $('.nav-bar-menu i').toggleClass('mdi-menu mdi-close');
    });
    //-------------------------------------------------------------------------------------nav
    var stickyNav = function() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 100) {
            $('#nav-row').addClass('scrolled');
            $('.profilebody-bottom').addClass('padding');
        } else {
            $('#nav-row').removeClass('scrolled');
            $('.profilebody-bottom').removeClass('padding');
        }
    };
    stickyNav();
    $(window).scroll(function() {
        stickyNav();
    });
    //--------------------------------------------------------------------------------------blog


});