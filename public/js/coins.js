$(document).ready(function(){
    // created by Artem 10.11.2017
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('#token').attr('data') } });

    var sendObj             = {};
    var showingSearch       = false;
    sendObj.tab             = '1';
    sendObj.page            =  1;
    sendObj.search          = null;

    jQuery.ajaxSetup({
      beforeSend: function() {
        $('#executivePre').show();
      },
      complete: function(){
        $('#executivePre').hide();
      },
      success: function() {}
    });
    function humanize(x){
        return x.toFixed(4).replace(/\.?0*$/,'');
    }

    var table = $('.main-list').DataTable( {
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "drawCallback": function( settings ) {
                if (sendObj.tab === '1') {
                    var number = 0;
                } else {
                    var number = 100;
                }
                var countTd = $(".main-list");
                jQuery(".main-list tr").find("td:first").each(function(){
                    number += 1;
                    $(this).text(number);
                })
            },
            "order": [],
            "paging":   false,
            "info":     false,
            "colReorder": true
        } );

    function renderData(arr, pag) {
        if (sendObj.tab === '1') {
            var count = 0;
        } else {
            var count = 100;
        }
        var dttable = $('.main-list').DataTable();
        if (arr.length > 0) {
            dttable.destroy();
        }
        var render = '';
        if ( !pag && arr.length === 0 ) {
            render = '<tr><td colspan = "9">No data for your request</td></tr>';
        }
        for (var i = 0; i < arr.length; i++) {
            count += 1;
            render += '<tr><td>' + count + '</td>' +
                      '<td class="first-cell">' +
                      // '<a href="'+ '/coins-one/' + arr[i].slug +'" rel="canonical">' +
                      // '<img src = "'+ arr[i].image +'" alt="icon"></a></span>' +
                      '<a>' + arr[i].name + '</a>' +
                      '<span class  = "bottom-short">' + arr[i].symbol + '</span>' +
                      '</td>' +
                      '<td>'+ arr[i].symbol +'</td>'+
                      '<td>'+ '$' + arr[i].marketcap_usd +'</td>';
                    if (+arr[i].price_btc < 1) {
            render +=  '<td data-order = "'+ arr[i].price_usd +'">'+ '$' + arr[i].price_usd + '<span class = "bottom-price color-btc-red">' +arr[i].price_btc + ' BTC'+'</span></td>'+

                       '<td>' +humanize(arr[i].price_btc) + ' BTC'+'</td>';
                    } else {
            render +=  '<td data-order = "'+ arr[i].price_usd +'">'+ '$' + arr[i].price_usd + '<span class = "bottom-price color-btc-green">' +arr[i].price_btc + ' BTC'+'</span></td>'+
                       '<td>' + humanize(arr[i].price_btc) +' BTC'+'</td>';
                    };
                    if (+arr[i].change_24 < 0) {
            render += '<td><span class="color-btc-red">'+arr[i].change_24+'%' +'</span></td>';           
                    } else {
            render += '<td><span class="color-btc-green">'+arr[i].change_24+'%' +'</span></td>';           
                    };
            render += '<td data-order = "'+ arr[i].volume_btc +'">'+ arr[i].volume_btc+ ' BTC'+'</td>';
            render += '<td>'+ arr[i].total_supply + '</td>'
                      '</tr>';
        };
        if (!pag) {
            $('#main-table-coins').html(render);
        } else {
            $('#main-table-coins').append(render); 
        };

        if (arr.length > 0) {
            dttable = $('.main-list').DataTable( {
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "drawCallback": function( settings ) {
                if (sendObj.tab === '1') {
                    var number = 0;
                } else {
                    var number = 100;
                }
                var countTd = $(".main-list");
                jQuery(".main-list tr").find("td:first").each(function(){
                    number += 1;
                    $(this).text(number);
                })
            },
            "order": [],
            "paging":   false,
            "info":     false
            } );
        }        
                
    };

// post query function
    function postQuery(pagination) {
        if (!pagination) {
            sendObj.page = 1;
        }
        $.post( "/_coins-pagination-search", sendObj, function(data) {
            var request = data;          
            if (pagination) {
                var pagRequest = [];
                $.each( request, function( key, value ) {
                  pagRequest.push(value);
                });
                renderData(pagRequest, true);                
            } else if (sendObj.search){
                var pagRequest = [];
                $.each( request, function( key, value ) {
                  pagRequest.push(value);
                });
                renderData(pagRequest);
            } else {
                renderData(request);
            }            
        })
    }


    // tabs
    $( ".tab-element" ).each(function( i ) {
        if ($( this ).attr( "data-tab-value" ) == sendObj.tab) {
            $( this ).addClass('active');
        }
        $(this).on( "click", function() {
            sendObj.tab = $( this ).attr( "data-tab-value" );
            postQuery();
            $( ".tab-element" ).each(function( i ) {
                ($( this ).attr( "data-tab-value" ) == sendObj.tab)? $( this ).addClass('active') : $( this ).removeClass('active');
            });
        });
    });

    var searchInput                 = $("#search")[0];
    searchInput.style.display       = 'none';
    $("#show-search").on( "click", function() {
        showingSearch = !showingSearch;
        if (showingSearch) {
            searchInput.style.display = 'inline-block';
        } else {
            searchInput.style.display = 'none';
        }
    });

    $( ".searching-inputs" ).on( "keyup", function() {
        if ($(this).val() == '') {
            sendObj.search = null;
        } else {
            sendObj.search = $(this).val();
        }
        postQuery();
    } );

    // $(window).scroll(function() {
    //    if($(window).scrollTop() + $(window).height() == $(document).height()) {
    //        sendObj.page += 1;
    //         postQuery(true);
    //    }
    // });    

})

