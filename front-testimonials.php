<?php
// avoid direct access
defined('ABSPATH') or die("Nothing here. Move along mate.");

  // WP_Query arguments
  $args = array(
  	'post_type'              => array( 'testimonials' ),
  	'post_status'            => array( 'publish' ),
  );

  // The Query
  $query = new WP_Query( $args );

  // The Loop
  if ( $query->have_posts() ) {

    echo '<div class="front-testimonials"><div class="wrap">';
    echo '<div class="front-testimonials-title"><h3>'. __('Word of Mouth','upward-spiral') .'</h3></div>';
    echo '<div class="front-testimonials-items"><div class="front-testimonials-slider">';

  	while ( $query->have_posts() ) {
  		$query->the_post();

      $current_author_name      = get_post_meta( $post->ID, '_testimonial_author_name', true );
      $current_author_title     = get_post_meta( $post->ID, '_testimonial_author_title', true );
      $current_author_company   = get_post_meta( $post->ID, '_testimonial_author_company', true );
      $current_author_location  = get_post_meta( $post->ID, '_testimonial_author_location', true );

      echo '<div class="testimonials-testimonial">';
      echo '<div class="testimonial-content">';
      the_content();
      echo '</div>';
      echo '<div class="testimonial-author-info"><h4>'.$current_author_name.'</h4><span>' . $current_author_title . ' // ' .$current_author_company. ' // ' .$current_author_location . '</span></div>';
      echo '</div>';

  	}

    echo '</div></div>';
    echo '</div></div>';

  } else {
  	// no posts found
    echo '<div class="front-testimonials"><div class="wrap">';
    echo '<div class="front-testimonials-title"><h3>'. __('Word of Mouth','upward-spiral') .'</h3></div>';
    echo '<div class="front-testimonials-none">';
  	echo __('No Testimonial found.','upward-spiral');
    echo '</div>';
    echo '</div></div>';

  }

  // Restore original Post Data
  wp_reset_postdata();
