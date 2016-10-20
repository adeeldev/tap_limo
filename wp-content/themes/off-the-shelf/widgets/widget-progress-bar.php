<?php
/**
 * Plugin Name: OffTheShelf Progress Bar
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a progress bar.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Progress_Bar_Widget' ) ) {
	class OffTheShelf_Progress_Bar_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Progress Bar', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a progress bar.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-progress-bar' )

			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the headline title.', 'offtheshelf' ),
					'id'       => 'title',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Description', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a description or sub headline.', 'offtheshelf' ),
					'id'       => 'description',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select an icon to be added to this progress bar.', 'offtheshelf' ),
					'id'       => 'icon',
					'type'     => 'fontawesome',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Progress Value', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a value X of 100 percent.', 'offtheshelf' ),
					'id'       => 'progress',
					'type'     => 'text',
					// class, rows, cols
					'class'    => '',
					'std'      => '',
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Bar Color', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select a foreground color for the bar indicating the progress.', 'offtheshelf' ),
					'id'       => 'color_bar',
					'type'     => 'color',
					// class, rows, cols
					'std'      => '#000000',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Link', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter an optional link URL to point this item to.', 'offtheshelf' ),
					'id'       => 'link',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				)

			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			$id    = offtheshelf_get_widget_uid( 'progress-bar' );
			$style = '.' . $id . ' .meter-bar { background-color:' . offtheshelf_array_option( 'color_bar', $instance, '#dd3333' ) . '; width:' . offtheshelf_array_option( 'progress', $instance ) . '%; }';
			offtheshelf_add_custom_style( 'progress-bar', $style );

			if ( offtheshelf_array_option( 'icon', $instance ) ) {
				$has_icon = 'has_icon ';
			} else {
				$has_icon = '';
			}

			$out .= '<div class="progress-bar ' . $has_icon . $id . '">';


			if ( ! empty( $has_icon ) ) {
				$out .= '<div class="icon"><i class="fa fa-2x ' . esc_attr( offtheshelf_array_option( 'icon', $instance ) ) . '"></i></div>';
			}

			$out .= '<div class="progress-bar-content">';

			$title = esc_html( offtheshelf_array_option( 'title', $instance, '' ) );
			$desc  = offtheshelf_esc_html ( offtheshelf_array_option( 'description', $instance, '' ), false, true );
			$link  = offtheshelf_array_option( 'link', $instance, '' );

			if ( ! empty( $title ) ) {
				$out .= '<h4>';
				if ( ! empty( $link ) ) {
					$out .= '<a href="' . esc_url( $link ) . '">';
				}
				$out .= $title;
				if ( ! empty( $link ) ) {
					$out .= '</a>';
				}
				$out .= '</h4>';
			}

			if ( ! empty( $desc ) ) {
				$out .= '<p>' . $desc . '</p>';
			}

			$out .= '<div class="meter">
					<div class="meter-bar"></div>
				</div>
				<div class="progress">' . esc_html( offtheshelf_array_option( 'progress', $instance ) ) . ' <i>' . esc_html__( 'of', 'offtheshelf' ) . '</i> 100 <i>%</i></div>
				</div>
			</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_progress_bar_widget' ) ) {
		function register_offtheshelf_progress_bar_widget() {
			register_widget( 'OffTheShelf_Progress_Bar_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_progress_bar_widget', 1 );
	}
}