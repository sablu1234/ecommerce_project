(function ($) {

    "use strict";

    $(document).ready(function () {
        $('#datatable').DataTable();
    });

    tinymce.init({
        selector: '.editor',
        height : '300'
    });

    $('.select2').select2();

    feather.replace({
        'aria-hidden': 'true'
    });

    $(document).ready(function(){
        $('input, textarea, select').attr('autocomplete', 'off');
    })
    
})(jQuery);