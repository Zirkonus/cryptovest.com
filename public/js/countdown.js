(function ( $ ) {
	// function pad(n) {
	//     return (n < 10) ? ("0" + n) : n;
	// }

	$.fn.showclock = function() {
	    
	    // var currentDate=new Date();
	    var fieldDate=$(this).data('date').split('-');
	    // var futureDate=new Date(fieldDate[0],fieldDate[1]-1,fieldDate[2],fieldDate[3],fieldDate[4],fieldDate[5]);
	    // var seconds=futureDate.getTime() / 1000 - currentDate.getTime() / 1000;
	    var seconds= +fieldDate[0] * 86400 + +fieldDate[1] * 3600 + +fieldDate[2] * 60 + +fieldDate[3];

	    

	    // if(seconds<=0 || isNaN(seconds)){
	    // 	this.hide();
	    // 	return this;
	    // }

	    var days=Math.floor(seconds/86400);
	    // seconds=seconds%86400;
	    
	    var hours=Math.floor(seconds/3600);
	    // seconds=seconds%3600;

	    var minutes=Math.floor(seconds/60);
	    // seconds=Math.floor(seconds%60);
	    

	    setInterval(function(){
			seconds = seconds - 1;
			html+="<div class='countdown-container days'>"
		    	html+="<span class='countdown-heading days-top'>Days</span>";
		    	html+="<span class='countdown-value days-bottom'>"+days+"</span>";
		    html+="</div>";
		// }

	    html+="<div class='countdown-container hours'>"
	    	html+="<span class='countdown-heading hours-top'>Hours</span>";
	    	html+="<span class='countdown-value hours-bottom'>"+hours+"</span>";
	    html+="</div>";

	    html+="<div class='countdown-container minutes'>"
	    	html+="<span class='countdown-heading minutes-top'>Minutes</span>";
	    	html+="<span class='countdown-value minutes-bottom'>"+minutes+"</span>";
	    html+="</div>";

	    html+="<div class='countdown-container seconds'>"
	    	html+="<span class='countdown-heading seconds-top'>Seconds</span>";
	    	html+="<span class='countdown-value seconds-bottom'>"+seconds+"</span>";
	    html+="</div>";

	    this.html(html);
		},1000);

	    var html="";

	    // if(days!=0){
		    html+="<div class='countdown-container days'>"
		    	html+="<span class='countdown-heading days-top'>Days</span>";
		    	html+="<span class='countdown-value days-bottom'>"+days+"</span>";
		    html+="</div>";
		// }

	    html+="<div class='countdown-container hours'>"
	    	html+="<span class='countdown-heading hours-top'>Hours</span>";
	    	html+="<span class='countdown-value hours-bottom'>"+hours+"</span>";
	    html+="</div>";

	    html+="<div class='countdown-container minutes'>"
	    	html+="<span class='countdown-heading minutes-top'>Minutes</span>";
	    	html+="<span class='countdown-value minutes-bottom'>"+minutes+"</span>";
	    html+="</div>";

	    html+="<div class='countdown-container seconds'>"
	    	html+="<span class='countdown-heading seconds-top'>Seconds</span>";
	    	html+="<span class='countdown-value seconds-bottom'>"+seconds+"</span>";
	    html+="</div>";

	    this.html(html);
	};

	$.fn.countdown = function() {
		
		var el=$(this);
		el.showclock();
		// setInterval(function(){
		// 	el.showclock();	
		// },1000);
		
	}

}(jQuery));

jQuery(document).ready(function(){
	if(jQuery(".countdown5").length>0)
		jQuery(".countdown5").countdown();
})