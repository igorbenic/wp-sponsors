import '../../node_modules/slick-carousel/slick/slick.min.js';
import './blocks/sponsors/index';

(function( $ ) {
	'use strict';

	$(function(){
        setTimeout( () => {
            if ( $('.wp-sponsors.slider').length ) {
                $('.wp-sponsors.slider').each(function(){
                    $(this).slick();
                });
            }
        }, 2000 );
		
	});

})( jQuery );