(function ($) {
    "use strict";

    STMListings.Filter.prototype.ajaxBefore = function () {
        /*Add filter preloader*/
        $('.stm-ajax-row').addClass('stm-loading');

        /*Add selects preloader*/
        $('.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b').addClass('stm-preloader');
    };

    STMListings.Filter.prototype.ajaxSuccess = function (res) {
        /*Remove preloader*/
        $('.stm-ajax-row').removeClass('stm-loading');

        /*Remove select preloaders*/
        $('.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b').removeClass('stm-preloader');
        $('.classic-filter-row .filter-sidebar select').prop("disabled", false);

        /*Disable useless selects*/
        STMListings.Filter.prototype.disableOptions(res, this);

        /*Append new html*/
        STMListings.Filter.prototype.appendData(res);

        /*Reinit js functions*/
        STMListings.Filter.prototype.reInitJs();
    };

    STMListings.Filter.prototype.disableOptions = function (res) {
        var form = this.form;
        if (typeof res.options != 'undefined') {
            $.each(res.options, function (key, options) {
                $('select[name=' + key + '] > option', form).each(function () {
                    var slug = $(this).val();
                    if (options.hasOwnProperty(slug)) {
                        $(this).prop('disabled', options[slug].disabled);
                    }
                });
            });
        }

        $('select', form).select2('destroy');
        $('select', form).select2();
    };

    STMListings.Filter.prototype.appendData = function (data) {


        STMListings.Filter.prototype.getTarget(this).html(data.html);

        /*Listing functions*/
        if ($('body').hasClass('stm-template-listing')) {
            if (typeof(data.listing_title) !== 'undefined') {
                $('.stm-car-listing-sort-units.stm-car-listing-directory-sort-units .stm-listing-directory-title .title').text(data.listing_title);
            }

            if (typeof(data.total) !== 'undefined') {
                $('.stm-car-listing-sort-units.stm-car-listing-directory-sort-units .stm-listing-directory-title .total > span').text(data.total);
            }
        }

        if($('body').hasClass('stm-template-motorcycle')) {
            $('.stm-car-listing-sort-units .stm-listing-directory-title .stm-listing-directory-total-matches > span').text(data.total);
        }
    };

    STMListings.Filter.prototype.reInitJs = function () {
        $("img.lazy").lazyload();
        $('.stm-tooltip-link, div[data-toggle="tooltip"]').tooltip();
    };

    $(document).on('click', '#stm-classic-filter-submit', function (e) {
        if ($(this).hasClass('stm-classic-filter-submit-boats')) {
            e.preventDefault();
            stm_disable_rest_filters($(this), 'listings-items');
        } else {
            $(this).closest('form').submit();
        }
    });

    // Listing price
    $(document).on('slidestop', '.stm-filter-listing-directory-price .stm-price-range', function (event, ui) {
        $(this).closest('form').submit();
    });


    //Checkboxed area listing trigger
    $(document).on('click', '.stm-ajax-checkbox-button .button, .stm-ajax-checkbox-instant .stm-option-label input', function (e) {

        if ($(this)[0].className == 'button') {
            e.preventDefault();
        }

        $(this).closest('form').submit();

    });

    $(document).on('click', '.stm-view-by a', function (e) {
        if(!$(this).hasClass('stm-modern-view')) {


            e.preventDefault();

            var viewType = $(this).data('view');

            $('.stm-view-by a').removeClass('active');
            $(this).addClass('active');

            $('#stm_view_type').val(viewType).closest('form').submit();
        }
    });

    /*Remove badge*/
    $(document).on('click', 'ul.stm-filter-chosen-units-list li > i', function () {
        var stmUrl = $(this).data('url');
        var stmFilter = $('form[data-trigger=filter]').data('Filter');
        stmFilter.performAjax(stmUrl);

        /*Reset field*/
        var stmType = $(this).data('type');
        var stmSlug = $(this).data('slug');

        if(stmType == 'select') {
            $('select[name="' + stmSlug +  '"]').val('');
            $('select[name="' + stmSlug +  '"]').find('option').prop('disabled', false);
            $('select[name="' + stmSlug +  '"]').select2('destroy').select2().select2('val', '');
        }
    });

    $(document).on('click', '.stm_boats_view_by ul li a', function (e) {
        e.preventDefault();
        var stmUrl = $(this).attr('href');
        var stmFilter = $('form[data-trigger=filter]').data('Filter');
        stmFilter.performAjax(stmUrl);

        $('.stm_boats_view_by ul li').removeClass('active');
        $(this).closest('li').addClass('active');
    });

    /*Location*/
    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(document).on('keyup', '#ca_location_listing_filter', function () {
        delay(function () {
            $('#ca_location_listing_filter').closest('form').submit();
        }, 500);
    });

    /*Boats Filter res*/
    $(document).on('change', 'body.stm-template-boats .archive-listing-page form input, body.stm-template-boats .archive-listing-page form select', function () {
        stm_disable_rest_filters($(this), 'listings-binding');
    });

    $(document).on('slidestop', '.stm-filter-sidebar-boats .stm-filter-type-slider', function (event, ui) {
        stm_disable_rest_filters($(this), 'listings-binding');
    });

    $(document).on('click', '.stm_motorcycle_pp a', function(e){
        e.preventDefault();
        e.stopPropagation();
    });

    function stm_disable_rest_filters($_this, action) {
        var $_form = $_this.closest('form');

        var data = [],
            url = $_form.attr('action'),
            sign = url.indexOf('?') < 0 ? '?' : '&';

        $.each($_form.serializeArray(), function (i, field) {
            if (field.value != '') {
                data.push(field.name + '=' + field.value)
            }
        });

        url = url + sign + data.join('&');

        $.ajax({
            url: url,
            dataType: 'json',
            context: this,
            data: '&ajax_action=' + action,
            beforeSend: function () {
                if (action == 'listings-items') {
                    $('.stm-ajax-row').addClass('stm-loading');
                } else {
                    $('.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b').addClass('stm-preloader');
                }
            },
            success: function (res) {
                if (action == 'listings-items') {
                    $('.stm-ajax-row').removeClass('stm-loading');
                    $('#listings-result').html(res.html);
                    $("img.lazy").lazyload();
                    $('.stm-tooltip-link, div[data-toggle="tooltip"]').tooltip();
                } else {
                    /*Remove select preloaders*/
                    $('.classic-filter-row .filter-sidebar .select2-container--default .select2-selection--single .select2-selection__arrow b').removeClass('stm-preloader');
                    $('.classic-filter-row .filter-sidebar select').prop("disabled", false);

                    /*Disable options*/
                    if (typeof res.options != 'undefined') {
                        $.each(res.options, function (key, options) {
                            $('select[name=' + key + '] > option', $_form).each(function () {
                                var slug = $(this).val();
                                if (options.hasOwnProperty(slug)) {
                                    $(this).prop('disabled', options[slug].disabled);
                                }
                            });
                        });
                    }

                    $('select', $_form).select2('destroy');
                    $('select', $_form).select2();

                    /*Change total*/
                    $('.stm-filter-sidebar-boats #stm-classic-filter-submit span').text(res.total);
                }
            }
        });
    }

    // Reset fields
    STMListings.resetFields = function() {
        $(document).on('reset', 'select', function(e){
            $(this).val('');
            $(this).find('option').prop('disabled', false);
            $(this).select2('destroy').select2().select2('val', '');
        });
    };

})(jQuery);

function stm_get_price_view(price, currency, currencyPos, priceDel) {
    var stmText = '';
    if (currencyPos == 'left') {
        stmText += currency;
        stmText += price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, priceDel);
    } else {
        stmText += price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, priceDel);
        stmText += currency;
    }
    return stmText;
}