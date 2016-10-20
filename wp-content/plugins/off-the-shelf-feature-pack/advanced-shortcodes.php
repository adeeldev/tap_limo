<?php
/*
 * Provides shortcodes for advanced customization features for the Off the Shelf for WordPress theme.
 */

define('OFFTHESHELF_ADVANCED_SHORTCODES', true);

/*
 * Set up shortcodes
 */
if ( ! function_exists( 'offtheshelf_shortcode_widget' ) ) {
	function offtheshelf_shortcode_widget( $attrs, $content = null ) {
		if ( ! function_exists ( 'offtheshelf_option' ) ) return false;

		global $offtheshelf_custom_widgets;

		if ( isset( $attrs['type'] ) ) {
			$key = trim( strtolower( $attrs['type'] ) );
			if ( isset ( $offtheshelf_custom_widgets[ $key ] ) ) {
				$class = $offtheshelf_custom_widgets[ $key ];
				$args  = array(
					'before_widget' => '<div class="widget ' . $class . '">',
					'after_widget'  => '</div>',
					'before_title'  => null,
					'after_title'   => null
				);

				the_widget( $class, $attrs, $args );
			}
		}
	}
}
add_shortcode( 'offtheshelf_widget', 'offtheshelf_shortcode_widget' );


if ( ! function_exists( 'offtheshelf_shortcode_option' ) ) {
	function offtheshelf_shortcode_option( $attrs, $content = null ) {
		if ( ! function_exists ( 'offtheshelf_option' ) ) return false;

		$action = offtheshelf_array_option( 'action', $attrs, 'echo' );
		$key    = offtheshelf_array_option( 'key', $attrs, false );
		$val    = offtheshelf_array_option( 'val', $attrs, false );

		$output = false;

		if ( $action == 'echo' ) {
			$output = offtheshelf_option( $key );
		} elseif ( $action == 'set' ) {
			if ( $content != null ) {
				$output = $content;
			} else {
				$output = $val;
			}
			offtheshelf_set_option( $key, $output );
		} elseif ( $action == 'add' ) {
			$output = offtheshelf_option( $key );
			if ( $content != null ) {
				$output .= $content;
			} else {
				$output .= $val;
			}
			offtheshelf_set_option( $key, $output );
		} elseif ( $action == 'prepend' ) {
			$output = offtheshelf_option( $key );
			if ( $content != null ) {
				$output = $content . $output;
			} else {
				$output = $val . $output;
			}
			offtheshelf_set_option( $key, $output );
		}

		return $output;
	}
}


if ( ! function_exists( 'offtheshelf_custom_block_shortcode' ) ) {
	function offtheshelf_custom_block_shortcode( $attrs, $content = null ) {
		if ( ! function_exists ( 'offtheshelf_option' ) ) return false;

		global $offtheshelf_custom_blocks;

		extract( shortcode_atts( array(
			'key' => '',
			'val' => ''
		), $attrs ) );

		extract( $attrs );

		$key = trim( strtolower( $key ) );
		$val = trim( $val );

		if ( $val == '' && $content != "" ) {
			$val = $content;
		}

		if ( $val != null ) {
			$offtheshelf_custom_blocks[ $key ] = $val;
		}
	}
}

add_shortcode( 'offtheshelf_option', 'offtheshelf_shortcode_option' );
add_shortcode( 'offtheshelf_custom_block', 'offtheshelf_custom_block_shortcode' );
add_shortcode( 'custom_block', 'offtheshelf_custom_block_shortcode' );

