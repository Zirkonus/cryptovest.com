$(document).ready(function(){
// created by Artem 08/11/2017

	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('#token').attr('data') } });
// init values
	var sendObj                     = {};
	sendObj.search                  = null;
	sendObj.company                 = null;
	sendObj.role                    = null;
	sendObj.location                = null;
	var showingSearch               = false;
	var searchInput                 = $("#search")[0];
    var paginationCount             = 1;

// Preloader
    jQuery.ajaxSetup({
      beforeSend: function() {
        $('#executivePre').show();
        $('.pagination-wrapper').hide();
      },
      complete: function(){
        $('#executivePre').hide();
        $('.pagination-wrapper').show();
      },
      success: function() {}
    });
    
    // render function. if pag = true, pagination render
    function renderData(arr, pag) {
        var render = '';
        if ( !pag && arr.length === 0 ) {
            render = '<tr><td colspan = "6">No data for your request</td></tr>';
        }
        // var pagRank = +$('#executivesTable tr.main-row:last td:first-child').text() + 1;
        for (var i = 0; i < arr.length; i++) {
            render += '<tr class = "main-row">';
            //         if (!pag) {
            // render += '<td>' + (i + 1) + '</td>';
            //         } else {
            // render +=  '<td>' + (pagRank + i) + '</td>';            
            //         };
            render +=  '<td><img class = "list-avatar" src="'+ arr[i].img +'">'+
                       '<a href ="'+ '/executives/'+arr[i].url+'/">'+ arr[i].name +'</a></td>';
                    if(arr[i].role) {
            render +=  '<td><span>'+ arr[i].role +'</span></td>'
                    } else {
            render +=  '<td>'+ '' +'</td>';         
                    };
            render +=  '<td>' + arr[i].location +'</td>';
                    if (arr[i].twitter) {
            render +=  '<td><a href="'+ arr[i].twitter +'"target="_blank"><img class = "inv-links" src= "/images/Twitter_Color.png"></a>';
                    };
                    if (arr[i].linkedin) {
            render +=  '<a href="'+ arr[i].linkedin +'"target="_blank"><img class = "inv-links" src= "/images/LinkedIN_Color.png"></a>';
                    };
            render +=  '</td></tr>';
                        if(arr[i].role) {
            render +=  '<tr class="mobile-role"><td colspan = "4">' + arr[i].role + 
                        '</td></tr>';                
                    };

        };
        if (!pag) {
            $('#executivesTable').html(render);
        } else {
            $('#executivesTable').append(render); 
        };
        
    };

// post query function
	function postQuery(pagination) {
        var obj = {};
        if (!pagination) {
            paginationCount = 1;
        }
        if (sendObj.company) {
            obj.project = sendObj.company;
        };
        if (sendObj.role) {
            obj.roles = sendObj.role;
        };
        if (sendObj.location) {
            obj.country = sendObj.location;
        };
        if (sendObj.search) {
            obj.search = sendObj.search;
        };
        obj.page = paginationCount;
		$.post( "/_executive-filter", obj, function(data) {
            var request = JSON.parse(data);          
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
    


// open search	
	$("#show-search").on( "click", function() {
        showingSearch = !showingSearch;
        if (showingSearch) {
            searchInput.style.display = 'inline-block';
        } else {
            searchInput.style.display = 'none';
        };
    });
// send post query when search on keyup
    $( ".searching-inputs" ).on( "keyup", function() {
        if ($(this).val() == '') {
            sendObj.search = null;
        } else {
            sendObj.search = $(this).val();
        };
        postQuery(); 
    } );


    var categoryList = function(groupClass, dropClass) {
        $(groupClass + " .dropdown-menu li").each(function( i ) {
            var changeText = ''
            $( this ).on( "click", function() {
            	if ( groupClass == '.company' ) {
            		sendObj.company = $( this ).attr( "data-value" );
            	} else if ( groupClass == '.location' ) {
            		sendObj.location = $( this ).attr( "data-value" );
            	} else if ( groupClass == '.role' ) {
            		sendObj.role = $( this ).attr( "data-value" );
            	};                 
                changeText = $( this ).text();
               	if (changeText.length > 10) {
                    changeText = $( this ).text().substring(0, 11) + '...';
                }
                $( dropClass )[0].innerHTML = changeText;
                postQuery();              
            });
        });
    };
    categoryList('.company', '.company-dropdown');
    categoryList('.location', '.location-dropdown');
    categoryList('.role', '.role-dropdown');


    $("#expagination").on( "click", function() {
        paginationCount += 1;
        postQuery(true);
    });

// executive profile scripts
    $('.more-links').mouseover(function() {
    	$('.hover-involved').show();
  	}).mouseout(function() {
		$( ".hover-involved" ).hide(); 		
  	});
     $('.hover-involved').mouseover(function() {
        $('.hover-involved').show();
    }).mouseout(function() {
        $( ".hover-involved" ).hide();      
    });
    

});