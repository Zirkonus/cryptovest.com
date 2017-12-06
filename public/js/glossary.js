$(document).ready(function(){
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('#token').attr('data') } });
    
    jQuery.ajaxSetup({
      beforeSend: function() {
         $('#glossaryPre').show();
      },
      complete: function(){
         $('#glossaryPre').hide();
      },
      success: function() {}
    });


    
    var showingSearchMobile = false;
    var showingSearch       = false;

    var categoryValue       = null;
    var searchValue         = null;
    var letterValue         = null;
    var pageValue           = 1;



    function renderGlossary(arr) {
        var renderList = '';
        $.each(arr, function(letter, value) {
            renderList += '<tr class="glossary-tr">'+
                            '<td><span class="char-name">' + letter + '<span></td><td>';
                            for ( var i = 0; i < value.length; i++ ){
            renderList +=   '<div class="glossary-element"><h2 class="glossary-title">'+
                                value[i].title;
                                if (value[i].category) {
            renderList +=   '<div class="glossary-words"><span class="glossary-word">' + 
                            value[i].category + '</span></div>';                  
                                }
            renderList +=    '</h2><p class="glossary-description">' +
                                value[i].content + '</p></div>';                
                            };
            renderList += '</td></tr>';
        });
        $('#glossaryTable').html(renderList);
    }


    function hideAbc() {
        var searchVal = $('#search').val();
        if(searchVal) {
            $('.alphabet').hide();
            $('.search-result-block').show();
            $('.inputed-word').html(searchVal);
        } else {
            $('.alphabet').show();
            $('.search-result-block').hide()
        }
    }

    $('#search').on( "keyup", function() {
        hideAbc();
        searchValue = $(this).val();
        queryPost()           
    })

    $(".delete-link").on( "click", function() {
        $('#search').val('');
        searchValue = null;
        hideAbc();
        queryPost();
    })
    function queryPost() {
        var sendObj = {};
        if ( categoryValue ){
            sendObj.category = categoryValue;
        };
        if ( searchValue ) {
            sendObj.word = searchValue;
        };
        if ( letterValue ) {
            sendObj.char =  letterValue;
        };
        pageValue = 1;
        $.get( "/_glossary-result", sendObj, function(data) {
            var obj = jQuery.parseJSON( data );
            renderGlossary(obj)
        })
    }
    

    // opening search input
    var searchInput                 = $("#search")[0];
    $("#show-search").on( "click", function() {
        showingSearch = !showingSearch;
        if (showingSearch) {
            searchInput.style.display = 'inline-block';
        } else {
            searchInput.style.display = 'none';
        }
    });

    // get letters value and add class 'active'
    $('.letter').on('click', function(){
        window.scrollTo(0, 0);
        $('.letter').removeClass('active');
        $(this).addClass('active');
        letterValue = $(this).html().toLowerCase();
        queryPost();
    });

    var categoryList = function() {
            $(".dropdown-menu.categories li").each(function( i ) {
                var changeText = 'Category'
                $( this ).on( "click", function() {
                    window.scrollTo(0, 0);
                    categoryValue = $( this ).attr( "data-category" );                     
                    changeText    = $( this ).text();
                    searchText    = changeText;
                    if (changeText.length > 10) {
                        changeText = $( this ).text().substring(0, 11) + '...';
                    }
                    $( ".categories-dropdown" ).html(changeText);
                    queryPost()
                });
            });
    }
    categoryList();


    function renderPagination(arr) {
        var renderList = '';
        var renderElements = '';
        var test = $('#glossaryTable tr:last-child .char-name').html();
        var lastLetter = $('#glossaryTable tr:last-child .char-name').text();
        $.each(arr, function(letter, value) {
            if (letter == lastLetter) {
                for ( var i = 0; i < value.length; i++ ){
            renderElements +=   '<div class="glossary-element"><h2 class="glossary-title">'+
                                value[i].title;
                                if (value[i].category) {
            renderElements +=   '<div class="glossary-words"><span class="glossary-word">' + 
                            value[i].category + '</span></div>';                  
                                }
            renderElements +=    '</h2><p class="glossary-description">' +
                                value[i].content + '</p></div>';                
                };

                if (renderElements != '') {
                    $('#glossaryTable tr:last-child .glossary-element').last().after(renderElements);
                    renderElements = '';
                };           
            } else {
            renderList += '<tr class="glossary-tr">'+
                            '<td><span class = "char-name">' + letter + '</span></td><td>';
            for ( var i = 0; i < value.length; i++ ){
                renderList +=   '<div class="glossary-element"><h2 class="glossary-title">'+
                                    value[i].title;
                                    if (value[i].category) {
                renderList +=   '<div class="glossary-words"><span class="glossary-word">' + 
                                value[i].category + '</span></div>';                  
                                    }
                renderList +=    '</h2><p class="glossary-description">' +
                                    value[i].content + '</p></div>';                
            };
            renderList += '</td></tr>';
            if (renderList != '') {
                $('#glossaryTable tr').last().after(renderList);
                renderList = '';
            };
            }

             
        
        });
    }

    function paginationPost() {
        var sendObj = {};
        if ( categoryValue ){
            sendObj.category = categoryValue;
        };
        if ( searchValue ) {
            sendObj.word = searchValue;
        };
        if ( letterValue ) {
            sendObj.char =  letterValue;
        };
        sendObj.page = pageValue;
        $.get( "/_glossary-result", sendObj, function(data) {
            var obj = jQuery.parseJSON( data );
            renderPagination(obj);
        })
    }

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            pageValue = pageValue + 1;
            paginationPost()
        };
    });
});

