$(document).ready(function(){


    var tab = 'news';
    // tabs on coin-one page
    $( ".coin-tab-element" ).each(function( i ) {
        var tabCls = '.' + tab;
        if ($( this ).attr( "data-tab-value" ) == tab) {
            $( this ).addClass('active');
            $( tabCls ).show()
        }
        $(this).on( "click", function() {
            tab = $( this ).attr( "data-tab-value" );
            tabCls = '.' + tab;
            $( ".coin-tab-element" ).each(function( i ) {
                ($( this ).attr( "data-tab-value" ) == tab)? $( this ).addClass('active') : $( this ).removeClass('active');
            });

            $( ".coins-tab" ).each(function( i ) {
                $( this ).hide();
            })
            $( tabCls ).show();            
        });
    });
})


