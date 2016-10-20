<?php
/**
 * Plugin Name: OffTheShelf Social Icons
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a progress bar.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Social_Icons_Widget' ) ) {
	class OffTheShelf_Social_Icons_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Social Icons', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays social profile links with icons.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-social-icons' )
			);


			// Configure the widget fields
			// fields array
			$args['fields'] = array(
				array(
					'name'  => esc_html__( 'Info', 'offtheshelf' ),
					'desc'  => esc_html__( 'Select display options. You can define social icons to be used for this widget through the profile.', 'offtheshelf' ),
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
					'std'      => esc_html__( 'Follow us', 'offtheshelf' ),
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
					'std'      => '3',
					'validate' => 'numeric',
					'filter'   => ''
				),
			); // fields array


			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			$id = offtheshelf_get_widget_uid( 'social-icon' );

			$icon_size = offtheshelf_array_option( 'icon_size', $instance, '3' );

			$out .= '<div class="social-widget style-' . offtheshelf_array_option( 'style', $instance, 'transparent' ) . ' icon-size-' . $icon_size . '">';

			$title = offtheshelf_array_option( 'title', $instance );
			if ( ! empty( $title ) ) {
				$out .= '<h3 class="widget-title">' . esc_html( $title ) . '</h3>';
			}

			$social_icons = offtheshelf_option( 'social_media_profiles' );
			if ( is_serialized( $social_icons ) ) {
				$services = unserialize( $social_icons );
				if ( is_array( $services ) ) {
					$out .= '<ul>';
					$count = 1;
					foreach ( $services as $service ) {
						if ( offtheshelf_array_option( 'show_in_widget', $service, false ) ) {

							$link_title = offtheshelf_array_option( 'title', $service, '' );
							$link       = offtheshelf_array_option( 'link', $service, '#' );
							$icon       = offtheshelf_array_option( 'icon', $service, 'fa-star' );

							$out .= '<li><a href="' . esc_url( $link ) . '" class="social-icon-' . $count . '" title="' . esc_attr( $link_title ) . '" rel="me"><i class="fa ' . $icon . ' fa-' . $icon_size . 'x"></i></a></li>';

							$count ++;
						}
					}
					$out .= '</ul>';
				}
			}

			$out .= '</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_social_icons_widget' ) ) {
		function register_offtheshelf_social_icons_widget() {
			register_widget( 'OffTheShelf_Social_Icons_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_social_icons_widget', 1 );
	}
}