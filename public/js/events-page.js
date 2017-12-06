$(document).ready(function(){

// on init values
    var showingSearchMobile = false;
    var showingSearch       = false;
    var tabValue            = 'upcoming';
    var categoryValue       = null;
    var sendObj             = {}

    sendObj.category        = null;
    sendObj.tab             = 'upcoming';
    sendObj.search          = null;

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('#token').attr('data') } });


    var postQuery           = function () {
        
        // $.post( "/_getICOsForMainPage", sendObj, function(data) {
        //
        //     var table = '';
        //     // for select all categories
        //     var categoryLi = "<li>All</li>";
        //
        //     if (data['category']) {
        //         for (var i = 0; i < data['category'].length; i++) {
        //             categoryLi += "<li data-category = '"+data.category[i]+"'>" +data.category[i]+ "</li>";
        //         }
        //         $(".categories").html(categoryLi);
        //         categoryList();
        //     }
        //     var arr = data['icos'];
        //
        //     if (arr.length) {
        //         data['icos'].forEach(function(value,index) {
        //         table += "<tr class = 'row-element'>" +
        //
        //             "<td class = 'first-cell'>"+
        //             "<span class='img hidden-md-down'>";
        //         if (value['ico'].icon.substr(0,4) == 'data' || value['ico'].icon.substr(0,4) == 'http') {
        //             table += "<img src='"+value['ico'].icon+"'>";
        //         } else {
        //             table += "<img src='https://www.cryptovest.com/"+value['ico'].icon+"'>";
        //         }
        //         table += "</span>" +
        //             "<a href = 'https://www.cryptovest.com/"+value['ico'].url+"'>" +value['ico'].title +
        //             "</a>";
        //         if (value['ico'].medal) {
        //             table += "<span class='star'>"+
        //                 "<img src='"+value['ico'].medal+"'>" +
        //                 "</span>";
        //         }
        //         if (value['ico'].is_featch) {
        //             table += "<span class='featured'>Featured</span>";
        //         }
        //
        //         table += "</td>" +
        //             "<td>" + value['ico'].category +
        //             "</td>" +
        //             "<td>" + value['ico'].data + " UTC </td>" +
        //             "<td class = 'time-bar'>" ;
        //             if (value['diff'].diff == '0 d 00:00:00') {
        //                 table += "<span class = 'time'> Waiting for data </span>" ;
        //             } else {
        //                 table += "<span class = 'time'>" + value['diff'].diff + "</span>";
        //             }
        //             table += "<div class='progress'>" +
        //             "<div class='bar' data-bar = '"+value['diff'].percent+"'>" +
        //             "</div>" +
        //             "</div>"+
        //             "</td>"+
        //             "</tr>";
        //     });
        //         $("#main-table-icos").html(table);
        //     } else if (arr.length == undefined) {
        //
        //
        //         table += "<tr class = 'row-element'>" +
        //
        //             "<td class = 'first-cell'>"+
        //             "<span class='img hidden-md-down'>";
        //         if (data['icos'].ico.icon.substr(0,4) == 'data' || data['icos'].ico.icon.substr(0,4) == 'http') {
        //             table += "<img src='"+data['ico'].icon+"'>";
        //         } else {
        //             table += "<img src='https://www.cryptovest.com/"+data['icos'].ico.icon+"'>";
        //         }
        //         table += "</span>" +
        //             "<a href = 'https://www.cryptovest.com/"+data['icos'].ico.url+"'>" +data['icos'].ico.title +
        //             "</a>";
        //         if (data['icos'].ico.medal) {
        //             table += "<span class='star'>"+
        //                 "<img src='"+data['icos'].ico.medal+"'>" +
        //                 "</span>";
        //         }
        //         if (data['icos'].ico.is_featch) {
        //             table += "<span class='featured'>Featured</span>";
        //         }
        //
        //         table += "</td>" +
        //             "<td>" + data['icos'].ico.category +
        //             "</td>" +
        //             "<td>" + data['icos'].ico.data + " UTC </td>" +
        //             "<td class = 'time-bar'>" ;
        //             if (data['icos'].diff.diff == '0 d 00:00:00') {
        //                 table += "<span class = 'time'> waiting for data </span>" ;
        //             } else {
        //                 table += "<span class = 'time'>" + data['icos'].diff.diff + "</span>";
        //             }
        //             table += "<div class='progress'>" +
        //             "<div class='bar' data-bar = '"+data['icos'].diff.percent+"'>" +
        //             "</div>" +
        //             "</div>"+
        //             "</td>"+
        //             "</tr>";
        //
        //             $("#main-table-events").html(table);
        //
        //     } else {
        //
        //         $("#main-table-events").html('no results');
        //     }
        //
        //    // barsValue();
        // });
    }

    // show search input

    var searchInput                 = $("#search")[0];
    searchInput.style.display       = 'none';
    var searchInputMobile           = $("#search-mobile")[0];
    searchInputMobile.style.display = 'none';

    $("#show-search").on( "click", function() {
        showingSearch = !showingSearch;
        if (showingSearch) {
            searchInput.style.display = 'inline-block';
        } else {
            searchInput.style.display = 'none';
        }
    });

    $("#show-search-mobile").on( "click", function() {
        showingSearchMobile = !showingSearchMobile;

        if (showingSearchMobile) {
            searchInputMobile.style.display = 'inline-block';
        } else {
            searchInputMobile.style.display = 'none';
        }
    });


    // get category values
    
    var categoryList = function() {
            $(".dropdown-menu.categories li").each(function( i ) {
                var changeText = 'Location'
                $( this ).on( "click", function() {
                    sendObj.category = $( this ).attr( "data-category" );                     
                    changeText = $( this ).text();
                    searchText = changeText;
                    if (changeText.length > 10) {
                        changeText = $( this ).text().substring(0, 11) + '...';
                    }
                    $( ".categories-dropdown" )[0].innerHTML = changeText;
                    $( ".categories-dropdown" )[1].innerHTML = changeText;
                    searchLocation(searchText);
                    postQuery();
                });
            });
    }
    categoryList();

   

    // get search value from input
    $( ".searching-inputs" ).on( "keyup", function() {
        if ($(this).val() == '') {
            sendObj.search = null;
        } else {
            sendObj.search = $(this).val();
        }
        postQuery();        
    } )


});

// pagination
$(window).on('load', function() {
    var ias = jQuery.ias({
        container:  '#container',
        item:       '.row-element',
        pagination: '#pagination',
        next:       '#pagination a[rel=next]'
    });

    ias.extension(new IASSpinnerExtension({src: '/images/svg/metaball-subscriptions.svg'}));
    ias.extension(new IASTriggerExtension({offset: 200}));
    ias.extension(new IASNoneLeftExtension({text: "You reached the end"}));
    ias.extension(new IASPagingExtension());
    ias.extension(new IASHistoryExtension({prev: '#pagination a[rel=prev]'}));


});
