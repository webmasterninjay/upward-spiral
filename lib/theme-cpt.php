<?php
/*
* @Author Jayson Antipuesto
* @Description Testimonial custom post type with metabox
* @Site Upward Spiral Consulting
*/

// Register Custom Post Type
function testimonial_post_type() {

	$labels = array(
		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'upward-spiral' ),
		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'upward-spiral' ),
		'menu_name'             => __( 'Testimonials', 'upward-spiral' ),
		'name_admin_bar'        => __( 'Testimonial', 'upward-spiral' ),
		'archives'              => __( 'Item Archives', 'upward-spiral' ),
		'attributes'            => __( 'Item Attributes', 'upward-spiral' ),
		'parent_item_colon'     => __( 'Parent Item:', 'upward-spiral' ),
		'all_items'             => __( 'All Items', 'upward-spiral' ),
		'add_new_item'          => __( 'Add New Item', 'upward-spiral' ),
		'add_new'               => __( 'Add New', 'upward-spiral' ),
		'new_item'              => __( 'New Item', 'upward-spiral' ),
		'edit_item'             => __( 'Edit Item', 'upward-spiral' ),
		'update_item'           => __( 'Update Item', 'upward-spiral' ),
		'view_item'             => __( 'View Item', 'upward-spiral' ),
		'view_items'            => __( 'View Items', 'upward-spiral' ),
		'search_items'          => __( 'Search Item', 'upward-spiral' ),
		'not_found'             => __( 'Not found', 'upward-spiral' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'upward-spiral' ),
		'featured_image'        => __( 'Featured Image', 'upward-spiral' ),
		'set_featured_image'    => __( 'Set featured image', 'upward-spiral' ),
		'remove_featured_image' => __( 'Remove featured image', 'upward-spiral' ),
		'use_featured_image'    => __( 'Use as featured image', 'upward-spiral' ),
		'insert_into_item'      => __( 'Insert into item', 'upward-spiral' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'upward-spiral' ),
		'items_list'            => __( 'Items list', 'upward-spiral' ),
		'items_list_navigation' => __( 'Items list navigation', 'upward-spiral' ),
		'filter_items_list'     => __( 'Filter items list', 'upward-spiral' ),
	);
	$rewrite = array(
		'slug'                  => 'testimonial',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Testimonial', 'upward-spiral' ),
		'description'           => __( 'Testimonial information page.', 'upward-spiral' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 70,
		'menu_icon'             => 'dashicons-format-quote',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'testimonials',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'testimonials', $args );

}
add_action( 'init', 'testimonial_post_type', 0 );


function testimonials_add_meta_boxes( $post ){
	add_meta_box( 'testimonials_meta_box', __( 'Author Details', 'upward-spiral' ), 'testimonials_build_meta_box', 'testimonials', 'normal', 'high' );
}
add_action( 'add_meta_boxes_testimonials', 'testimonials_add_meta_boxes' );

function testimonials_build_meta_box( $post ){

  // form nonce
  wp_nonce_field( basename( __FILE__ ), 'testimonials_meta_box_nonce' );

  // check for current value of fields
  $current_author_name      = get_post_meta( $post->ID, '_testimonial_author_name', true );
  $current_author_title     = get_post_meta( $post->ID, '_testimonial_author_title', true );
  $current_author_company   = get_post_meta( $post->ID, '_testimonial_author_company', true );
  $current_author_location  = get_post_meta( $post->ID, '_testimonial_author_location', true );

  ?>
  <p>
    <label for="_testimonial_author_name"><strong><?php echo __( 'Author Name', 'upward-spiral' ); ?></strong></label><br />
    <input class="widefat" type="text" name="_testimonial_author_name" value="<?php echo $current_author_name; ?>" />
  </p>
  <p>
    <label for="_testimonial_author_title"><strong><?php echo __( 'Author Title', 'upward-spiral' ); ?></strong></label><br />
    <input class="widefat" type="text" name="_testimonial_author_title" value="<?php echo $current_author_title; ?>" />
  </p>
  <p>
    <label for="_testimonial_author_company"><strong><?php echo __( 'Author Company', 'upward-spiral' ); ?></strong></label><br />
    <input class="widefat" type="text" name="_testimonial_author_company" value="<?php echo $current_author_company; ?>" />
  </p>
  <p>
    <label for="_testimonial_author_location"><strong><?php echo __( 'Author Location', 'upward-spiral' ); ?></strong></label><br />
    <input class="widefat" type="text" name="_testimonial_author_location" value="<?php echo $current_author_location; ?>" />
  </p>
  <?php
}

function testimonials_save_meta_boxes_data( $post_id ){
	// check the nonce
  if ( !isset( $_POST['testimonials_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['testimonials_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}

  // return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}

  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}

  // If fields is change/set, update

  if ( isset( $_REQUEST['_testimonial_author_name'] ) ) {
		update_post_meta( $post_id, '_testimonial_author_name', sanitize_text_field( $_POST['_testimonial_author_name'] ) );
	}

  if ( isset( $_REQUEST['_testimonial_author_title'] ) ) {
		update_post_meta( $post_id, '_testimonial_author_title', sanitize_text_field( $_POST['_testimonial_author_title'] ) );
	}

  if ( isset( $_REQUEST['_testimonial_author_company'] ) ) {
    update_post_meta( $post_id, '_testimonial_author_company', sanitize_text_field( $_POST['_testimonial_author_company'] ) );
  }

  if ( isset( $_REQUEST['_testimonial_author_location'] ) ) {
    update_post_meta( $post_id, '_testimonial_author_location', sanitize_text_field( $_POST['_testimonial_author_location'] ) );
  }
}
add_action( 'save_post_testimonials', 'testimonials_save_meta_boxes_data', 10, 2 );
