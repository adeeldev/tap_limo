<?php
/**
 * Plugin Name: OffTheShelf Headline
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a headline.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Headline_Widget' ) ) {
	class OffTheShelf_Headline_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Headline', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a headline.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-headline' )
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Headline Style', 'offtheshelf' ),
					'id'       => 'style',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Regular headline', 'offtheshelf' ),
							'value' => 'regular'
						),
						array(
							'name'  => esc_html__( 'Section title', 'offtheshelf' ),
							'value' => 'section'
						)
					),
					'std'      => 'regular',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Headline', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Headline Type', 'offtheshelf' ),
					'id'       => 'type',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => 'H1',
							'value' => 'h1'
						),
						array(
							'name'  => 'H2',
							'value' => 'h2'
						),
						array(
							'name'  => 'H3',
							'value' => 'h3'
						),
						array(
							'name'  => 'H4',
							'value' => 'h4'
						),
						array(
							'name'  => 'H5',
							'value' => 'h5'
						),
						array(
							'name'  => 'H6',
							'value' => 'h6'
						),
					),
					'std'      => 'h1',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Sub Headline', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the sub headline title.', 'offtheshelf' ),
					'id'       => 'sub_headline_title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Sub Headline Type', 'offtheshelf' ),
					'id'       => 'sub_headline_type',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => 'H1',
							'value' => 'h1'
						),
						array(
							'name'  => 'H2',
							'value' => 'h2'
						),
						array(
							'name'  => 'H3',
							'value' => 'h3'
						),
						array(
							'name'  => 'H4',
							'value' => 'h4'
						),
						array(
							'name'  => 'H5',
							'value' => 'h5'
						),
						array(
							'name'  => 'H6',
							'value' => 'h6'
						),
					),
					'std'      => 'h2',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),


			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			/*
			 * headline
			 */
			$headline_type  = offtheshelf_array_option( 'type', $instance, 'h2' );
			$headline_title = offtheshelf_array_option( 'title', $instance, '' );

			if ( ! empty( $headline_title ) ) {
				if ( offtheshelf_array_option( 'style', $instance, 'section' ) == "section" ) {
					$h       = '<' . esc_html( $headline_type ) . ' class="section-title">';
					$h_close = '</' . esc_html( $headline_type ) . '>';
					$out .= $h . '<span>' . esc_html( $headline_title ) . '</span>' . $h_close;
				} elseif ( $instance['style'] == "other" ) {
					// reserved
				} else {
					$h       = '<' . esc_html( $headline_type ) . ' class="regular-title">';
					$h_close = '</' . esc_html( $headline_type ) . '>';
					$out .= $h . esc_html( $headline_title ) . $h_close;
				}
			}

			/*
			 * sub headline
			 */

			$sub_headline_type  = offtheshelf_array_option( 'sub_headline_type', $instance, 'h3' );
			$sub_headline_title = offtheshelf_array_option( 'sub_headline_title', $instance, '' );

			if ( ! empty ( $sub_headline_title ) ) {
				$h       = '<' . esc_html( $sub_headline_type ) . ' class="' . esc_attr( offtheshelf_array_option( 'style', $instance, 'section' ) ) . '-sub-title">';
				$h_close = '</' . esc_html( $sub_headline_type ) . '>';
				$out .= $h . esc_html( $sub_headline_title ) . $h_close;
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_headline_widget' ) ) {
		function register_offtheshelf_headline_widget() {
			register_widget( 'OffTheShelf_Headline_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_headline_widget', 1 );
	}
}