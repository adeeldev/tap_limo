<?php
/**
 * Plugin Name: OffTheShelf Gravity Forms Form
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a form created with the Gravity Forms plug-in
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'GFCommon' ) ) // this widget is only displayed if Contact Form 7 is installed and active.
{
	return;
}

if ( ! class_exists( 'OffTheShelf_Gravity_Forms_Widget' ) ) {
	class OffTheShelf_Gravity_Forms_Widget extends SR_Widget {

		function __construct() {

			// configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Gravity Forms', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a Gravity Forms form.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-gravity-forms' )
			);

			// get forms
			$forms = array();
			$gforms = RGFormsModel::get_forms( null, 'title' );
			if ( !empty ($gforms ) ) {
				foreach ($gforms as $form) {
					$forms[] = array (
							'value' => $form->id,
							'name' => $form->title
					);
				}
			}

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
						'type'     => 'select',
						'fields'   => $forms,
						'std'       => '',
						'validate'  => 'alpha_dash',
						'filter'    => ''
				),
				array(
						'name'     => esc_html__( 'Display Title', 'offtheshelf' ),
						'desc' => esc_html__( 'Display the Gravity Forms title.', 'offtheshelf' ),
						'id'       => 'display_title',
						'type'     => 'checkbox',
						'class'    => 'widefat',
						'std'      => 0,
						'validate' => 'alpha_dash',
						'filter'   => ''
				),
				array(
						'name'     => esc_html__( 'Display Description', 'offtheshelf' ),
						'desc' => esc_html__( 'Display the Gravity Forms description.', 'offtheshelf' ),
						'id'       => 'display_description',
						'type'     => 'checkbox',
						'class'    => 'widefat',
						'std'      => 0,
						'validate' => 'alpha_dash',
						'filter'   => ''
				),
				array(
						'name'     => esc_html__( 'Use AJAX', 'offtheshelf' ),
						'desc' => esc_html__( 'Submit forms via AJAX, without leaving the page.', 'offtheshelf' ),
						'id'       => 'ajax',
						'type'     => 'checkbox',
						'class'    => 'widefat',
						'std'      => 0,
						'validate' => 'alpha_dash',
						'filter'   => ''
				),
			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$form = offtheshelf_array_option( 'form', $instance, false );

			$out = $args['before_widget'];

			if ( offtheshelf_array_option( 'title', $instance, false ) && ! offtheshelf_is_pagebuilder() ) {
				$out .= $args['before_title'];
				$out .= esc_html( $instance['title'] );
				$out .= $args['after_title'];
			}

			if ( $form && $form != 0 ) {

				if ( offtheshelf_array_option( 'display_title', $instance, false ) )
					$display_title = ' title="true"';
				else
					$display_title = ' title="false"';

				if ( offtheshelf_array_option( 'display_description', $instance, false ) )
					$display_description = ' description="true"';
				else
					$display_description = ' description="false"';

				if ( offtheshelf_array_option( 'ajax', $instance, false ) )
					$ajax = ' ajax="true"';
				else
					$ajax = ' ajax="false"';

				$out .= do_shortcode( '[gravityform id="' . $form . '"' . $display_title . $display_description . $ajax . ']' );
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_gravity_forms_widget' ) ) {
		function register_offtheshelf_gravity_forms_widget() {
			register_widget( 'OffTheShelf_Gravity_Forms_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_gravity_forms_widget', 1 );
	}
}