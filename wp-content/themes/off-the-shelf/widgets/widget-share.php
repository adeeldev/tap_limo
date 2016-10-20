<?php
/**
 * Plugin Name: OffTheShelf Share Icons
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays social sharing icons on blog single views.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Share_Widget' ) ) {
	class OffTheShelf_Share_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Social Sharing', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays sharing links to social networks on single pages.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-social-sharing' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'  => esc_html__( 'Info', 'offtheshelf' ),
					'desc'  => esc_html__( 'Select display options. You can define social icons to be used for this widget through the Theme Options panel.', 'offtheshelf' ),
					'id'    => 'info',
					'value' => '',
					'type'  => 'paragraph'
				),
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Share', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select what style you would like to apply to these social icons.', 'offtheshelf' ),
					'id'       => 'style',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Transparent', 'offtheshelf' ),
							'value' => 'transparent'
						),
						array(
							'name'  => esc_html__( 'White', 'offtheshelf' ),
							'value' => 'white'
						),
						array(
							'name'  => esc_html__( 'Black', 'offtheshelf' ),
							'value' => 'black'
						),
						array(
							'name'  => esc_html__( 'Solid color', 'offtheshelf' ),
							'value' => 'color'
						)
					),
					'std'      => 'transparent',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select what icon size should be used for this widget.', 'offtheshelf' ),
					'id'       => 'icon_size',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Tiny', 'offtheshelf' ),
							'value' => '1'
						),
						array(
							'name'  => esc_html__( 'Small', 'offtheshelf' ),
							'value' => '2'
						),
						array(
							'name'  => esc_html__( 'Medium', 'offtheshelf' ),
							'value' => '3'
						),
						array(
							'name'  => esc_html__( 'Large', 'offtheshelf' ),
							'value' => '4'
						)
					),
					'std'      => '1',
					'validate' => 'numeric',
					'filter'   => ''
				),

			); // fields array


			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {
			$out = $args['before_widget'];

			$id = offtheshelf_get_widget_uid( 'social-share' );

			$title = offtheshelf_array_option( 'title', $instance );
			$style = offtheshelf_array_option( 'style', $instance );
			$size  = offtheshelf_array_option( 'icon_size', $instance );

			if ( ! empty( $title ) ) {
				$out .= '<h3>' . esc_html( $title ) . '</h3>';
			}

			$out .= offtheshelf_share( false, false, $style, $size );

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_share_widget' ) ) {
		function register_offtheshelf_share_widget() {
			register_widget( 'OffTheShelf_Share_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_share_widget', 1 );
	}
}