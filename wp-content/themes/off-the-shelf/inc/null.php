<?php
/*
 * Replaces function calls with dummy functions to be used if the theme's feature pack plug-in is not installed
 */

if ( ! defined ('OFFTHESHELF_FEATURE_PACK') ) {

	if ( ! function_exists('offtheshelf_banner_wrapper_classes') ) {
		function offtheshelf_banner_wrapper_classes() {
			$classes=array();
			$classes[] = "animated-header";
			if (count($classes) > 0) {
				echo ' class="'.implode(" ", $classes).'"';
			}
		}
	}

	if ( ! function_exists('offtheshelf_banner_data_attrs') ) {
		function offtheshelf_banner_data_attrs() {
			return '';
		}
	}

	if ( ! function_exists('offtheshelf_the_banner') ) {
		function offtheshelf_the_banner() {
			return '';
		}
	}

	if ( ! function_exists('offtheshelf_get_site_title') ) {
		function offtheshelf_get_site_title() {
			return get_bloginfo( 'name' );
		}
	}

	if ( ! function_exists('offtheshelf_get_site_tagline') ) {
		function offtheshelf_get_site_tagline() {
			return get_bloginfo( 'description' );
		}
	}

	if ( ! function_exists('offtheshelf_footer_copyright') ) {
		function offtheshelf_footer_copyright() {
			return '<a href="' . esc_url( __( 'https://wordpress.org/', 'offtheshelf' ) ) . '">' . sprintf( esc_html__( 'Proudly powered by %s', 'offtheshelf' ), 'WordPress' ) . '</a>';
		}
	}

}

