<?php
$bind_tax = stm_data_binding();
?>


<script type="text/javascript">
    (function($) {
        "use strict";

        var buttonText = '';
        $('document').ready(function(){
            $('.stm-boats-expand-filter span').click(function(){
                $('.stm-filter-sidebar-boats').toggleClass('expanded');
                $('.stm-boats-longer-filter').slideToggle();

                if(buttonText == '') {
                    buttonText = $(this).text();
                    $(this).text(stm_filter_expand_close);
                } else {
                    $(this).text(buttonText);
                    buttonText = '';
                }
            });

        });

    })(jQuery);
</script>