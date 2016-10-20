<?php
/**
 * Plugin Name: OffTheShelf Divider
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a graphical divider.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Divider_Widget' ) ) {
	class OffTheShelf_Divider_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Divider', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a divider.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-divider' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(

				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select a display style for this divider.', 'offtheshelf' ),
					'id'       => 'style',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'solid', 'offtheshelf' ),
							'value' => 'solid'
						),
						array(
							'name'  => esc_html__( 'dashed', 'offtheshelf' ),
							'value' => 'dashed'
						),
						array(
							'name'  => esc_html__( 'dotted', 'offtheshelf' ),
							'value' => 'dotted'
						),
						array(
							'name'  => esc_html__( 'double', 'offtheshelf' ),
							'value' => 'double'
						)
					),
					'std'      => 'solid',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Alignment', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select how you would like to align this divider.', 'offtheshelf' ),
					'id'       => 'alignment',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Left', 'offtheshelf' ),
							'value' => 'left'
						),
						array(
							'name'  => esc_html__( 'Center', 'offtheshelf' ),
							'value' => 'center'
						),
						array(
							'name'  => esc_html__( 'Right', 'offtheshelf' ),
							'value' => 'right'
						)
					),
					'std'      => 'center',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Height', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a value in pixels.', 'offtheshelf' ),
					'id'       => 'height',
					'type'     => 'text',
					// class, rows, cols
					'class'    => '',
					'std'      => '1',
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Width', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a value X of 100 percent.', 'offtheshelf' ),
					'id'       => 'width',
					'type'     => 'text',
					// class, rows, cols
					'class'    => '',
					'std'      => '100',
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Color', 'offtheshelf' ),
					'id'       => 'color',
					'type'     => 'color',
					'std'      => '#000000',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),


			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$width        = offtheshelf_array_option( 'width', $instance, "100" ) . "%";
			$height       = offtheshelf_array_option( 'height', $instance, "2" ) . "px";
			$color        = offtheshelf_array_option( 'color', $instance, "#000000" );
			$border_style = offtheshelf_array_option( 'style', $instance, "solid" );
			$alignment    = offtheshelf_array_option( 'alignment', $instance, "center" );

			$id    = offtheshelf_get_widget_uid( 'divider' );
			$style = '.divider.' . $id . ' { border-top: ' . $height . ' ' . $border_style . ' ' . $color . '; width: ' . $width . '}';
			offtheshelf_add_custom_style( 'divider', $style );

			$out = $args['before_widget'];
			$out .= '<hr class="divider divider-' . esc_attr( $border_style ) . ' align-' . esc_attr( $alignment ) . ' ' . $id . '">';
			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_divider_widget' ) ) {
		function register_offtheshelf_divider_widget() {
			register_widget( 'OffTheShelf_Divider_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_divider_widget', 1 );
	}
}