$(window).load(function(){
				$('.flexslider').flexslider({
					//smoothHeight: true,
					controlNav: false,
					animation: "slide",
					start: function(slider){
						$('body').removeClass('loading');
					}	
				});
			});