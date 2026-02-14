<?php
/**
 * Hannari Theme Customizer
 *
 * @package Hannari
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings and controls
 */
function hannari_customize_register( $wp_customize ) {

	// --- Theme Colors Section ---
	$wp_customize->add_section(
		'hannari_colors',
		array(
			'title'    => __( 'Theme Colors', 'hannari' ),
			'priority' => 30,
		)
	);

	// Color settings: id => [ default, label ]
	$colors = array(
		'hannari_main_color'         => array( '#6bb6ff', __( 'Main Color', 'hannari' ) ),
		'hannari_pastel_color'       => array( '#c8e4ff', __( 'Pastel Color', 'hannari' ) ),
		'hannari_accent_color'       => array( '#ffb36b', __( 'Accent Color', 'hannari' ) ),
		'hannari_link_color'         => array( '#4f96f6', __( 'Link Color', 'hannari' ) ),
		'hannari_header_bg_color'    => array( '#58a9ef', __( 'Header Background', 'hannari' ) ),
		'hannari_header_text_color'  => array( '#ffffff', __( 'Header Text', 'hannari' ) ),
		'hannari_body_bg_color'      => array( '#eaedf2', __( 'Body Background', 'hannari' ) ),
		'hannari_footer_bg_color'    => array( '#e0e4eb', __( 'Footer Background', 'hannari' ) ),
		'hannari_footer_text_color'  => array( '#3c3c3c', __( 'Footer Text', 'hannari' ) ),
		'hannari_widget_title_color' => array( '#6bb6ff', __( 'Widget Title Color', 'hannari' ) ),
		'hannari_widget_title_bg_color' => array( '#c8e4ff', __( 'Widget Title Background', 'hannari' ) ),
		'hannari_totop_color'        => array( '#5ba9f7', __( 'Scroll to Top Color', 'hannari' ) ),
	);

	foreach ( $colors as $id => $args ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $args[0],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$id,
				array(
					'label'   => $args[1],
					'section' => 'hannari_colors',
				)
			)
		);
	}
}
add_action( 'customize_register', 'hannari_customize_register' );

/**
 * Output CSS custom properties from Customizer values
 */
function hannari_customizer_css() {
	$map = array(
		'--color-main'             => 'hannari_main_color',
		'--color-pastel'           => 'hannari_pastel_color',
		'--color-accent'           => 'hannari_accent_color',
		'--color-link'             => 'hannari_link_color',
		'--color-header-bg'        => 'hannari_header_bg_color',
		'--color-header-text'      => 'hannari_header_text_color',
		'--color-body-bg'          => 'hannari_body_bg_color',
		'--color-footer-bg'        => 'hannari_footer_bg_color',
		'--color-footer-text'      => 'hannari_footer_text_color',
		'--color-widget-title'     => 'hannari_widget_title_color',
		'--color-widget-title-bg'  => 'hannari_widget_title_bg_color',
		'--color-totop'            => 'hannari_totop_color',
	);

	$props = '';
	foreach ( $map as $prop => $setting ) {
		$value = get_theme_mod( $setting );
		if ( $value ) {
			$props .= $prop . ':' . esc_attr( $value ) . ';';
		}
	}

	if ( $props ) {
		$css = ':root{' . $props . '}';
		wp_add_inline_style( 'hannari-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'hannari_customizer_css', 20 );
