!function(e){e.fn.jvmobilemenu=function(t){function n(){settings.mainContent.css({minHeight:e(window).height()})}function s(){o.removeClass("open"),TweenMax.to(l,settings.slideSpeed/2,{rotation:0,ease:Power3.easeOut}),TweenMax.to(settings.mainContent,settings.slideSpeed,{marginLeft:0}),"left"===settings.position&&TweenMax.to(o,settings.slideSpeed,{marginLeft:r}),setTimeout(function(){settings.theMenu.css({display:"block"})},300),settings.theMenu.css({"overflow-y":"hidden","-webkit-overflow-scrolling":"inherit","overflow-scrolling":"inherit"}),e(document).off("touchmove"),e("body").css({overflow:"inherit"}).removeClass("openBody")}function i(){o.addClass("open"),TweenMax.to(u,settings.slideSpeed/2,{rotation:45,ease:Power3.easeOut}),TweenMax.to(g,settings.slideSpeed/2,{rotation:-45,ease:Power3.easeOut}),TweenMax.to(settings.mainContent,settings.slideSpeed,{marginLeft:theMarginLeft}),"left"===settings.position&&TweenMax.to(o,settings.slideSpeed,{marginLeft:theMarginLeft-a}),settings.theMenu.css({display:"block"});var t=e("body");t.css({overflow:"hidden"}).addClass("openBody"),e(document).on("touchmove",function(e){e.preventDefault()}),t.on("touchstart",".mobile-menu",function(e){0===e.currentTarget.scrollTop?e.currentTarget.scrollTop=1:e.currentTarget.scrollHeight===e.currentTarget.scrollTop+e.currentTarget.offsetHeight&&(e.currentTarget.scrollTop-=1)}),t.on("touchmove",".mobile-menu",function(e){e.stopPropagation()}),settings.theMenu.css({"overflow-y":"scroll","overflow-scrolling":"touch","-webkit-overflow-scrolling":"touch"})}settings=e.extend({mainContent:e(".page"),theMenu:e(".mobile-nav"),slideSpeed:.3,menuWidth:240,position:"right",push:!0,menuPadding:"20px 20px 60px"},t),settings.theMenu.css({width:settings.menuWidth,position:"fixed",top:0,display:"block",height:"100%"}).addClass("mobile-menu").wrapInner('<div class="mobile-menu-inner"></div>'),e(".mobile-menu-inner").css({width:"auto",padding:settings.menuPadding,display:"block"}),n();var o=e(".hamburger"),r=parseInt(o.css("margin-left")),a=o.outerWidth(!0)-r,l=e(".bar2,.bar3"),u=e(".bar2"),g=e(".bar3");"left"===settings.position?(theMarginLeft=settings.menuWidth,settings.theMenu.add(o).css({left:0,right:"auto"})):"right"===settings.position&&(theMarginLeft=-settings.menuWidth,settings.theMenu.add(o).css({left:"auto",right:0})),e(window).resize(function(){s(),n()}),o.on("click",function(t){return e(this).hasClass("open")?s():i(),t.stopPropagation(),!1}),settings.mainContent.on("click",function(){o.hasClass("open")&&s()})},e.jvmobilemenu=function(t){return e("body").jvmobilemenu(t)}}(jQuery);