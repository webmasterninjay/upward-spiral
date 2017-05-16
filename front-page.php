<?php

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


// Custom body class
add_filter( 'body_class', 'upward_spiral_front_body_class' );
function upward_spiral_front_body_class( $classes ) {
	$classes[] = 'front-page';
	return $classes;
}

// Front page loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'upward_spiral_front_do_loop' );
function upward_spiral_front_do_loop() {

	// front welcome
	if ( is_active_sidebar('front-welcome') ) {
		genesis_widget_area( 'front-welcome', array(
			'before'	=> '<div class="front-welcome widget-area"><div class="wrap">',
			'after'		=> '</div></div>',
		) );
	}

	// front signup
	if ( is_active_sidebar('front-signup') ) {
		genesis_widget_area( 'front-signup', array(
			'before'	=> '<div class="front-signup widget-area"><div class="wrap">',
			'after'		=> '</div></div>',
		) );
	}

	// front services
	if ( is_active_sidebar('front-services') ) {
		genesis_widget_area( 'front-services', array(
			'before'	=> '<div class="front-services widget-area"><div class="wrap">',
			'after'		=> '</div></div>',
		) );
	}

	// front about
	genesis_widget_area( 'front-about', array(
		'before'	=> '<div class="front-about widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

	// front testimonials
	get_template_part( 'front', 'testimonials' );

	// front news
	if ( is_active_sidebar('front-blog') ) {
		echo '<div class="front-blog widget-area"><div class="wrap">';
			genesis_widget_area( 'front-blog', array(
				'before'	=> '<div class="front-blog-inner widget-area"><div class="wrap">',
				'after'		=> '</div></div>',
			) );

			get_template_part( 'front', 'news' );
		echo '</div></div>';
	}

	// front organization
	genesis_widget_area( 'front-organizations', array(
		'before'	=> '<div class="front-organizations widget-area"><div class="wrap">',
		'after'		=> '</div></div>',
	) );

}

add_action('wp_footer','usc_bxslider');
function usc_bxslider() {
	$image_prev = get_stylesheet_directory_uri() . '/images/btn-prev.png';
	$image_next = get_stylesheet_directory_uri() . '/images/btn-next.png';
?>

<!-- bxslider -->
<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('.front-testimonials-slider').bxSlider({
    adaptiveHeight: true,
    pager: false,
		nextText: '<img src="<?php echo $image_next; ?>" height="25" width="24"/>',
    prevText: '<img src="<?php echo $image_prev; ?>" height="25" width="24"/>',
    auto: true,
		autoHover: true
  });

  jQuery('.organizations-slider').bxSlider({
    minSlides: 1,
    maxSlides: 4,
    moveSlides: 1,
    slideWidth: 278,
    slideMargin: 30,
    pager: false,
    nextText: '>',
    prevText: '<',
		auto: true,
		autoHover: true
  });
});
</script>
<?php
}

genesis();
