//This file only controls flow header, as its named
(function($) {
    "use strict";

    $(document).ready(function () {
        stm_default_header_height();
        stm_default_header();

        stm_fixed_transparent_header();
    });

    $(window).load(function () {
        stm_default_header_height();
        stm_default_header();

        stm_fixed_transparent_header();
    });

    $(window).resize(function () {
        stm_default_header_height();
        stm_default_header();

        stm_fixed_transparent_header();
    });

    $(window).scroll(function () {
        stm_default_header();
        stm_fixed_transparent_header();
    });

    //Default header
    function stm_default_header_height(){
        if($('#header-nav-holder').length > 0 && $('.header-nav').length > 0 && $('.header-nav').hasClass('header-nav-default')) {
            var height = $('.header-nav').outerHeight();
            $('#header-nav-holder').css({
               'min-height': height + 'px'
            });
        }
    }

    function stm_default_header(){
        if($('#header-nav-holder').length > 0 && $('.header-nav').length > 0 && $('.header-nav').hasClass('header-nav-default')) {
            var currentScrollPos = $(window).scrollTop();
            var headerPos = $('#header-nav-holder').offset().top;
            if(currentScrollPos >= headerPos) {
                $('.header-nav-default').addClass('header-nav-sticky');
            } else {
                $('.header-nav-default').removeClass('header-nav-sticky');
            }
        }
    }

    //Transparent header
    function stm_fixed_transparent_header() {
        if($('#header-nav-holder').length > 0 && $('.header-nav').length > 0 && $('.header-nav').hasClass('header-nav-transparent')) {
            var currentScrollPos = $(window).scrollTop();
            var headerPos = $('#header-nav-holder').offset().top;
            if(currentScrollPos >= headerPos) {
                $('.header-nav-transparent').addClass('header-nav-sticky');
            } else {
                $('.header-nav-transparent').removeClass('header-nav-sticky');
            }
        }
    }
    

})(jQuery);




// Service Scripts
var $ = jQuery;
if($('.header-service').length > 0) {
    
    var sections = [];
    
    var headerOffset = 48;
    
    var currentVisibleSection = '';
    
    var hasVisible = false;

    $(document).ready(function () {
	    stm_sticky_service_header();
	    
		$('.header-service .header-menu li a, .header-service .header-service-right .service-header-appointment, .stm-slider-button').click(function(e){
			
			var name = $(this).attr('href');
			
			hash = name.split('#');
			
			var pageHasDiv = false;
			
			if(typeof hash[1] !== 'undefined') {
				if($('#' + hash[1]).length) {
					pageHasDiv = true;
				}
			}
			
			if(pageHasDiv){
				if(typeof($('div#' + hash[1]).offset()) != 'undefined') {
					e.preventDefault();
					$('html, body').stop().animate({
						scrollTop: $('div#' + hash[1]).offset().top - headerOffset
					}, 700);	
				}
			}
		})
		
		$('.service-mobile-menu-trigger').click(function(){
			$('.header-service .header-menu').slideToggle();
			$(this).toggleClass('active');
		});
		
    });

    $(window).load(function () {
	    stm_sticky_service_header();
	    
	    getSections();
    });

    $(window).resize(function () {
	    stm_sticky_service_header();
    });

    $(window).scroll(function () {
	    stm_sticky_service_header();
	    getSections();
    });
    
    
    function stm_sticky_service_header() {
	    var currentScrollPos = $(window).scrollTop();
        var headerPos = $('#header').offset().top;
        if(currentScrollPos >= headerPos) {
            $('.header-service-fixed').addClass('header-service-sticky');
        } else {
            $('.header-service-fixed').removeClass('header-service-sticky');
        }
		
		if(sections) {
			hasVisible = false;
			sections.forEach(function(sectionObj){
				
				if(currentScrollPos < sectionObj.height && (currentScrollPos + headerOffset + 1) > sectionObj.offset) {
						
					currentVisibleSection = sectionObj.id;
					
					$('.header-service .header-menu li').removeClass('active');
					$('a[href="' + sectionObj.id +  '"]').closest('li').addClass('active');
					
					if(!hasVisible) {
						hasVisible = true;
					}
					
				}
				
			})
			
			if(!hasVisible) {
				$('.header-service .header-menu li').removeClass('active');
			}
		}
    }
    
    function getSections() {
	    sections = [];
	    
	    $('.header-menu li').each(function(){
		    
			var currentId = $(this).find('a').attr('href');
			
			if(currentId.charAt(0) == '#') {
			
				var currentIdOffset = $('div'+currentId).offset();
			
				if(typeof currentIdOffset != 'undefined') {
					currentIdOffset = currentIdOffset.top;
					var currenIdHeight = $('div' + currentId).outerHeight() + currentIdOffset;
					sections.push({
						id:currentId,
						offset: currentIdOffset,
						height: currenIdHeight
					});
				}
			}
	    });
    }
}



// Listing Scripts
if($('.header-listing.header-listing-fixed').length > 0) {

    var $this = $('.header-listing.header-listing-fixed');

    $(document).ready(function () {
        stm_listing_fixed_header();
    });

    $(window).load(function () {
        stm_listing_fixed_header();
    });

    $(window).resize(function () {
        stm_listing_fixed_header();
    });

    $(window).scroll(function () {
        stm_listing_fixed_header();
    });

    function stm_listing_fixed_header() {

        if($('.header-listing').hasClass('header-listing-fixed')) {
            var currentScrollPos = $(window).scrollTop();
            var headerPos = $('#header').offset().top;

            if ($this.hasClass('listing-nontransparent-header')) {

                $('#header').css('min-height', $headerHeight = $this.outerHeight() + 'px');

            }

            if (currentScrollPos > headerPos + 200) {
                $this.addClass('stm-fixed-invisible');
            } else {
                $this.removeClass('stm-fixed-invisible');
            }

            if (currentScrollPos > headerPos + 400) {
                $this.addClass('stm-fixed');
                $('#header').addClass('stm-header-was-fixed');
            } else {
                $this.removeClass('stm-fixed');
                $('#header').removeClass('stm-header-was-fixed');
            }
        }
    }
}