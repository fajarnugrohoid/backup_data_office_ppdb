(function($) {
    "use strict";

    $.fn.parallax = function () {
        var window_width = $(window).width();
        // Parallax Scripts
        return this.each(function(i) {
            var $this = $(this);
            $this.addClass('parallax');

            function updateParallax(initial) {
                var container_height;
                if (window_width < 601) {
                    container_height = ($this.height() > 0) ? $this.height() : $this.children("img").height();
                }
                else {
                    container_height = ($this.height() > 0) ? $this.height() : 500;
                }
                var $img = $this.children("img").first();
                var img_height = $img.height();
                var parallax_dist = img_height - container_height + 100;
                var bottom = $this.offset().top + container_height;
                var top = $this.offset().top;
                var scrollTop = $(window).scrollTop();
                var windowHeight = window.innerHeight;
                var windowBottom = scrollTop + windowHeight;
                var percentScrolled = (windowBottom - top) / (container_height + windowHeight);
                var parallax = Math.round((parallax_dist * percentScrolled));

                if (initial) {
                    $img.css('display', 'block');
                }
                if ((bottom > scrollTop) && (top < (scrollTop + windowHeight))) {
                    $img.css('transform', "translate3D(-50%," + parallax + "px, 0)");
                }

            }

            // Wait for image load
            $this.children("img").one("load", function() {
                updateParallax(true);
            }).each(function() {
                if(this.complete) $(this).load();
            });

            $(document).ready(function () {
                updateParallax(false);
            });

            $(window).scroll(function() {
                window_width = $(window).width();
                updateParallax(false);
            });

            $(window).resize(function() {
                window_width = $(window).width();
                updateParallax(false);
            });

        });

    };

    $(document).ready(function () {

        if($('.stm-simple-parallax').length) {
            $('.stm-simple-parallax').append('<div class="stm-simple-parallax-gradient"><div class="stm-simple-parallax-vertical"></div></div>');
            jQuery(window).scroll(function(){
                var currentScrollPos = $(window).scrollTop();
                var scrollOn = 400 - parseFloat(currentScrollPos/1.2);
                if(scrollOn < -200) {
                    scrollOn = -200;
                }
                $('.stm-simple-parallax').css('background-position', '0 ' + scrollOn + 'px');
            });
        }

        if($('.stm-single-car-page').length) {
            jQuery(window).scroll(function(){
                var currentScrollPos = $(window).scrollTop();
                var scrollOn = 200 - parseFloat(currentScrollPos/1.2);
                if(scrollOn < -200) {
                    scrollOn = -200;
                }
                $('.stm-single-car-page').css('background-position', '0 ' + scrollOn + 'px');
            });
        }

        stm_footer_selection();
        stm_listing_mobile_functions();
        if($('.listing-nontransparent-header').length > 0) {
            $('#wrapper').css('padding-top', $('.listing-nontransparent-header').outerHeight() + 'px');
        }

        if($('.stm-banner-image-filter').length > 0) {
            $('.stm-banner-image-filter').css('top', $('.stm-banner-image-filter').closest('.wpb_wrapper').offset().top + 'px');
        }

        $('.stm-seller-notes-phrases').click(function(e){
            e.preventDefault();
            $('.stm_phrases').toggleClass('activated');
        });

        $(document).on('click', '.stm_motorcycle_pp', function(){
            $(this).toggleClass('active');
            $(this).find('ul').toggleClass('activated');
        });

        $('.stm_phrases .button').click(function(e){
            e.preventDefault();
            var $string = [];

            $('.stm_phrases input[type="checkbox"]').each(function(){
                if($(this).attr('checked')) {
                    $string.push($(this).val());
                }
            });

            $string = $string.join(',');

            var $textArea = $('.stm-phrases-unit textarea');
            var $textAreaCurrentVal = $textArea.val();
            $textAreaCurrentVal = $textAreaCurrentVal + ' ' + $string;

            $textArea.val($textAreaCurrentVal);

            $('.stm_phrases').toggleClass('activated');
        });

        $('.stm_phrases .fa-close').click(function(e){
            e.preventDefault();
            $('.stm_phrases').toggleClass('activated');
        });

        $('.stm_listing_nav_list a').click(function(){
            var $tab = $($(this).attr('href'));
            $tab.find('img').each(function(){
                $(this).attr('src', $(this).data('original'));
            })
        });


        $('.stm-material-parallax').parallax();

        //Custom functions
        stm_widget_color_first_word();
        stm_widget_instagram();
        footerToBottom();
        stmFullwidthWithParallax();
        stmMobileMenu();

        stmShowListingIconFilter();

        $('body').on('click', '.stm-after-video', function(e){
            var $this = $(this).closest('.stm-video-link-unit-wrap');
            stm_listing_add_video_input($this, 2);
        })

        var $current_video_count = 1;

        function stm_listing_add_video_input($video_unit, stm_restrict) {
            var hasEmptyCount = 0;
            var hasInputs = 0;
            $('.stm-video-units .stm-video-link-unit-wrap').each(function(){
                hasInputs++;
                var stmVal = $(this).find('input').val();
                if(stmVal.length !== 0) {
                    hasEmptyCount++;
                }
            });

            var $enable = (hasInputs - hasEmptyCount);

            if($enable < stm_restrict || hasInputs == 1) {
                $current_video_count++;
                var $video_label = $video_unit.find('.video-label').text();

                var $new_item_string =
                    '<div class="stm-video-link-unit-wrap">' +
                    '<div class="heading-font">' +
                    '<span class="video-label">' + $video_label + '</span>' +
                    ' <span class="count">' + $current_video_count + '</span>' +
                    '</div> ' +
                    '<div class="stm-video-link-unit"> ' +
                    '<input type="text" name="stm_video[]"> ' +
                    '<div class="stm-after-video"></div> ' +
                    '</div> ' +
                    '</div>'

                var new_item = $($new_item_string).hide();
                $('.stm-video-units').append(new_item);
                new_item.slideDown('fast');
            }
        }

        function stmIsValidURL(str) {
            var a  = document.createElement('a');
            a.href = str;
            return (a.host && a.host != window.location.host) ? true : false;
        }

        $('body').on('input', '.stm-video-link-unit input[type="text"]', function(e){
            if($(this).val().length > 0) {
                if(stmIsValidURL($(this).val())) {
                    $(this).closest('.stm-video-link-unit').find('.stm-after-video').addClass('active');
                    var $this = $(this).closest('.stm-video-link-unit-wrap');
                    stm_listing_add_video_input($this, 1);
                }
            } else {
                $(this).closest('.stm-video-link-unit').find('.stm-after-video').removeClass('active');
            }
        });


        if($('.stm_automanager_features_list').length > 0) {
            $('.wpb_tabs_nav li').click(function(){
                var data_tab = $(this).attr('aria-controls');

                if($('#' + data_tab).find('.stm_automanager_features_list').length > 0) {
                    $('.stm_automanager_features_list').isotope({
                        // main isotope options
                        itemSelector: '.stm_automanager_single'
                    })
                }
            });
        }

        disableFancyHandy();

        // Is on screen
	    $.fn.is_on_screen = function(){
            var win = $(window);
            var viewport = {
                top : win.scrollTop(),
                left : win.scrollLeft()
            };
            viewport.right = viewport.left + win.width();
            viewport.bottom = viewport.top + win.height();

            var bounds = this.offset();
            bounds.right = bounds.left + this.outerWidth();
            bounds.bottom = bounds.top + this.outerHeight();

            return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
        };

        $('.stm-customize-page .wpb_tabs').remove();

        //Default plugins
        $("select:not(.hide)").select2({
            width: '100%',
            minimumResultsForSearch: '1'
        });

        $('img.lazy').lazyload({
            effect: "fadeIn",
            failure_limit: Math.max('img'.length - 1, 0)
        });

        $('[data-toggle="tooltip"]').tooltip()

        $(":checkbox,:radio").uniform({});

        $('.stm-date-timepicker').stm_datetimepicker({minDate: 0});

        $('.stm-years-datepicker').stm_datetimepicker({
            timepicker:false,
            format: 'd/m/Y',
            lang: stm_lang_code
        });

        $('.fancy-iframe').fancybox({
            type        : 'iframe',
            padding     : 0,
            maxWidth    : '800px',
            width       : '100%',
            fitToView	: false,
            beforeLoad: function () {
                var url = $(this.element).data('url');
                this.href = url;
            }
        });

        $('.stm_fancybox').fancybox({
            fitToView	: false,
            padding     : 0,
            autoSize	: true,
            closeClick	: false,
            maxWidth    : '100%',
            maxHeight   : '90%',
            beforeShow: function () {
                $('body').addClass('stm_locked');
                this.title = $(this.element).attr("data-caption");
            },
            beforeClose: function () {
                $('body').removeClass('stm_locked');
            },
            helpers:  {
                title : {
                    type : 'inside'
                },
                overlay : {
                    locked : false
                }
            }
        });

        $('#searchModal').on('shown.bs.modal', function (e) {
            $('#searchform .search-input').focus();
        });


        $('p').each(function(){
            if( $(this).html() == '' ) {
                $(this).addClass('stm-hidden');
            }
        })

        var pixelRatio = window.devicePixelRatio || 1;

		if(typeof pixelRatio != 'undefined' && pixelRatio > 1) {
			$('img').each(function(){
				var stm_retina_image = $(this).data('retina');

				if(typeof stm_retina_image != 'undefined') {
					$(this).attr('src', stm_retina_image);
				}
			})
		}

        $('body').on('click', '.car-action-unit.add-to-compare.disabled', function(e){
            e.preventDefault();
            e.stopPropagation();
        })

        // Quantity actions
        $('body').on('click', '.quantity_actions span', function() {
            var quantityContainer = $(this).closest('.quantity'),
                quantityInput = quantityContainer.find('.qty'),
                quantityVal = quantityInput.attr('value');

            $('.button.update-cart').removeAttr('disabled');

            if( $(this).hasClass('plus') ) {
                quantityInput.attr('value', parseInt(quantityVal) + 1);
            } else if( $(this).hasClass('minus') ) {
                if( quantityVal > 1 ) {
                    quantityInput.attr('value', parseInt(quantityVal) - 1);
                }
            }
        });

        $('.single-product .product-type-variable table.variations select').live("change", function() {
            $(this).parent().find('.select2-selection__rendered').text($(this).find('option[value="'+ $(this).val() +'"]').text());
        });

        $('body').on('click', '.stm-modern-filter-unit-images .stm-single-unit-image', function(){

            var stmHasChecked = false;
            $('.stm-modern-filter-unit-images .stm-single-unit-image .image').addClass('non-active');
            $('.stm-modern-filter-unit-images .stm-single-unit-image').each(function(){
                var checked = $(this).find('input[type=checkbox]').prop('checked');
                if(checked) {
                    $(this).find('.image').removeClass('non-active');
                    stmHasChecked = true;
                }
            });

            if(!stmHasChecked) {
                $('.stm-modern-filter-unit-images .stm-single-unit-image .image').removeClass('non-active');
            }

        })

        $('.stm-modern-view-others').click(function(e){
            e.preventDefault();
            $(this).closest('.stm-single-unit-wrapper').find('.stm-modern-filter-others').slideToggle('fast');
        })

        $('.header-help-bar-trigger').click(function(){
            $(this).toggleClass('active');
            $('.header-help-bar ul').slideToggle();
        })

        $('.header-menu').click(function(e){
            var link = $(this).attr('href');
            if(link == '#') {
                e.preventDefault();
            }
        })

        $('#main .widget_search form.search-form input[type=search]').focus(function(){
			$(this).closest('form').addClass('focus');
        });

        $('#main .widget_search form.search-form input[type=search]').focusout(function(){
			$(this).closest('form').removeClass('focus');
        });

        $('body').on('change', '.stm-file-realfield', function() {
	        var length = $(this)[0].files.length;

	        if(length == 1) {
				var uploadVal = $(this).val();
				$(this).closest('.stm-pseudo-file-input').find(".stm-filename").text(uploadVal);
			} else if(length == 0) {
				$(this).closest('.stm-pseudo-file-input').find(".stm-filename").text('Choose file...');
			} else if(length > 1){
				$(this).closest('.stm-pseudo-file-input').find(".stm-filename").text(length + ' files chosen');
			}
		});

		$('.sell-a-car-proceed').click(function(e){
			e.preventDefault();
			var step = $(this).data(step);
			step = step.step;

			if(step == '2') {
				validateFirstStep();
				var errorsLength = Object.keys(errorFields.firstStep).length;
				if(errorsLength == 0) {
					$('a[href="#step-one"]').removeClass('active');
					$('a[href="#step-two"]').addClass('active');
					$('.form-content-unit').slideUp();
					$('#step-two').slideDown();
				}
			}
			if(step == '3') {
				$('a[href="#step-two"]').removeClass('active');
				$('a[href="#step-three"]').addClass('active');
				$('.form-content-unit').slideUp();
				$('#step-three').slideDown();
				$('a[href="#step-two"]').addClass('validated');
			}
		});

		$('.stm-sell-a-car-form input[type="submit"]').click(function(e){
			validateFirstStep();
			validateThirdStep();

			$('a[href="#step-two"]').addClass('validated');

			var errorsLength = Object.keys(errorFields.firstStep).length;
			var errorsLength2 = Object.keys(errorFields.thirdStep).length;
			if(errorsLength != 0) {
				e.preventDefault();
				$('.form-navigation-unit').removeClass('active');
				$('a[href="#step-one"]').addClass('active');
				$('#step-three').slideUp();
				$('#step-one').slideDown();
			}

			if(errorsLength2 != 0) {
				e.preventDefault();
			} else {
				$('a[href="#step-three"]').addClass('validated');
			}
		})

        $(".rev_slider_wrapper").each(function(){
            var $this = $(this);
            $this.on('revolution.slide.onloaded', function() {
                setTimeout(function(){
                    $('.stm-template-boats .wpb_revslider_element .button').addClass('loaded');
                }, 1000);
            });
        });
    });

    $(window).load(function () {
        footerToBottom();
        stmFullwidthWithParallax();
        $('.stm-blackout-overlay').addClass('stm-blackout-loaded');

        stmPreloader();
        if($('.stm-banner-image-filter').length > 0) {
            $('.stm-banner-image-filter').css('top', $('.stm-banner-image-filter').closest('.wpb_wrapper').offset().top + 'px');
        }

        if($('.listing-nontransparent-header').length > 0) {
            $('#wrapper').css('padding-top', $('.listing-nontransparent-header').outerHeight() + 'px');
        }
    });

    $(window).resize(function () {
        footerToBottom();
        stmFullwidthWithParallax();

        disableFancyHandy();
        if($('.stm-banner-image-filter').length > 0) {
            $('.stm-banner-image-filter').css('top', $('.stm-banner-image-filter').closest('.wpb_wrapper').offset().top + 'px');
        }

        if($('.listing-nontransparent-header').length > 0) {
            $('#wrapper').css('padding-top', $('.listing-nontransparent-header').outerHeight() + 'px');
        }
    });

    function loadVisible($els, trigger) {
        $els.filter(function () {
            var rect = this.getBoundingClientRect();
            return rect.top >= 0 && rect.top <= window.innerHeight;
        }).trigger(trigger);
    }

    function footerToBottom() {
        var windowH = $(window).height();
        var footerH = $('#footer').outerHeight();
        $('#wrapper').css('min-height',(windowH - footerH) + 'px');
    };

    function stm_widget_color_first_word() {
        $('.stm_wp_widget_text .widget-title h6').each(function(){
            var html = $(this).html();
            var word = html.substr(0, html.indexOf(" "));
            var rest = html.substr(html.indexOf(" "));
            $(this).html(rest).prepend($("<span/>").html(word).addClass("colored"));
        });
    }

    function stm_widget_instagram() {
        $('#sb_instagram').closest('.widget-wrapper').addClass('stm-instagram-unit');
    }

    function stmFullwidthWithParallax() {
        var screenWidth = $(window).width();
        if(screenWidth < 1140) {
            var defaultWidth = screenWidth - 30;
        } else {
            var defaultWidth = 1140 - 30;
        }
        var marginLeft = (screenWidth - defaultWidth) / 2;

        if($('body').hasClass('rtl')) {
            $('.stm-fullwidth-with-parallax').css({
                'position' : 'relative',
                'left': (marginLeft - 15) + 'px'
            })
        }

        $('.stm-fullwidth-with-parallax').css({
            'width': screenWidth + 'px',
            'margin-left': '-' + marginLeft + 'px',
            'padding-left': (marginLeft - 15) + 'px',
            'padding-right': (marginLeft - 15) + 'px'
        })
    }

    function stmMobileMenu() {
        $('.mobile-menu-trigger').click(function(){
            $(this).toggleClass('opened');
            $('.mobile-menu-holder').slideToggle();
        })
        $(".mobile-menu-holder .header-menu > li.menu-item-has-children > a")
            .after('<span class="arrow"><i class="fa fa-angle-right"></i></span>');

        $('.mobile-menu-holder .header-menu .arrow').click(function(){
            $(this).toggleClass('active');
            $(this).closest('li').toggleClass('opened');
            $(this).closest('li').find('> ul.sub-menu').slideToggle(300);
        })

        $(".mobile-menu-holder .header-menu > li.menu-item-has-children > a").click(function (e) {
            if( $(this).attr('href') == '#' ){
                e.preventDefault();
                $(this).closest('li').find(' > ul.sub-menu').slideToggle(300);
                $(this).closest('li').toggleClass('opened');
                $(this).closest('li').find('.arrow').toggleClass('active');
            }
        });
    }

    function disableFancyHandy() {
	    var winWidth = $(window).width();
	    if(winWidth < 1025) {
		    $('.media-carousel-item .stm_fancybox').click(function(e){
			    e.preventDefault();
			    e.stopPropagation();
		    })
	    }
    }

    function stmPreloader() {
	    if($('html').hasClass('stm-site-preloader')){
		    $('html').addClass('stm-site-loaded');

		    setTimeout(function(){
				$('html').removeClass('stm-site-preloader stm-site-loaded');
			}, 250);
	    }
    }

    function stmShowListingIconFilter() {
        $('.stm_icon_filter_label').click(function(){

            if(!$(this).hasClass('active')) {
                $(this).closest('.stm_icon_filter_unit').find('.stm_listing_icon_filter').toggleClass('active');
                $(this).closest('.stm_icon_filter_unit').find('.stm_listing_icon_filter .image').hide();

                $(this).addClass('active');
            } else {
                $(this).closest('.stm_icon_filter_unit').find('.stm_listing_icon_filter').toggleClass('active');
                $(this).closest('.stm_icon_filter_unit').find('.stm_listing_icon_filter .image').show();

                $(this).removeClass('active');
            }

        });
    }

    function stm_footer_selection() {
        if(typeof stm_footer_terms !== 'undefined') {
            var substringMatcher = function (strs) {
                return function findMatches(q, cb) {
                    var matches, substringRegex;

                    // an array that will be populated with substring matches
                    matches = [];

                    // regex used to determine if a string contains the substring `q`
                    var substrRegex = new RegExp(q, 'i');

                    // iterate through the pool of strings and for any string that
                    // contains the substring `q`, add it to the `matches` array
                    $.each(strs, function (i, str) {
                        if (substrRegex.test(str)) {
                            matches.push(str);
                        }
                    });

                    cb(matches);
                };
            };

            var $input = $('.stm-listing-layout-footer .stm-footer-search-inventory input');

            var selectedValue = '';

            $input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'stm_footer_terms',
                source: substringMatcher(stm_footer_terms)
            });

            $input.typeahead('val', stm_default_search_value).trigger('keyup');
            $input.typeahead('close');

            $input.keydown(function () {
                selectedValue = $(this).val();
            })

            $input.bind('typeahead:select', function (ev, suggestion) {
                selectedValue = suggestion;
            });

            var enableSubmission = false;
            $('.stm-footer-search-inventory form').submit(function (e) {
                if (!enableSubmission) {
                    e.preventDefault();
                }
                var keyChosen = $.inArray(selectedValue, stm_footer_terms);
                if (keyChosen != -1) {
                    var slug = stm_footer_terms_slugs[keyChosen];
                    var taxonomy = stm_footer_taxes[keyChosen];
                    if (typeof(taxonomy) != 'undefined' && typeof(slug) != 'undefined' && !enableSubmission) {
                        $input.attr('name', taxonomy);
                        $input.val(slug);
                        enableSubmission = true;
                        $(this).submit();
                    }
                } else {
                    if (!enableSubmission) {
                        enableSubmission = true;
                        $(this).submit();
                    }
                }

            });
        }
    }

    $('.stm-form-1-end-unit input[type="text"]').on('blur', function(){
        if($(this).val() == '') {
            $(this).removeClass('stm_has_value');
        } else {
            $(this).addClass('stm_has_value');
        }
    })

    function stm_listing_mobile_functions() {
        $('.listing-menu-mobile > li.menu-item-has-children > a').append('<span class="stm_frst_lvl_trigger"></span>');
        $('body').on('click', '.stm_frst_lvl_trigger', function(e){
            e.preventDefault();
            $(this).closest('li').find('ul.sub-menu').slideToggle();
            $(this).toggleClass('active');
        })

        $('.stm-menu-trigger').click(function(){

            $('.lOffer-account').removeClass('active');
            $('.stm-user-mobile-info-wrapper').removeClass('active');

            $('.stm-opened-menu-listing').toggleClass('opened');
            $(this).toggleClass('opened');
        });

        $('.lOffer-account').click(function(e) {
            e.preventDefault();

            $('.stm-opened-menu-listing').removeClass('opened');
            $('.stm-menu-trigger').removeClass('opened');

            $(this).toggleClass('active');

            $(this).closest('.lOffer-account-unit').find('.stm-user-mobile-info-wrapper').toggleClass('active');
        });

        $('body').click(function(e) {
            if ($(e.target).closest('#header').length === 0) {
                $('.lOffer-account').removeClass('active');
                $('.stm-user-mobile-info-wrapper').removeClass('active');
                $('.stm-opened-menu-listing').removeClass('opened');
                $('.stm-menu-trigger').removeClass('opened');
            }
        });


        /*Boats*/
        $('.stm-menu-boats-trigger').click(function(){
            $(this).toggleClass('opened');
            $('.stm-boats-mobile-menu').toggleClass('opened');
        });

        $('.stm-boats-mobile-menu .listing-menu > li.menu-item-has-children > a').append('<span class="stm-boats-menu-first-lvl"></span>');

        $('body').on('click', '.stm-boats-menu-first-lvl', function(e){
            e.preventDefault();
            $(this).closest('li').find('ul.sub-menu').toggle();
            $(this).toggleClass('active');
        })
    }

    $('#stm-dealer-view-type').change(function(){
        var tabId = $(this).val();
        $('a[href=#' + tabId + ']').tab('show');
        $("img.lazy").show().lazyload();
    });

    $('.map_link').click(function(){

    })

})(jQuery);

