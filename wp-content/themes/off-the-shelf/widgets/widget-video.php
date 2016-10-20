<?php
/**
 * Plugin Name: OffTheShelf Video
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a map.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Video_Widget' ) ) {
	class OffTheShelf_Video_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Embedded Video', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an embedded video.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-embedded-video' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(

				// Title field
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Video URL or Custom Embed Code', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a plain video URL, or an embed code. If using custom embed codes, make sure you modify it to be responsive.', 'offtheshelf' ),
					'id'       => 'code',
					'type'     => 'textarea',
					'rows'     => '5',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => 'esc_textarea'
				),
				array(
					'name'     => esc_html__( 'Embed Mode', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select which embed mode you would like to use.', 'offtheshelf' ),
					'id'       => 'type',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'oEmbed from plain URL', 'offtheshelf' ),
							'value' => 'embed'
						),
						array(
							'name'  => esc_html__( 'Custom integration code', 'offtheshelf' ),
							'value' => 'custom'
						),
						array(
							'name'  => esc_html__( 'Custom integration code, with responsive wrapper', 'offtheshelf' ),
							'value' => 'custom_wrapper'
						)

					),
					'std'      => 'embed',
					'validate' => 'alpha_dash',
					'filter'   => ''
				)
			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			if ( offtheshelf_array_option( 'title', $instance, false ) && ! offtheshelf_is_pagebuilder() ) {
				$out .= $args['before_title'];
				$out .= esc_html ( $instance['title'] );
				$out .= $args['after_title'];
			}


			$type = offtheshelf_array_option( 'type', $instance, false );

			if ( $type == "custom" ) {
				$out .= offtheshelf_esc_html( html_entity_decode( offtheshelf_array_option( 'code', $instance, '' ) ) );
			} elseif ( $type == "custom_wrapper" ) {
				$out .= '<div class="embed_container">' . offtheshelf_esc_html( html_entity_decode( offtheshelf_array_option( 'code', $instance, '' ) ) ) . '</div>';
			} else {
				$embed = new WP_Embed();
				$out .= $embed->run_shortcode( '[embed]' . offtheshelf_array_option( 'code', $instance, '' ) . '[/embed]' );
			}

			$out .= $args['after_widget'];

			echo $out;

		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_video_widget' ) ) {
		function register_offtheshelf_video_widget() {
			register_widget( 'OffTheShelf_Video_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_video_widget', 1 );
	}
}