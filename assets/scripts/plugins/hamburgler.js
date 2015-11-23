// HAMBURGLERv2

function togglescroll () {
  jQuery('body').on('touchstart', function(e){
    
  });
}

jQuery(document).ready(function () {
    togglescroll()
    jQuery(".icon").click(function () {
        jQuery(".mobilenav").fadeToggle(500);
        jQuery(".top-menu").toggleClass("top-animate");
        jQuery("body").toggleClass("noscroll");
        jQuery(".mid-menu").toggleClass("mid-animate");
        jQuery(".bottom-menu").toggleClass("bottom-animate");
    });
});

// PUSH ESC KEY TO EXIT

jQuery(document).keydown(function(e) {
    if (e.keyCode == 27) {
        jQuery(".mobilenav").fadeOut(500);
        jQuery(".top-menu").removeClass("top-animate");
        jQuery("body").removeClass("noscroll");
        jQuery(".mid-menu").removeClass("mid-animate");
        jQuery(".bottom-menu").removeClass("bottom-animate");
    }
});

