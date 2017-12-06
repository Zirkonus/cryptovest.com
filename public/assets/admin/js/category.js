$(document).ready(function(){
    var lang_main = $('#lang-select').val();
    var lang_next = 0;

    $('#edit_url').on('click', function(){
       $('#friendly_url').attr('readonly', false);
    });

    $('#lang-select').change(function (){
        lang_next = $('#lang-select').val();
        $(".lang_"+lang_next).show();
        $(".lang_"+lang_main).hide();
        lang_main = lang_next;
        lang_next = 0;
    });

});
