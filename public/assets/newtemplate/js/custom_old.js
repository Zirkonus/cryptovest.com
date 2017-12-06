var showCartPrice = function() {
    $.ajax({
        url : window.location.protocol+"//"+window.location.hostname+"/getcartprice",
        method : "GET",
        dataType : "json",
        success : function (resp) {
            $("#cart_content").html(resp.total);
        }
    });
};
$(document).ready(function(){
    if($(window).width() > 991) {
        $('ul.nav li.dropdown').hover(function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
          $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
    }

    $('#nav-icon3').click(function(){
        $(this).toggleClass('open');
    });
    $("body").on("click", "#resetcart", function() {
        Lobibox.confirm({
            msg: "Are you sure you want to empty the cart?",
            callback: function ($this, type, ev) {
                if (type == "yes") {
                    $.ajax({
                        url      : window.location.protocol + "//" + window.location.hostname+"/ajax/resetcart",
                        dataType : "json",
                        success  : function (resp) {
                            if(resp.status == "success") {
                                var url = window.location.href;
                                if (resp.only_ticket) {
                                    window.location.href =window.location.protocol + "//" + window.location.hostname + "/tickets";
                                } else {
                                    window.location.href = window.location.protocol + "//" + window.location.hostname;
                                }

                            } else {
                                Lobibox.alert("error", {
                                    msg : resp.message
                                });
                            }
                        }
                    });
                }
            }
        });
    });
    showCartPrice();
    $('.nav-tabs a').click(function(){
        $(this).tab('show');
    });
});