function stm_test_drive_car_title(id, title) {
    var $ = jQuery;
    $('.test-drive-car-name').text(title);
    $('input[name=vehicle_id]').val(id);
}

function stm_isotope_sort_function(currentChoice) {

    var $ = jQuery;
    var stm_choice = currentChoice;
    var $container = $('.stm-isotope-sorting');
    switch(stm_choice){
        case 'price_low':
            $container.isotope({
	            getSortData: {
                    price: function (itemElem) {
                        var price = $(itemElem).data('price');
                        return parseFloat(price);
                    }
                },
                sortBy: 'price',
                sortAscending: true
            });
            break
        case 'price_high':
            $container.isotope({
	            getSortData: {
                    price: function (itemElem) {
                        var price = $(itemElem).data('price');
                        return parseFloat(price);
                    }
                },
                sortBy: 'price',
                sortAscending: false
            });
            break
        case 'date_low':
            $container.isotope({
	            getSortData: {
                    date: function (itemElem) {
				        var date = $(itemElem).data('date');
				        return parseFloat(date);
				    },
                },
                sortBy: 'date',
                sortAscending: true
            });
            break
        case 'date_high':
            $container.isotope({
	            getSortData: {
                    date: function (itemElem) {
				        var date = $(itemElem).data('date');
				        return parseFloat(date);
				    },
                },
                sortBy: 'date',
                sortAscending: false
            });
            break
        case 'mileage_low':
            $container.isotope({
	            getSortData: {
                    mileage: function (itemElem) {
				        var mileage = $(itemElem).data('mileage');
				        return parseFloat(mileage);
				    }
                },
                sortBy: 'mileage',
                sortAscending: true
            });
            break
        case 'mileage_high':
            $container.isotope({
	            getSortData: {
                    mileage: function (itemElem) {
				        var mileage = $(itemElem).data('mileage');
				        return parseFloat(mileage);
				    }
                },
                sortBy: 'mileage',
                sortAscending: false
            });
            break
        case 'distance':
            $container.isotope({
                getSortData: {
                    distance: function (itemElem) {
                        var distance = $(itemElem).data('distance');
                        return parseFloat(distance);
                    }
                },
                sortBy: 'distance',
                sortAscending: true
            });
            break
        default:
            console.log('dont cheat');
    }

    $container.isotope('updateSortData').isotope();
}

