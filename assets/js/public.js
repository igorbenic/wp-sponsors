import '../../node_modules/slick-carousel/slick/slick.min.js';


(function( $ ) {
	'use strict';

	$(function(){
		if ( $('.wp-sponsors.slider').length ) {
			$('.wp-sponsors.slider').each(function(){
                $(this).slick();
			});
        }
	});

})( jQuery );
