<?php

add_action( 'customize_register', 'upward_spiral_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function upward_spiral_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'upward_spiral_link_color',
		array(
			'default'           => upward_spiral_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upward_spiral_link_color',
			array(
				'description' => __( 'Change the color of post info links, hover color of linked titles, hover color of menu items, and more.', 'upward-spiral' ),
				'label'       => __( 'Link Color', 'upward-spiral' ),
				'section'     => 'colors',
				'settings'    => 'upward_spiral_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'upward_spiral_accent_color',
		array(
			'default'           => upward_spiral_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'upward_spiral_accent_color',
			array(
				'description' => __( 'Change the default hovers color for button.', 'upward-spiral' ),
				'label'       => __( 'Accent Color', 'upward-spiral' ),
				'section'     => 'colors',
				'settings'    => 'upward_spiral_accent_color',
			)
		)
	);

}
