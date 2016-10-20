<?php
/**
 * Plugin Name: OffTheShelf Contact Form
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a contact form
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'WPCF7_ContactForm' ) ) // this widget is only displayed if Contact Form 7 is installed and active.
{
	return;
}

if ( ! class_exists( 'OffTheShelf_Contact_Widget' ) ) {
	class OffTheShelf_Contact_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Contact Form 7', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a contact form.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-contact-form-7' )

			);

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
					'std'      => esc_html__( 'We will call you back', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => 'strip_tags|esc_attr'
				),
				array(
					'name'      => esc_html__( 'Form', 'offtheshelf' ),
					'desc'      => esc_html__( 'Select the form to be displayed. You can create new forms in Contact Form 7.', 'offtheshelf' ),
					'id'        => 'form',
					'type'      => 'posts',
					'post_type' => 'wpcf7_contact_form',
					'multiple'  => false,
					'std'       => '',
					'validate'  => 'alpha_dash',
					'filter'    => ''
				),
				array(
					'name'     => esc_html__( 'Display as', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select whether you would like form fields to be displayed in rows (stacked) or columns (next to each other). If you opt to display form fields in columns, make sure that all fields fit into the widget container.', 'offtheshelf' ),
					'id'       => 'display_as',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Rows', 'offtheshelf' ),
							'value' => 'rows'
						),
						array(
							'name'  => esc_html__( 'Columns', 'offtheshelf' ),
							'value' => 'columns'
						)
					),
					'std'      => 'rows',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Field Alignment', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select how to align the form fields within the widget container.', 'offtheshelf' ),
					'id'       => 'field_alignment',
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
					'std'      => 'left',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Rounded Corners', 'offtheshelf' ),
					'desc'     => esc_html__( 'Define border radius for form fields in px.', 'offtheshelf' ),
					'id'       => 'border_radius',
					'type'     => 'number',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'numeric',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Hint', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a hint to be displayed below the opt-in form.', 'offtheshelf' ),
					'id'       => 'hint',
					'type'     => 'textarea',
					'rows'     => '3',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => 'esc_textarea'
				),
			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$form = offtheshelf_array_option( 'form', $instance, false );

			$id = 'widget-form' . '-' . $form;


			$wid    = offtheshelf_get_widget_uid( 'cf7' );
			$radius = offtheshelf_array_option( 'border_radius', $instance, 0 );
			if ( $radius > 0 ) {
				$style = '.' . $wid . ' input, .' . $wid . ' textarea  { border-radius:' . $radius . 'px; }';
				offtheshelf_add_custom_style( 'cf7', $style );
			}


			$out = $args['before_widget'];

			if ( offtheshelf_array_option( 'title', $instance, false ) && ! offtheshelf_is_pagebuilder() ) {
				$out .= $args['before_title'];
				$out .= esc_html( $instance['title'] );
				$out .= $args['after_title'];
			}

			if ( $form && $form != 0 ) {
				$display_as = offtheshelf_array_option( 'display_as', $instance, "rows" );
				$alignment  = offtheshelf_array_option( 'field_alignment', $instance, "left" );

				$out .= '<div class="form-cf7 ' . esc_attr( $wid ) . ' cf7-' . esc_attr( $display_as ) . ' cf7-' . esc_attr( $alignment ) . '">';
				$out .= do_shortcode( '[contact-form-7 id="' . $form . '"]' );

				$hint = offtheshelf_array_option( 'hint', $instance, '' );
				if ( ! empty( $hint ) ) {
					$out .= '<p class="hint">' . offtheshelf_esc_html( $hint ) . '</p>';
				}

				$out .= '</div>';
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_contact_widget' ) ) {
		function register_offtheshelf_contact_widget() {
			register_widget( 'OffTheShelf_Contact_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_contact_widget', 1 );
	}
}