<?php

define('UPWARD_SPIRAL_SETTINGS_FIELD','upward-spiral-settings');

class UPWARD_SPIRAL_THEME_SETTINGS extends Genesis_Admin_Boxes {

	function __construct() {

		$page_id = 'upward-spiral';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => 'Upward Spiral Settings',
				'menu_title'  => 'Upward Spiral Settings',
				)
			);

		$page_ops = array(
			'screen_icon'       => 'options-general',
			'save_button_text'  => 'Save Settings',
			'reset_button_text' => 'Reset Settings',
			'save_notice_text'  => 'Your Settings has been saved.',
			'reset_notice_text' => 'Your Settings has been reset.',
			);

		$settings_field = 'upward-spiral-settings';

		$default_settings = array(
			'upward-spiral-facebook' => '',
			'upward-spiral-twitter' => '',
			'upward-spiral-phone' => '',
			'upward-spiral-appointment' => '',
			);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}

	// SANITIZATION
	function sanitization_filters() {
		genesis_add_option_filter( 'safe_html', $this->settings_field, array(
			'upward-spiral-facebook',
			'upward-spiral-twitter',
			'upward-spiral-phone',
			'upward-spiral-appointment'
			)
		);
	}

	// HELP TAB
	function help() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id'      => 'upward-spiral-help',
			'title'   => 'upward-spiral Theme Help',
			'content' => '<p>No help option for Compassionate Theme.</p><p>- Jayson Antipuesto</p>',
			) );
	}

	// METABOXES
	function metaboxes() {
		add_meta_box('company_metabox', 'Company Details', array( $this, 'company_metabox' ), $this->pagehook, 'main', 'high');
		// add_meta_box('social_metabox', 'Social Media Options', array( $this, 'social_metabox' ), $this->pagehook, 'main', 'high');
	}

	// SOCIAL METABOX CALLBACK
	function social_metabox() { ?>

		<p><?php _e( 'Facebook URL:', 'upward-spiral' );?><br />
		<input type="text" name="<?php echo UPWARD_SPIRAL_SETTINGS_FIELD; ?>[upward-spiral-facebook]" value="<?php echo esc_url( genesis_get_option('upward-spiral-facebook', 'upward-spiral-settings') ); ?>" size="50" class="widefat" /> </p>

		<p><?php _e( 'Twitter URL:', 'upward-spiral' );?><br />
		<input type="text" name="<?php echo UPWARD_SPIRAL_SETTINGS_FIELD; ?>[upward-spiral-twitter]" value="<?php echo esc_url( genesis_get_option('upward-spiral-twitter', 'upward-spiral-settings') ); ?>" size="50" class="widefat" /> </p>

	<?php }

	// COMPANY METABOX CALLBACK
	function company_metabox() { ?>

		<p><?php _e( 'Company Phone #:', 'upward-spiral' );?><br />
		<input type="text" name="<?php echo UPWARD_SPIRAL_SETTINGS_FIELD; ?>[upward-spiral-phone]" value="<?php echo strip_tags( genesis_get_option('upward-spiral-phone', 'upward-spiral-settings') ); ?>" size="50" class="widefat" /> </p>

		<p><?php _e( 'Set Contact URL:', 'upward-spiral' );?><br />
		<input type="text" name="<?php echo UPWARD_SPIRAL_SETTINGS_FIELD; ?>[upward-spiral-appointment]" value="<?php echo esc_url( genesis_get_option('upward-spiral-appointment', 'upward-spiral-settings') ); ?>" size="50" class="widefat" /> </p>
	<?php }


}

function upward_spiral_theme_settings() {
	global $_child_theme_settings;
	$_child_theme_settings = new UPWARD_SPIRAL_THEME_SETTINGS;
}
add_action( 'genesis_admin_menu', 'upward_spiral_theme_settings' );
