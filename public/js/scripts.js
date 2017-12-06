/**
 * Line Chart
 */
// AmCharts.makeChart( "bitcoin", {
//     "type": "serial",
//     "dataProvider": dataForApiGraf,
//     "categoryField": "point",
//     "autoMargins": false,
//     "marginLeft": 0,
//     "marginRight": 0,
//     "marginTop": 0,
//     "marginBottom": 0,
//     "graphs": [ {
//         "valueField": "value",
//         "showBalloon": false,
//         "lineColor": "#DEE2E6",
//         "negativeLineColor": "#FF2944"
//     } ],
//     "valueAxes": [ {
//         "gridAlpha": 0,
//         "axisAlpha": 0,
//         "guides": [ {
//             "value": 0,
//             "lineAlpha": 0.1
//         } ]
//     } ],
//     "categoryAxis": {
//         "gridAlpha": 0,
//         "axisAlpha": 0,
//         "startOnAxis": true
//     }
// } );


$(window).on('load', function() {
    $('.bitcoinGridItem').hover( function () {
        $(this).parent().parent().parent().parent().css('overflow','visible')
    })
    var url = window.location.href;
    if(url.slice(-4)==='?pop'){
        $('#newsFormModal').modal('show');
    }
});

// Hover menu
$(window).on('load', function() {
    $('ul.navbar-nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500);
    });

});

$(window).on('load', function() {
    $('body').jvmobilemenu({
        menuWidth: 248,
        menuPadding: '13px 15px 60px'

    });
});

$(window).on('load', function() {
    var ias = jQuery.ias({
        container:  '#container',
        item:       '.post',
        pagination: '#pagination',
        next:       '#pagination a[rel=next]'
    });

    ias.extension(new IASSpinnerExtension({src: '/images/svg/metaball-subscriptions.svg'}));
    ias.extension(new IASTriggerExtension({offset: 200}));
    ias.extension(new IASNoneLeftExtension({text: "You reached the end"}));
    ias.extension(new IASPagingExtension());
    ias.extension(new IASHistoryExtension({prev: '#pagination a[rel=prev]'}));
});

$(window).on('load', function() {
    if ($(window).width() >= 1200) {
        $.lockfixed("#leftFixButton .buttonBlock", {offset: {top: 10, bottom: 0}});
        // $.lockfixed(".fadeUpDowpForm", {offset: {top: 10, bottom: 0}});
        $.lockfixed(".authorBlock", {offset: {top: 10, bottom: 100}});
    };
});

$(document).ready(function(){
    if ($(window).width() >= 992) {
        $('a[href^="#"], *[data-href^="#"]').on('click', function (e) {
            e.preventDefault();
            var t = 1000;
            var d = $(this).attr('data-href') ? $(this).attr('data-href') : $(this).attr('href');
            $('html,body').stop().animate({scrollTop: $(d).offset().top}, t);
        });
    } else if ($(window).width() >= 768 && $(window).width() < 992) {
        $('a[href^="#"], *[data-href^="#"]').on('click', function (e) {
            e.preventDefault();
            var t = 1000;
            var d = $(this).attr('data-href') ? $(this).attr('data-href') : $(this).attr('href');
            $('html,body').stop().animate({scrollTop: $(d).offset().top - 80}, t);
        });
    } else {
        $('a[href^="#"], *[data-href^="#"]').on('click', function (e) {
            e.preventDefault();
            var t = 1000;
            var d = $(this).attr('data-href') ? $(this).attr('data-href') : $(this).attr('href');
            $('html,body').stop().animate({scrollTop: $(d).offset().top - 50}, t);
        });
    };
});




// Update countdown with different colors and width as on designs 

$(document).ready(function(){
    $( "div[data-bar]" ).each(function( i ) {
        // var value = +$( this ).attr( "data-bar" );
        // var thisData = $( this ).attr( "data-bar" ) + '%';
        // $( this ).css( "width", thisData );

        // if ( value < "33" ) {
        //   this.style.backgroundColor = "#00cea9";
        // } else if ( value >= "33" && value <= "66" ){
        //   this.style.backgroundColor = "#fda03c";
        // } else if ( value >= "66" ){
        //   this.style.backgroundColor = "#fb3c4f";
        // }


        // var value = +$( this ).attr( "data-bar" );
        // var thisData = $( this ).attr( "data-bar" ) + '%';
        // $( this ).css( "width", thisData );
        // $( this ).parent().css( "background-color", "rgba(80, 227, 194, 0.2)" );
        // this.style.backgroundColor = "#00cea9";
    });

    $( ".progress-wrapper" ).each(function( i ) {        
        var value = $(this).children(".progress").children().attr( "data-bar" ) + '%';
        if ($(this).children(".progress").children().attr( "data-bar" ) < 25) {
            value = 25 + '%';
        }
        var valueLeft = 'calc(' + value + ' - 30px)';
        $( this ).children(".progress").children().css( "width", value );
        $( this ).children(".progress").css( "background-color", "rgba(80, 227, 194, 0.2)" );
        $( this ).children(".days-counts").css( "left", valueLeft );
    })

    $( "div[data-bar2]" ).each(function( i ) {
        var value = +$( this ).attr( "data-bar2" );
        var thisData = $( this ).attr( "data-bar2" ) + '%';
        $( this ).css( "width", thisData );

        if ( value < "98" ) {
            this.style.backgroundColor = "#00cea9";
        } else if ( value >= "98" ){
            this.style.backgroundColor = "#fb3c4f";
        }
    });
});


