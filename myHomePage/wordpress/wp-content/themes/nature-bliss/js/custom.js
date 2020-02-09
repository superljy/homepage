( function( $ ) {

  $(document).ready(function($){

  	// Search in Header.
    $(".search-icon").click(function(){
        $(".search-box-wrap").show();

    });

    $(".search-close").click(function(){
        $(".search-box-wrap").hide();
    });

    // Trigger mobile menu.
    $('#mobile-trigger').sidr({
		timing: 'ease-in-out',
		speed: 500,
		source: '#mob-menu',
		name: 'sidr-main'
    });

    // Implement go to top.
	var $scroll_obj = $( '#btn-scrollup' );
	$( window ).scroll(function(){
		if ( $( this ).scrollTop() > 100 ) {
			$scroll_obj.fadeIn();
		} else {
			$scroll_obj.fadeOut();
		}
	});

	$scroll_obj.click(function(){
		$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
		return false;
	});

  });

} )( jQuery );
