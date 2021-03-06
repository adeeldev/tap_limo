<?php
/**
 * Plugin Name: OffTheShelf Pricing Block
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a product comparison/pricing block
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Pricing_Block_Widget' ) ) {
	class OffTheShelf_Pricing_Block_Widget extends SR_Widget {

		function __construct() {

			// Get available button styles from options
			$styles      = array();
			$styles_temp = offtheshelf_option( 'global_button_styles' );
			$std_style   = '';
			if ( is_array( $styles_temp ) && count( $styles_temp ) > 0 ) {
				foreach ( $styles_temp as $style ) {
					if ( $style['name'] == '' ) {
						$name = $style['uid'];
					} else {
						$name = $style['name'];
					}
					$styles[] = array(
							'name'  => $name,
							'value' => $style['uid']
					);
				}
				$std_style = $styles[0]['value'];
			}


			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Pricing Block', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays a pricing table element.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-pricing-block' )
			);

			// Tab groups
			$args['groups'] = array(
					'description' => esc_html__( 'Description', 'offtheshelf' ),
					'price'       => esc_html__( 'Price', 'offtheshelf' ),
					'action'      => esc_html__( 'Button', 'offtheshelf' ),
					'badge'       => esc_html__( 'Badge', 'offtheshelf' ),
					'design'      => esc_html__( 'Design', 'offtheshelf' )
			);


			// Configure the widget fields

			// fields array
			$args['fields'] = array(
					array(
							'name'     => esc_html__( 'Title', 'offtheshelf' ),
							'desc'     => esc_html__( 'Package or product title.', 'offtheshelf' ),
							'id'       => 'title',
							'group'    => 'description',
							'type'     => 'text',
							// class, rows, cols
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Sub Title', 'offtheshelf' ),
							'desc'     => esc_html__( 'Sub title, or additional package description.', 'offtheshelf' ),
							'id'       => 'subtitle',
							'group'    => 'description',
							'type'     => 'text',
							// class, rows, cols
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Featured Package', 'offtheshelf' ),
							'desc'     => esc_html__( 'Select, whether this item should be highlighted.', 'offtheshelf' ),
							'id'       => 'featured',
							'group'    => 'description',
							'type'     => 'checkbox',
							'class'    => 'widefat',
							'std'      => 0,
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Description or Features', 'offtheshelf' ),
							'desc'     => esc_html__( 'One feature per line, or plain text product description.', 'offtheshelf' ),
							'id'       => 'description',
							'group'    => 'description',
							'type'     => 'textarea',
							// class, rows, cols
							'rows'     => 5,
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Description Mode', 'offtheshelf' ),
							'desc'     => esc_html__( 'Select how you would like the widget to handle the description field.', 'offtheshelf' ),
							'id'       => 'description_mode',
							'group'    => 'description',
							'type'     => 'select',
							'fields'   => array(
									array(
											'name'  => 'List of features, one per line',
											'value' => 'features'
									),
									array(
											'name'  => 'Full text description',
											'value' => 'description'
									)
							),
							'std'      => 'features',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					/*
					 * Price
					 */
					array(
							'name'     => esc_html__( 'Currency Symbol', 'offtheshelf' ),
							'desc'     => esc_html__( 'Define the currency symbol, e.g. $ or USD.', 'offtheshelf' ),
							'id'       => 'currency_symbol',
							'group'    => 'price',
							'type'     => 'text',
							'class'    => 'widefat',
							'std'      => esc_html__( '$', 'offtheshelf' ),
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Currency Symbol Location', 'offtheshelf' ),
							'desc'     => esc_html__( 'Select where you would like the currency symbol to be displayed.', 'offtheshelf' ),
							'id'       => 'currency_position',
							'group'    => 'price',
							'type'     => 'select',
							'fields'   => array(
									array(
											'name'  => esc_html__( 'Before price', 'offtheshelf' ),
											'value' => 'before'
									),
									array(
											'name'  => esc_html__( 'After price', 'offtheshelf' ),
											'value' => 'after'
									)
							),
							'std'      => 'before',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Price', 'offtheshelf' ),
							'desc'     => esc_html__( 'Define the price for this package.', 'offtheshelf' ),
							'id'       => 'price',
							'group'    => 'price',
							'type'     => 'text',
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'numeric',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Background Color', 'offtheshelf' ),
							'id'       => 'price_background_color',
							'group'    => 'price',
							'type'     => 'color',
							'std'      => '#FFFFFF',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Text Color', 'offtheshelf' ),
							'id'       => 'price_text_color',
							'group'    => 'price',
							'type'     => 'color',
							'std'      => '#000000',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					/*
					 * Call to Action
					 */
					array(
							'name'     => esc_html__( 'Button Style', 'offtheshelf' ),
							'desc'     => esc_html__( 'You can create and edit button styles via the theme\'s options panel.', 'offtheshelf' ),
							'id'       => 'button_style',
							'group'    => 'action',
							'type'     => 'select',
							'fields'   => $styles,
							'std'      => $std_style,
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Button Caption', 'offtheshelf' ),
							'desc'     => esc_html__( 'Define a caption for the call to action button.', 'offtheshelf' ),
							'id'       => 'button_caption',
							'group'    => 'action',
							'type'     => 'text',
							'class'    => 'widefat',
							'std'      => esc_html__( 'Buy Now', 'offtheshelf' ),
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Link URL', 'offtheshelf' ),
							'desc'     => esc_html__( 'Define a link to point this package to.', 'offtheshelf' ),
							'id'       => 'button_link',
							'group'    => 'action',
							'type'     => 'text',
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Open Link in New Window', 'offtheshelf' ),
							'desc'     => esc_html__( 'Select, whether this link should be opened in a new window.', 'offtheshelf' ),
							'id'       => 'link_target',
							'group'    => 'action',
							'type'     => 'checkbox',
							'class'    => 'widefat',
							'std'      => 0,
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Add "nofollow" attribute to link.', 'offtheshelf' ),
							'desc'     => esc_html__( 'Instruct search engines not to follow this link.', 'offtheshelf' ),
							'id'       => 'nofollow',
							'group'    => 'action',
							'type'     => 'checkbox',
							'class'    => 'widefat',
							'std'      => 0,
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'      => esc_html__( 'Open Modal Window', 'offtheshelf' ),
							'desc'      => esc_html__( 'Optional modal window to open instead of using a link. The feature pack plug-in is required.', 'offtheshelf' ),
							'id'        => 'modal',
							'group'     => 'action',
							'type'      => 'posts',
							'post_type' => 'modal',
							'std'       => 0,
							'validate'  => 'alpha_dash',
							'filter'    => ''
					),
					/*
					 * Badge
					 */
					array(
							'name'     => esc_html__( 'Title', 'offtheshelf' ),
							'desc'     => esc_html__( 'This is the actual text shown on the badge', 'offtheshelf' ),
							'id'       => 'badge_title',
							'group'    => 'badge',
							'type'     => 'text',
							// class, rows, cols
							'class'    => 'widefat',
							'std'      => '',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Background Color', 'offtheshelf' ),
							'id'       => 'badge_background_color',
							'group'    => 'badge',
							'type'     => 'color',
							'std'      => '#000000',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Text Color', 'offtheshelf' ),
							'id'       => 'badge_text_color',
							'group'    => 'badge',
							'type'     => 'color',
							'std'      => '#FFFFFF',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					/*
					 * Design
					 */
					array(
							'name'     => esc_html__( 'Background Color', 'offtheshelf' ),
							'id'       => 'block_background_color',
							'group'    => 'design',
							'type'     => 'color',
							'std'      => '#FFFFFF',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'     => esc_html__( 'Text Color', 'offtheshelf' ),
							'id'       => 'block_text_color',
							'group'    => 'design',
							'type'     => 'color',
							'std'      => '#000000',
							'validate' => 'alpha_dash',
							'filter'   => ''
					),
					array(
							'name'           => esc_html__( 'Add Border', 'offtheshelf' ),
							'desc'           => esc_html__( 'Select, whether you would like to add a border to this block.', 'offtheshelf' ),
							'id'             => 'block_border',
							'group-selector' => true,
							'group'          => 'design',
							'type'           => 'checkbox',
							'class'          => 'widefat',
							'std'            => 0,
							'validate' => 'alpha_dash',
							'filter'         => ''
					),
					array(
							'name'        => esc_html__( 'Border Color', 'offtheshelf' ),
							'id'          => 'block_border_color',
							'is-group'    => 'block_border',
							'group-value' => array( 'checked' ),
							'group'       => 'design',
							'type'        => 'color',
							'std'         => '#FFFFFF',
							'validate'    => 'alpha_dash',
							'filter'      => ''
					),
					array(
							'name'     => esc_html__( 'Add Drop Shadow', 'offtheshelf' ),
							'desc'     => esc_html__( 'Select, whether you would like to add a drop shadow to this block.', 'offtheshelf' ),
							'id'       => 'block_shadow',
							'group'    => 'design',
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
			$id             = offtheshelf_get_widget_uid( 'pricing-block' );
			$is_pagebuilder = offtheshelf_is_pagebuilder( $args );

			$add_classes = "";
			$out         = $args['before_widget'];

			if ( $instance['currency_position'] == "before" ) {
				$before_price = '<span>' . $instance['currency_symbol'] . '</span>';
				$after_price  = '';
			} else {
				$before_price = '';
				$after_price  = '<span>' . $instance['currency_symbol'] . '</span>';
			}

			if ( isset( $instance['featured'] ) && $instance['featured'] == 1 ) {
				$featured_class = ' featured';
			} else {
				$featured_class = '';
			}

			$style = ''; // init custom styles


			// design
			$block_text_color       = offtheshelf_array_option( 'block_text_color', $instance, '#000000' );
			$block_background_color = offtheshelf_array_option( 'block_background_color', $instance, '#ffffff' );
			$block_border           = offtheshelf_array_option( 'block_border', $instance, false );
			$block_border_color     = offtheshelf_array_option( 'block_border_color', $instance, '#000000' );
			$block_shadow           = offtheshelf_array_option( 'block_shadow', $instance, false );

			$style = '.' . $id . '  {';

			$style .= 'background:' . $block_background_color . '; color:' . $block_text_color . ';';

			if ( $block_border ) {
				$style .= 'border: 1px solid ' . $block_border_color . ';';
			}
			$style .= '}';

			$style .= '.' . $id . ' .pricing_header h4 { color: ' . $block_text_color . ' }';


			if ( $block_shadow ) {
				$add_classes .= ' has-shadow';
			}


			// badge
			$badge_text             = esc_html( offtheshelf_array_option( 'badge_title', $instance, '' ) );
			$badge_color_text       = offtheshelf_array_option( 'badge_text_color', $instance, '#ffffff' );
			$badge_color_background = offtheshelf_array_option( 'badge_background_color', $instance, '#000000' );


			$badge = '';
			if ( ! empty( $badge_text ) ) {
				$featured_class .= ' has-badge';
				$badge = '<div class="badge">' . esc_html( $badge_text ) . '</div>';
				$style .= '.' . $id . ' .badge { background:' . $badge_color_background . '; color:' . $badge_color_text . '; }';
			}

			$price_color_text       = offtheshelf_array_option( 'price_text_color', $instance, '#000000' );
			$price_color_background = offtheshelf_array_option( 'price_background_color', $instance, '#ffffff' );
			$style .= '.' . $id . ' .pricing { background:' . $price_color_background . '; color:' . $price_color_text . '; }';

			if ( ! empty( $style ) ) {
				offtheshelf_add_custom_style( 'pricing-block', $style );
			}


			$out .= '<div class="pricing_block ' . $id . $featured_class . $add_classes . '">';

			$out .= $badge;

			$out .= '<div class="pricing_header">
			<h4>' . offtheshelf_esc_html( $instance['title'], false, true ) . '</h4>
			</div>
			<div class="pricing currency_' . $instance['currency_position'] . '">
			<p class="pricing-box-price">' . $before_price . offtheshelf_esc_html( $instance['price'], false, true ) . $after_price . '</p>';

			if ( isset( $instance['subtitle'] ) && $instance['subtitle'] != "" ) {
				$out .= '<p class="price_sub">' . offtheshelf_esc_html( $instance['subtitle'], false, true ) . '</p>';
			}

			$out .= '</div>';


			if ( $instance['description_mode'] == "features" ) {
				$out .= "<ul>\n";
				$items = explode( "\n", $instance['description'] );
				if ( is_array( $items ) ) {
					$count       = 1;
					$items_count = count( $items );
					$last        = "";
					foreach ( $items as $item ) {
						if ( $count == $items_count ) {
							$last = ' class="last"';
						}
						$out .= '<li' . $last . '>' . offtheshelf_esc_html( offtheshelf_render_content( trim( $item ), 'inline-text' ), false, true ) . '</li>' . "\n";
						$count ++;
					}
				}
				$out .= "</ul>\n";
			} else {
				$out .= '<p class="description">' . offtheshelf_esc_html( $instance['description'], false, true ) . '</p>' . "\n";
			}

			$link      = esc_url( offtheshelf_array_option( 'button_link', $instance, false ) );
			$modal     = offtheshelf_array_option( 'modal', $instance, false );
			$link_data = '';

			if (defined('OFFTHESHELF_MODALS' ) ) {
				if ( $modal ) {
					offtheshelf_add_modal( $modal );
					$link_data = ' data-featherlight="#modal-' . $modal . '" data-featherlight-variant="modal-style-' . $modal . '"';
					$link      = 'javascript:void(0);';
				}
			}


			$caption = offtheshelf_array_option( 'button_caption', $instance, false );

			if ( $link != "" && $caption != "" ) {

				if ( offtheshelf_array_option( 'nofollow', $instance, false ) ) {
					$nofollow = ' rel="nofollow"';
				} else {
					$nofollow = '';
				}

				if ( offtheshelf_array_option( 'link_target', $instance, false ) ) {
					$link_target = ' target="_blank"';
				} else {
					$link_target = '';
				}

				if ( $button_style_tag = offtheshelf_array_option( 'button_style', $instance, false ) ) {
					$button_style = 'button-style-' . $button_style_tag;
				} else {
					$button_style = 'button-style-none';
				}

				// link URLs are escaped as such while retrieved from database
				$out .= '<a href="' . esc_attr ( $instance['button_link'] ) . '" class="button_buy_table ' . $button_style . '"' . $nofollow . $link_target . $link_data . '>' . esc_html( $caption ) . '</a>';
			}

			$out .= '</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_pricing_block_widget' ) ) {
		function register_offtheshelf_pricing_block_widget() {
			register_widget( 'OffTheShelf_Pricing_Block_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_pricing_block_widget', 1 );
	}
}