var errorFields = {
    firstStep: {},
    secondStep: {},
    thirdStep: {},
}

function validateFirstStep() {
    errorFields.firstStep = {};
    var $ = jQuery;
    $('#step-one input[type="text"]').each(function(){
		var required = $(this).data('need');
	    if(typeof required !== 'undefined') {
		    if($(this).attr('name') != 'video_url') {
				if($(this).val() == '') {
					$(this).addClass('form-error');

					errorFields.firstStep[$(this).attr('name')] = $(this).closest('.form-group').find('.contact-us-label').text();
				} else {
					$(this).removeClass('form-error');
				}
		    }
	    }
    });
    var errorsLength = Object.keys(errorFields.firstStep).length;
    if(errorsLength == 0) {
	    $('a[href="#step-one"]').addClass('validated');
    } else {
	    $('a[href="#step-one"]').removeClass('validated');
    }
}

function validateThirdStep() {
	errorFields.thirdStep = {};
	var $ = jQuery;
	$('.contact-details input[type="text"],.contact-details input[type="email"]').each(function(){
		if($(this).val() == '') {
			$(this).addClass('form-error');

			errorFields.thirdStep[$(this).attr('name')] = $(this).closest('.form-group').find('.contact-us-label').text();
		} else {
			$(this).removeClass('form-error');
		}
	})
}