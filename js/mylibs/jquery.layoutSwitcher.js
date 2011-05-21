/**
 * layoutSwitcher plugin
 *
 * Allows users to switch the layout on your site by hitting a button.
 * Also adds a nice fade effect when the switch occurs
 * @requires jquery.cookie.js
 */

(function($) { 
	
	jQuery.fn.layoutSwitcher = function(options){

		var obj =  jQuery(this); 

		// Extend our default options with those provided.
	  	// Note that the first arg to extend is an empty object -
	 	// this is to keep from overriding our "defaults" object.
	 	// http://www.learningjquery.com/2007/10/a-plugin-development-pattern
		var opts = $.extend({}, $.fn.layoutSwitcher.defaults, options);


		if(jQuery.cookie(opts.cookie_name)) {
			var link = jQuery.cookie(opts.cookie_name);
			jQuery(opts.style_link).attr("href", link);
			obj.each(function(){
				if (jQuery(this).attr("href") == link) {
					jQuery(this).addClass("active");
				}	
			});
		}

		jQuery(this).click(function(event){
			event.preventDefault();
			var button = jQuery(this);
			if (button.hasClass("active")){
				// Do nothing...
				return null;
			} else {
				// Create the transition
				jQuery('body').append('<div id="overlay" />');
				jQuery('#overlay')  
		         	.css({  
		                display: 'none',  
		                position: 'absolute',  
		                top:0,  
		                left: 0,  
		                width: '100%',  
		                height: '100%',  
		                zIndex: 1000,  
		                background: '#000'  
		            })  
		            .fadeIn(500,function(){
		            	obj.removeClass("active");
		            	button.addClass("active");
		            	jQuery(opts.style_link).attr("href", button.attr('href'));
		            	jQuery('#overlay').fadeOut(500,function(){  
	                    	jQuery(this).remove();  
	                	});
		        	});

				jQuery.cookie(opts.cookie_name, button.attr('href'), {expires: opts.cookie_duration, path: '/'});
			}
		});	
	};

	jQuery.fn.layoutSwitcher.defaults = {
		style_link: 'link#main_stylesheet',
		cookie_name: 'pref_layout',
		cookie_duration: 90
	};

})(jQuery); 