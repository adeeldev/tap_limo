<?php
/**
 * Plugin Name: OffTheShelf Slider
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a featured testimonial block.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Slider_Widget' ) ) {
	class OffTheShelf_Slider_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Image Slider', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an image slider.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-image-slider' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Items', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select items to be displayed in this slider.', 'offtheshelf' ),
					'id'       => 'items',
					'type'     => 'gallery',
					'class'    => '',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Slider Options', 'offtheshelf' ),
					'id'       => 'slider_options',
					'type'     => 'slider',
					'std'      => array(
						'controls'      => true,
						'pips'          => true,
						'transition'    => 'fade',
						'pauseonhover'  => null,
						'pauseonaction' => true,
						'randomize'     => null,
						'speed'         => '7000'
					),
					'validate' => false,
					'filter'   => false
				),

			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$id = offtheshelf_get_widget_uid( 'slider' );

			$add_classes = "";
			$images      = explode( ",", trim( offtheshelf_array_option( 'items', $instance ) ) );
			$out         = $args['before_widget'];

			if ( is_array( $images ) ) {
				$slider_options = offtheshelf_slider_options( offtheshelf_array_option( 'slider_options', $instance, false ) );
				$out .= '<div class="flexslider' . $slider_options['classes'] . '"' . $slider_options['data'] . '><ul class="slides">';
				foreach ( $images as $id ) {
					if ( $image = wp_get_attachment_image( intval( $id ), "full" ) ) {
						$out .= '<li>' . $image . '</li>';
					}
				}
				$out .= '</ul></div>';
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_slider_widget' ) ) {
		function register_offtheshelf_slider_widget() {
			if ( basename( $_SERVER['PHP_SELF'], '.php' ) != "widgets" ) {
				register_widget( 'OffTheShelf_Slider_Widget' );
			}
		}
		add_action( 'widgets_init', 'register_offtheshelf_slider_widget', 1 );
	}
}