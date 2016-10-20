<?php
/**
 * Plugin Name: OffTheShelf Icon
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays an icon.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Icon_Widget' ) ) {
	class OffTheShelf_Icon_Widget extends SR_Widget {

		function __construct() {
			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Icon', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an icon.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-icon' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon.', 'offtheshelf' ),
					'id'       => 'icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Color', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select a icon color.', 'offtheshelf' ),
					'id'       => 'icon_color',
					'type'     => 'color',
					// class, rows, cols
					'std'      => '#000000',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select the size for the icon you would like to display.', 'offtheshelf' ),
					'id'       => 'icon_size',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => 'Tiny',
							'value' => '1x'
						),
						array(
							'name'  => 'Small',
							'value' => '2x'
						),
						array(
							'name'  => 'Medium',
							'value' => '3x'
						),
						array(
							'name'  => 'Large',
							'value' => '4x'
						),
						array(
							'name'  => 'Extra Large',
							'value' => '5x'
						)
					),
					'std'      => '4x',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$is_pagebuilder = offtheshelf_is_pagebuilder( $args );
			$id             = offtheshelf_get_widget_uid( 'icon' );

			$add_classes = "";
			$out         = $args['before_widget'];

			$icon_color = offtheshelf_array_option( 'icon_color', $instance, '#000000' );
			if ( ! empty( $icon_color ) ) {
				$style = '.' . $id . ' { color:' . $icon_color . '; }';
				offtheshelf_add_custom_style( 'icon', $style );
			}

			$icon_size = offtheshelf_array_option( 'icon_size', $instance, '4x' );

			$out .= '<i class="' . $id . ' fa ' . esc_attr( $instance['icon'] ) . ' fa-' . esc_attr( $icon_size ) . '"></i>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_icon_widget' ) ) {
		function register_offtheshelf_icon_widget() {
			register_widget( 'OffTheShelf_Icon_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_icon_widget', 1 );
	}
}