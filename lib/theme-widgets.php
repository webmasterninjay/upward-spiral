<?php

// avoid direct access
defined('ABSPATH') or die("Nothing here. Move along mate.");

//* START WIDGET
class Testimonial_Widget extends WP_Widget {


	function __construct() {
		parent::__construct(
			'testimonial_widget', // Base ID
			__('Testimonial Widgets', 'upward-spiral'), // Name
			array( 'description' => __( 'Widget to display testimonials', 'upward-spiral' ), ) // Args
		);
	}

	//* FRONTEND WIDGET DISPLAY
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$NumberOfTestimonial = $instance['NumberOfTestimonial'];
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$this->getTestimonials($NumberOfTestimonial);
		echo $after_widget;
	}

	//* BACKEND WIDGET FORM
	public function form( $instance ) {
		if ($instance) {
			$title = esc_attr($instance['title']);
			$NumberOfTestimonial = esc_attr($instance['NumberOfTestimonial']);
		}
		else {
			$title = '';
			$NumberOfTestimonial = '';
		}
		?>
		<!-- WIDGET FORM -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'marilynhorowitz'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('NumberOfTestimonial'); ?>"><?php _e('Number of Testimonial:', 'marilynhorowitz'); ?></label>
			<select id="<?php echo $this->get_field_id('NumberOfTestimonial'); ?>"  name="<?php echo $this->get_field_name('NumberOfTestimonial'); ?>">
				<?php for($x=1;$x<=10;$x++): ?>
				<option <?php echo $x == $NumberOfTestimonial ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
				<?php endfor;?>
			</select>
		</p>
		<!-- END OF WIDGET FORM -->

		<?php
	}

	//* UPDATE THE DATA
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['NumberOfTestimonial'] = strip_tags($new_instance['NumberOfTestimonial']);
		return $instance;
	}

	//* QUERY THE TESTIMONIALS POST TYPE
	function getTestimonials($NumberOfTestimonial) {
		global $post;
		$args = array(
			'post_type' => 'testimonials',
			'showposts' => $NumberOfTestimonial,
			);

		$tlistings = new WP_Query( $args );

		if ( $tlistings->have_posts() ) {
			echo '<ul class="widget_testimonials">';

			while ( $tlistings->have_posts() ) {
				$tlistings->the_post();
        // get current value
        $current_author_name      = get_post_meta( $post->ID, '_testimonial_author_name', true );
        $current_author_title     = get_post_meta( $post->ID, '_testimonial_author_title', true );
        $current_author_company   = get_post_meta( $post->ID, '_testimonial_author_company', true );
        $current_author_location  = get_post_meta( $post->ID, '_testimonial_author_location', true );
				echo '<li>';
				echo '<blockquote>' . get_the_excerpt(). '</blockquote>';
        echo '<h4>' . $current_author_name. '</strong></h4>';
        echo '<p>' . $current_author_title. ', ' . $current_author_company. ', ' . $current_author_location. '</p>';
				echo '</li>';
			}
			echo '</ul>';

      add_action('wp_footer','upward_spiral_sidebar_testimonials_config');
		}
		else {
			echo '<p>No Testimonial yet</p>';

		}

		//* NOW WE NEED TO RESET WP POST DATA
		wp_reset_postdata();

	// END OF getTestimonials
	}
}

//* REGISTER THE WIDGET
function register_testimonial_widget() {
    register_widget( 'Testimonial_Widget' );
}
add_action( 'widgets_init', 'register_testimonial_widget' );

function upward_spiral_sidebar_testimonials_config() {
  $image_prev = get_stylesheet_directory_uri() . '/images/btn-prev.png';
	$image_next = get_stylesheet_directory_uri() . '/images/btn-next.png';
  ?>

  <!-- bxslider -->
  <script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('.widget_testimonials').bxSlider({
      adaptiveHeight: true,
      pager: false,
  		nextText: '<img src="<?php echo $image_next; ?>" height="25" width="24"/>',
      prevText: '<img src="<?php echo $image_prev; ?>" height="25" width="24"/>',
      auto: true,
  		autoHover: true
    });
  });
  </script>

  <?php
}
