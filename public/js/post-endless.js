$(document).ready(function() {
	var sendObj = {};
	sendObj.category = $('.post-content-wrapper').attr('data-category');
	sendObj.id = $('.post-content-wrapper').attr('data-post');
	
	// console.log(sendObj)
	
	// function checkVisibility(el){
 //    var dTop = $(window).scrollTop(),
 //        dBot = dTop + $(window).height(),
 //        elTop = $(el).offset().top,
 //        elBot = elTop + $(el).height();
 //    	return ((elTop <= dBot) && (elTop >= dTop));
	// };

	// function isScrolledIntoView(elem) {
	//     var docViewTop = $(window).scrollTop();
	//     var docViewBottom = docViewTop + $(window).height();

	//     var elemTop = $(elem).offset().top;
	//     var elemBottom = elemTop + $(elem).height();

	//     return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	// }
	/*var waypoints = $('.post-content-wrapper').waypoint(function(direction) {
	  	// notify(this.element.id + ' hit 25% from top of window');
	  	console.log('dfdsfs')

	}, {
	  	offset: '25%'
	});*/

	var scrollFunc = function() {
		$(".post-content-wrapper").each(function() {
			var waypoints = $( this ).waypoint(function(direction) {
	  			sendObj.id = this.element.dataset.post;
	  			sendObj.category = this.element.dataset.category;
	  			var thisUrl = this.element.dataset.url;
	  			history.replaceState(null, null, thisUrl);
			}, {
			  	offset: '10%'
			});
		});
	};
	scrollFunc();


	var url = window.location.href;
	
	$(document).on('scroll', function(){
	    // if(isScrolledIntoView()){
	        // history.replaceState(null, null, '/ertertert/anypath');
	        // console.log('visible', url);
	        // sendObj.category = myDiv.attr('data-category');
	        // sendObj.id = myDiv.attr('data-post');
	        // console.log(sendObj)
	        // console.log(myDiv.attr('data-category'));
	    // } else {
	        // history.replaceState(null, null, url);
	        // console.log("leave", url);
	    // };
	});

	var stick = function() {
		$(".fadeUpDowpForm").stick_in_parent()
			.on("sticky_kit:stick", function(e) {
		    	$(".fadeUpDowpForm").addClass("stick");
		        $(".fadeUpDowpForm").addClass("unstick");
		  	})
		  	.on("sticky_kit:unstick", function(e) {
		    	$(".fadeUpDowpForm").removeClass("stick");
		  	})
			.on("sticky_kit:bottom", function(e) {
		    	$(".fadeUpDowpForm").removeClass("unstick");
		  	})
			.on("sticky_kit:unbottom", function(e) {
		    	$(".fadeUpDowpForm").addClass("stick");
		        $(".fadeUpDowpForm").addClass("unstick");
		  	});
	};

	var openComments = function() {
		$(".open-comments-btn").each(function() {
			var flag = false;
	    	$( this ).on('click', function() {
	    		var button = $( this );
	    		var commentsBlock = $( this ).parent().next('.articleFooter');
	    		var count = $(this).attr("data-count");

	    		function open() {	    			
					if (!flag) {
						button.text('Hide Comments');
						commentsBlock.show();
					} else {
						button.text('Comments' + ' (' + count + ')');
						commentsBlock.hide();
					};
					flag = !flag;
	    		};
	    		open();
	    	})
		});
	};
	openComments();

	var postQuery = function() {
		// console.log(sendObj)
		$.get( "/_next-post", sendObj, function(data) {
			$('.mainArticleBlock').append(data);
			stick();
			openComments();
			scrollFunc();
		})
	};


	function getDocHeight() {
    	var D = document;
    	return Math.max(
	        D.body.scrollHeight, D.documentElement.scrollHeight,
	        D.body.offsetHeight, D.documentElement.offsetHeight,
	        D.body.clientHeight, D.documentElement.clientHeight
    	);
	}


$(window).scroll(function() {
       if($(window).scrollTop() + window.innerHeight == getDocHeight()) {
           postQuery();
       }
   });





	// $(window).scroll(function() {
 //        if($(window).scrollTop() + $(window).height() == $(document).height()) {
 //            postQuery();
 //        };
 //    });

});