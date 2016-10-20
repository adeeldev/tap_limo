<?php
/**
 * Plugin Name: OffTheShelf Bio Block
 * Plugin URI: http://www.shapingrain.com
 * Description: Displays a testimonial.
 * Version: 1.0
 * License: GPLv2
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! class_exists( 'OffTheShelf_Bio_Block_Widget' ) ) {
	class OffTheShelf_Bio_Block_Widget extends SR_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'OtS Bio Block', 'offtheshelf' ),
				// Widget Backend Description
				'description' => esc_html__( 'Displays picture, name, position and social icons to introduce a person.', 'offtheshelf' ),
				'options' => array ( 'classname' => 'ots-bio-block' )
			);


			// Tab groups
			$args['groups'] = array(
				'general' => esc_html__( 'General', 'offtheshelf' ),
				'social'  => esc_html__( 'Contact Options', 'offtheshelf' ),
			);


			// Configure the widget fields
			// fields array
			$args['fields'] = array(

				// Title field
				array(
					'name'     => esc_html__( 'Name', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter this person\'s name.', 'offtheshelf' ),
					'id'       => 'title',
					'group'    => 'general',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Description', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a short description or introduction here, like a mini biography.', 'offtheshelf' ),
					'id'       => 'description',
					'group'    => 'general',
					'type'     => 'textarea',
					'rows'     => '5',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Job Title/Description/Company', 'offtheshelf' ),
					'desc'     => esc_html__( 'Enter a job title, function and/or company name here.', 'offtheshelf' ),
					'id'       => 'job_title',
					'group'    => 'general',
					'type'     => 'text',
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'  => esc_html__( 'Avatar/Picture', 'offtheshelf' ),
					'desc'  => esc_html__( 'Upload an image to be displayed.', 'offtheshelf' ),
					'class' => 'img',
					'id'    => 'avatar',
					'group' => 'general',
					'type'  => 'image',
					'std'   => '',
					//'validate' => '',
					//'filter' => ''
				),
				array(
					'name'     => esc_html__( 'Style', 'offtheshelf' ),
					'desc'     => esc_html__( 'Select what style you would like to apply to these icons.', 'offtheshelf' ),
					'id'       => 'style',
					'group'    => 'social',
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
					'group'    => 'social',
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
				array(
					'name'     => esc_html__( 'Website', 'offtheshelf' ),
					'id'       => 'social_website',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Email', 'offtheshelf' ),
					'id'       => 'social_email',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Facebook URL', 'offtheshelf' ),
					'id'       => 'social_facebook',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Twitter URL', 'offtheshelf' ),
					'id'       => 'social_twitter',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Google+ URL', 'offtheshelf' ),
					'id'       => 'social_gplus',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'LinkedIn URL', 'offtheshelf' ),
					'id'       => 'social_linkedin',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Instagram URL', 'offtheshelf' ),
					'id'       => 'social_instagram',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Pinterest URL', 'offtheshelf' ),
					'id'       => 'social_pinterest',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Flickr URL', 'offtheshelf' ),
					'id'       => 'social_flickr',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Tumblr URL', 'offtheshelf' ),
					'id'       => 'social_tumblr',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Foursquare URL', 'offtheshelf' ),
					'id'       => 'social_foursquare',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'YouTube URL', 'offtheshelf' ),
					'id'       => 'social_youtube',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),
				array(
					'name'     => esc_html__( 'Vimeo URL', 'offtheshelf' ),
					'id'       => 'social_vimeo',
					'group'    => 'social',
					'type'     => 'text',
					// class, rows, cols
					'class'    => 'widefat',
					'std'      => '',
					'validate' => 'alpha_dash',
					'filter'   => ''
				),


			); // fields array

			$this->create_widget( $args );
		}


		// Output function
		function widget( $args, $instance ) {

			$out = $args['before_widget'];

			$avatar      = offtheshelf_array_option( 'avatar', $instance, false );
			$name        = offtheshelf_array_option( 'title', $instance, false );
			$position    = offtheshelf_array_option( 'job_title', $instance, false );
			$description = offtheshelf_array_option( 'description', $instance, false );

			$social_facebook   = offtheshelf_array_option( 'social_facebook', $instance, false );
			$social_twitter    = offtheshelf_array_option( 'social_twitter', $instance, false );
			$social_gplus      = offtheshelf_array_option( 'social_gplus', $instance, false );
			$social_linkedin   = offtheshelf_array_option( 'social_linkedin', $instance, false );
			$social_instagram  = offtheshelf_array_option( 'social_instagram', $instance, false );
			$social_pinterest  = offtheshelf_array_option( 'social_pinterest', $instance, false );
			$social_flickr     = offtheshelf_array_option( 'social_flickr', $instance, false );
			$social_tumblr     = offtheshelf_array_option( 'social_tumblr', $instance, false );
			$social_foursquare = offtheshelf_array_option( 'social_foursquare', $instance, false );
			$social_youtube    = offtheshelf_array_option( 'social_youtube', $instance, false );
			$social_vimeo      = offtheshelf_array_option( 'social_vimeo', $instance, false );

			$social_website = offtheshelf_array_option( 'social_website', $instance, false );
			$social_email   = offtheshelf_array_option( 'social_email', $instance, false );

			$out .= '<div class="team-member">';

			if ( $avatar ) {
				$avatar = intval( $avatar );
				if ( $avatar != 0 ) {
					$avatar_image = wp_get_attachment_image_src( $avatar, 'ots-bio-avatar' );
					if ( $avatar_image ) {
						$out .= '<img src="' . esc_url( $avatar_image[0] ) . '" alt="' . esc_attr( offtheshelf_array_option( 'name', $instance, '' ) ) . '">';
					}
				}
			}

			if ( $name ) {
				$out .= '<h3>' . esc_html( $name ) . '</h3>';
			}

			if ( $position ) {
				$out .= '<p class="team-position">' . esc_html( $position ) . '</p>';
			}

			if ( $description ) {
				$out .= '<p>' . offtheshelf_esc_html( $description, false, true ) . '</p>';
			}

			$icon_size = esc_attr( offtheshelf_array_option( 'icon_size', $instance, '3' ) );

			if (
					$social_website ||
					$social_email ||
					$social_facebook ||
					$social_twitter ||
					$social_gplus ||
					$social_linkedin ||
					$social_instagram ||
					$social_pinterest ||
					$social_flickr ||
					$social_tumblr ||
					$social_foursquare ||
					$social_youtube ||
					$social_vimeo
			) {
				$out .= '<ul class="social-icons style-' . offtheshelf_array_option( 'style', $instance, 'transparent' ) . ' icon-size-' . $icon_size . '">';

				if ( $social_website ) {
					$out .= '<li>
					<a class="website" target="_blank" href="' . esc_url( $social_website ) . '">
					<i class="fa fa-home fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Website', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_email ) {
					$out .= '<li>
					<a class="email" target="_blank" href="mailto:' . esc_html( $social_email ) . '">
					<i class="fa fa-envelope fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Email', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_facebook ) {
					$out .= '<li>
					<a class="facebook" target="_blank" href="' . esc_url( $social_facebook ) . '">
					<i class="fa fa-facebook fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Facebook', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_twitter ) {
					$out .= '<li>
					<a class="twitter" target="_blank" href="' . esc_url( $social_twitter ) . '">
					<i class="fa fa-twitter fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Twitter', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_gplus ) {
					$out .= '<li>
					<a class="googleplus" target="_blank" href="' . esc_url( $social_gplus ) . '">
					<i class="fa fa-googleplus fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Google+', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_linkedin ) {
					$out .= '<li>
					<a class="linkedin" target="_blank" href="' . esc_url( $social_linkedin ) . '">
					<i class="fa fa-linkedin fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'LinkedIn', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_instagram ) {
					$out .= '<li>
					<a class="instagram" target="_blank" href="' . esc_url( $social_instagram ) . '">
					<i class="fa fa-instagram fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Instagram', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_pinterest ) {
					$out .= '<li>
					<a class="pinterest" target="_blank" href="' . esc_url( $social_pinterest ) . '">
					<i class="fa fa-pinterest fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Pinterest', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_flickr ) {
					$out .= '<li>
					<a class="flickr" target="_blank" href="' . esc_url( $social_flickr ) . '">
					<i class="fa fa-flickr fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Flickr', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_tumblr ) {
					$out .= '<li>
					<a class="tumblr" target="_blank" href="' . esc_url( $social_tumblr ) . '">
					<i class="fa fa-flickr fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Tumblr', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_foursquare ) {
					$out .= '<li>
					<a class="foursquare" target="_blank" href="' . esc_url( $social_foursquare ) . '">
					<i class="fa fa-foursquare fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Foursquare', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_youtube ) {
					$out .= '<li>
					<a class="youtube" target="_blank" href="' . esc_url( $social_youtube ) . '">
					<i class="fa fa-youtube fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'YouTube', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				if ( $social_vimeo ) {
					$out .= '<li>
					<a class="vimeo" target="_blank" href="' . esc_url( $social_vimeo ) . '">
					<i class="fa fa-vimeo-square fa-' . $icon_size . 'x"></i>
					<span>' . esc_html__( 'Vimeo', 'offtheshelf' ) . '</span></a>
				</li>';
				}

				$out .= '</ul>';
			}

			$out .= '</div>';

			$out .= $args['after_widget'];

			echo $out;
		}

	} // class

	// Register widget
	if ( ! function_exists( 'register_offtheshelf_bio_block_widget' ) ) {
		function register_offtheshelf_bio_block_widget() {
			register_widget( 'OffTheShelf_Bio_Block_Widget' );
		}

		add_action( 'widgets_init', 'register_offtheshelf_bio_block_widget', 1 );
	}
}