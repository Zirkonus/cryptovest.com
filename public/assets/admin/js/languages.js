$(document).ready(function(){
    var lang = $('#lang-select').val();
    var lang2 = 0;

    $('#lang-select').change(function(){
        lang2 = $('#lang-select').val();
        $("tbody[id=lang]").hide();
        $("tbody[id=lang2]").show();
        lang = lang2;
    });
});