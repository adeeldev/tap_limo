<?php
/**
 * Plugin Name: OffTheShelf Payment Icons
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays payment icons.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Payment_Icons_Widget' ) ) {
	class OffTheShelf_Payment_Icons_Widget extends SR_Widget {

		public $icons;

		function __construct() {

			$this->icons = array(
				'2checkout'     => esc_html__( '2Checkout', 'offtheshelf' ),
				'amazon'        => esc_html__( 'Amazon', 'offtheshelf' ),
				'amex'          => esc_html__( 'American Express', 'offtheshelf' ),
				'bitcoin'       => esc_html__( 'Bitcoin', 'offtheshelf' ),
				'cirrus'        => esc_html__( 'Cirrus', 'offtheshelf' ),
				'credit-card'   => esc_html__( 'Credit Card (Generic)', 'offtheshelf' ),
				'discover'      => esc_html__( 'Discover', 'offtheshelf' ),
				'ebay'          => esc_html__( 'eBay', 'offtheshelf' ),
				'google-wallet' => esc_html__( 'Google Wallet', 'offtheshelf' ),
				'maestro'       => esc_html__( 'Maestro', 'offtheshelf' ),
				'mastercard'    => esc_html__( 'MasterCard', 'offtheshelf' ),
				'paypal'        => esc_html__( 'PayPal', 'offtheshelf' ),
				'skrill'        => esc_html__( 'Skrill', 'offtheshelf' ),
				'solo'          => esc_html__( 'Solo', 'offtheshelf' ),
				'square-up'     => esc_html__( 'Square', 'offtheshelf' ),
				'visa'          => esc_html__( 'Visa', 'offtheshelf' ),
				'wu'            => esc_html__( 'Western Union', 'offtheshelf' ),
			);


			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Payment Icons', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a set of payment icons.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-payment-icons' )
			);

			// Tab groups
			$args['groups'] = array(
				'general'  => esc_html__( 'General', 'offtheshelf' ),
				'services' => esc_html__( 'Services', 'offtheshelf' ),
			);


			// Configure the widget fields
			// fields array
			$args['fields'] = array(
				array(
					'name'     => esc_html__( 'Title', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter the widget title.', 'offtheshelf' ),
					'id'       => 'title',
					'group'    => 'general',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => esc_html__( 'Accepted Payment Methods', 'offtheshelf' ),
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select which style to use for the payment icons.', 'offtheshelf' ),
					'id'       => 'style',
					'group'    => 'general',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Full Color', 'offtheshelf' ),
							'value' => 'color'
						),
						array(
							'name'  => esc_html__( 'Greyscale', 'offtheshelf' ),
							'value' => 'grey'
						),
					),
					'std'      => 'color',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Icon Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select which size to use for these payment icons.', 'offtheshelf' ),
					'id'       => 'size',
					'group'    => 'general',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Small', 'offtheshelf' ),
							'value' => 'small'
						),
						array(
							'name'  => esc_html__( 'Medium', 'offtheshelf' ),
							'value' => 'medium'
						),
						array(
							'name'  => esc_html__( 'Large', 'offtheshelf' ),
							'value' => 'large'
						),
					),
					'std'      => 'medium',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Hint or Notice', 'offtheshelf' ),
					'desc'     => esc_html__( 'Optional hint to be displayed below the icons.', 'offtheshelf' ),
					'id'       => 'hint',
					'group'    => 'general',
					'type'     => 'textarea',
					'rows'     => '3',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => 'esc_textarea'
				),
				array(
					'name'     => esc_html__( 'Payment Icons', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select payment icons to display.', 'offtheshelf' ),
					'id'       => 'icons',
					'group'    => 'services',
					'type'     => 'checkbox_list',
					'sortable' => false,
					'fields'   => $this->icons,
					'std'      => array(),
					'validate' => null,
					'filter'   => ''
				),

			); // fields array

			$this->create_widget( $args );
		}

		// Output function
		function widget( $args, $instance ) {

			$add_classes = "";
			$out         = $args['before_widget'];

			$title = offtheshelf_array_option( 'title', $instance, false );
			if ( $title && ! offtheshelf_is_pagebuilder( $args ) ) {
				$out .= $args['before_title'];
				$out .= esc_html( $title );
				$out .= $args['after_title'];
			}


			$icons = $title = offtheshelf_array_option( 'icons', $instance, false );
			$id    = offtheshelf_get_widget_uid( 'payment-icons' );

			$style = offtheshelf_array_option( 'style', $instance, 'color' );
			$size  = offtheshelf_array_option( 'size', $instance, 'medium' );

			$suffix = '';
			if ( $style == 'grey' ) {
				$suffix = '_bw';
			}

			if ( is_array( $icons ) ) {
				$out .= '<ul id="' . $id . '" class="payment-icons-list payment-icons-size-' . $size . '">';

				foreach ( $icons as $icon ) {
					if ( ! empty( $this->icons[ $icon ] ) ) {
						$out .= '<li class="payment-' . $icon . '">';
						$out .= '<img src="' . esc_url( get_template_directory_uri() . '/images/payment/' . $icon . $suffix . '.png' ) . '" alt="' . esc_attr( $this->icons[ $icon ] ) . '" title="' . esc_attr( $this->icons[ $icon ] ) . '">';
						$out .= '</li>' . "\n";
					}
				}

				$out .= '</ul>';
			}

			$hint = offtheshelf_array_option( 'hint', $instance, '' );
			if ( trim( $hint ) != "" ) {
				$out .= '<p class="hint">' . offtheshelf_esc_html( $hint, false, true ) . '</p>';
			}

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_payment_icons_widget' ) ) {
		function register_offtheshelf_payment_icons_widget() {
			register_widget( 'OffTheShelf_Payment_Icons_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_payment_icons_widget', 1 );
	}
}