

$(document).ready(function(){

    $('#openSearch').on( "click", function() {
        $('ul.navbar-nav').hide();
        $('.mobile-menu-wrapper').hide();
        $('#openSearch').hide();
        $('#openMobileSearch').hide();
        $('.search-opened').show();
        $('.hidden-lg-up .search-opened').show();
        $( ".navbar .search-opened input" ).focus();
    })
    $('#openMobileSearch').on( "click", function() {
        $('ul.navbar-nav').hide();
        $('.mobile-menu-wrapper').hide();
        $('#openSearch').hide();
        $('.hamburger').hide();
        $('#openMobileSearch').hide();
        $('.search-opened').show();
        $('.hidden-lg-up .search-opened').show();
        $( ".hidden-lg-up .search-opened input" ).focus();
    })
    $('.close-search').on( "click", function() {
        $('ul.navbar-nav').show();
        $('#openSearch').show();
        $('.hamburger').show();
        $('#openMobileSearch').show();
        $('.hidden-lg-up .search-opened').hide();
        $('.search-opened').hide();
        $('.mobile-menu-wrapper').show();

    })
    
});

