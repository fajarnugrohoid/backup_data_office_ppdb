(function($) {
    "use strict";

    $(window).load(function(){
        stm_scroll_user_sidebar();
    });

    $(window).scroll(function(){
        stm_scroll_user_sidebar();
    });


    function stm_scroll_user_sidebar() {
        var $stm_window = $(window);
        var $stm_sidebar = $('.stm-sticky-user-sidebar .stm-user-private-sidebar');
        var $stm_sidebar_holder = $('.stm-sticky-user-sidebar');

        if($stm_sidebar.outerHeight() < $stm_window.outerHeight() && $stm_sidebar.length) {
            var currentScrollPos = $(window).scrollTop();
            var sidebarPos = $stm_sidebar_holder.offset().top;

            if(currentScrollPos > sidebarPos) {
                $stm_sidebar.addClass('side-fixed');
            } else {
                $stm_sidebar.removeClass('side-fixed');
            }
        }
    }
})(jQuery);