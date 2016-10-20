<?php
/**
 * Plugin Name: OffTheShelf Portolio Item
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays an image as a portfolio item.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Portfolio_Item_Widget' ) ) {
	class OffTheShelf_Portfolio_Item_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Portfolio Item', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays an image as a portfolio item.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-portfolio-item' )

			);

			// Prepare image sizes
			$image_sizes = array(
				array(
					'name'  => esc_html__( 'Default', 'offtheshelf' ),
					'value' => ''
				),
				array(
					'name'  => esc_html__( 'Large', 'offtheshelf' ),
					'value' => 'large'
				),
				array(
					'name'  => esc_html__( 'Medium', 'offtheshelf' ),
					'value' => 'medium'
				),
				array(
					'name'  => esc_html__( 'Thumbnail', 'offtheshelf' ),
					'value' => 'thumbnail'
				),
				array(
					'name'  => esc_html__( 'Full', 'offtheshelf' ),
					'value' => 'full'
				)
			);

			global $_wp_additional_image_sizes;
			if ( ! empty( $_wp_additional_image_sizes ) ) {
				foreach ( $_wp_additional_image_sizes as $name => $info ) {
					$image_sizes[] = array(
						'name'  => ucwords( strtolower( strtr( $name, "-_", "  " ) ) ),
						'value' => $name
					);
				}
			}

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
					'name'     => esc_html__( 'Description', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a description or any additional text or mark-up here.', 'offtheshelf' ),
					'id'       => 'description',
					'type'     => 'textarea',
					'rows'     => '5',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Title and description only on hover', 'offtheshelf' ),
					'desc'     => esc_html__( 'If this option is checked, title and description will only be displayed if the user moves the mouse cursor over the item.', 'offtheshelf' ),
					'id'       => 'text_on_hover',
					'type'     => 'checkbox',
					'class'    => 'widefat',
					'std'      => 0,
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'  => esc_html__( 'Image', 'offtheshelf' ),
					'desc'  => esc_html__( 'Upload or select an image.', 'offtheshelf' ),
					'class' => 'img',
					'id'    => 'image',
					'type'  => 'image',
					'std'   => '',
					'validate' => 'numeric',
					'filter' => ''
				),
				array(
					'name'     => esc_html__( 'Thumbnail Image Size', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select a size. All sizes available to WordPress are displayed.', 'offtheshelf' ),
					'id'       => 'thumbnail_size',
					'type'     => 'select',
					'fields'   => $image_sizes,
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Link Type', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select where this link should point to.', 'offtheshelf' ),
					'id'       => 'link_type',
					'type'     => 'select',
					'fields'   => array(
						array(
							'name'  => esc_html__( 'Open URL in browser', 'offtheshelf' ),
							'value' => 'external'
						),
						array(
							'name'  => esc_html__( 'Open lightbox and display image in full size', 'offtheshelf' ),
							'value' => 'lightbox'
						),
					),
					'std'      => 'external',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Link URL', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter an optional URL to link the image to.', 'offtheshelf' ),
					'id'       => 'link',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Open Link in New Window', 'offtheshelf' ),
					'id'       => 'link_target',
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

			$out = $args['before_widget'];

			if ( offtheshelf_array_option( 'title', $instance, false ) && ! offtheshelf_is_pagebuilder() ) {
				$out .= $args['before_title'];
				$out .= esc_html( $instance['title'] );
				$out .= $args['after_title'];
			}

			$image = offtheshelf_array_option( 'image', $instance );
			$thumbnail_size = offtheshelf_array_option( 'thumbnail_size', $instance, "large" );

			$type        = offtheshelf_array_option( 'link_type', $instance, "external" );
			$link        = '';
			$link_target = '';
			$link_class  = '';

			if ( $type == "external" ) {
				$link_class  = 'link-external';
				$link        = esc_url( trim( offtheshelf_array_option( 'link', $instance, '' ) ) );
				$link_target = offtheshelf_array_option( 'link', $instance, false );
				if ( $link_target == 1 ) {
					$link_target = ' target="_blank"';
				}
			} elseif ( $type == "lightbox" ) {
				$link_class  = 'link-lightbox';
				$link        = 'javascript:void(0);';
				$link_target = '';
			}

			if ( $image ) {
				$image_src = wp_get_attachment_image_src( intval( $image ), "full" );
				if ($thumbnail_size == "full") {
					$thumbnail_image_src = $image_src;
				} else {
					$thumbnail_image_src = wp_get_attachment_image_src( intval( $image ), $thumbnail_size );
				}

				if ( $image_src ) {
					$title = offtheshelf_array_option( 'title', $instance, false );
					if ( $title ) {
						$title_alt = ' alt="' . esc_attr( $title ) . '"';
					} else {
						$attachment  = get_post( intval( $image ) );
						$image_title = $attachment->post_title;

						$title_alt = ' alt="' . esc_attr( $image_title ) . '"';
					}

					$description = offtheshelf_esc_html( offtheshelf_array_option( 'description', $instance, false ), false, true );

					$show_text_on_hover = offtheshelf_array_option( 'text_on_hover', $instance, false );
					if ( $show_text_on_hover ) {
						$on_hover = ' text-on-hover';
					} else {
						$on_hover = '';
					}

					$link_type = offtheshelf_array_option( 'link_type', $instance, 'external' );
					if ( $link_type == "lightbox" ) {
						$link = $image_src[0];
					}

					$out .= '<div class="portfolio-item image-' . $on_hover . '">';

					if ( $link && $link != '' ) {
						// link URLs are escaped as such while retrieved from database
						$out .= '<a href="' . esc_attr( $link ) . '"' . $link_target . ' class="' . $link_class . '">';
					}

					$out .= '<div class="portfolio-image">';
					$out .= '<img src="' . esc_url( $thumbnail_image_src[0] ) . '"' . $title_alt . '>';
					$out .= '</div>';

					if ( ! empty( $title ) || ! empty( $description ) ) {
						$out .= '<div class="portfolio-text">';
						if ( ! empty( $title ) ) {
							$out .= '<h4>' . esc_html( $title ) . '</h4>';
						}
						if ( ! empty( $description ) ) {
							$out .= '<p>' . $description . '</p>';
						}
						$out .= '</div>';
					}

					if ( ! empty( $link ) ) {
						$out .= '</a>';
					}

					$out .= '</div>';
				}
			}

			$out .= $args['after_widget'];

			echo $out;

		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_portfolio_item_widget' ) ) {
		function register_offtheshelf_portfolio_item_widget() {
			register_widget( 'OffTheShelf_Portfolio_Item_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_portfolio_item_widget', 1 );
	}
}