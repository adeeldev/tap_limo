<?php
/**
 * Off the Shelf for WordPress by ShapingRain.com
 * Author: ShapingRain.com
 * URL: http://www.shapingrain.com
 *
 * This file contains the admin panel for Off the Shelf; as well as definitions
 * of custom fields etc.
 *
 * @package offtheshelf
 */

// admin textdomain
add_action( 'after_setup_theme', 'offtheshelf_admin_textdomain_setup' );
function offtheshelf_admin_textdomain_setup() {
	load_theme_textdomain( 'offtheshelf', get_template_directory() . '/languages' );
}

// helper function
function offtheshelf_add_admin_menu_separator( $position ) {

	global $menu;
	$index = 0;

	foreach ( $menu as $offset => $section ) {
		if ( substr( $section[2], 0, 9 ) == 'separator' ) {
			$index ++;
		}
		if ( $offset >= $position ) {
			$menu[ $position ] = array( '', 'read', "separator{$index}", '', 'wp-menu-separator' );
			break;
		}
	}

	ksort( $menu );
}

function admin_menu_separator() {
	offtheshelf_add_admin_menu_separator( 308 );
}

add_action( 'admin_menu', 'admin_menu_separator' );


add_action( 'after_setup_theme', 'offtheshelf_init_admin' );
if ( ! function_exists( 'offtheshelf_init_admin' ) ) {
	function offtheshelf_init_admin() {
		// prefix for all options
		$prefix = OFFTHESHELF_OPTIONS_PREFIX; // ShapingRain.com Off The Shelf prefix for all options

		do_action( 'offtheshelf_register_content_types' );
		do_action( 'offtheshelf_admin_setup_after_content_types' );

		/*
		 * Profiles
		 */
		if ( is_admin() ) {

			/*
			 * Meta Box: Title Option
            */
			if ( function_exists( 'siteorigin_panels_render' ) ) {
				$config        = array(
					'id'             => 'offtheshelf_pagebuilder',
					'title'          => __( 'Page Builder Options', 'offtheshelf' ),
					'pages'          => array( 'page' ),
					'context'        => 'normal',
					'priority'       => 'high',
					'fields'         => array(),
					'local_images'   => false,
					'use_with_theme' => get_template_directory_uri() . '/lib/admin'
				);
				$meta_pbuilder = new SR_Meta_Box( $config );
				$meta_pbuilder->addCheckbox( $prefix . 'bypass_page_builder', array(
					'name'    => __( 'Bypass Page Builder', 'offtheshelf' ),
					'caption' => __( 'Do not use page builder content', 'offtheshelf' ),
					'std'     => false,
					'class'   => 'no-fancy',
					'desc'    => __( 'If this option is checked, page builder content will not be rendered and the editor contents will be used instead.', 'offtheshelf' )
				) );

				$meta_pbuilder->Finish();
			}


			/*
			 * Meta Box: Title Option
			 */
			$config     = array(
				'id'             => 'offtheshelf_title',
				'title'          => __( 'Title Options', 'offtheshelf' ),
				'pages'          => array( 'page' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_title = new SR_Meta_Box( $config );
			$meta_title->addCheckbox( $prefix . 'hide_title', array(
				'name'    => __( 'Hide Title', 'offtheshelf' ),
				'caption' => __( 'Hide title on this page', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the title header block will be hidden on this page.', 'offtheshelf' )
			) );

			$meta_title->Finish();

			/*
			 * Meta Box: Layout Options
 			*/
			$config      = array(
				'id'             => 'offtheshelf_layout',
				'title'          => __( 'Layout and Design', 'offtheshelf' ),
				'pages'          => array( 'page' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_layout = new SR_Meta_Box( $config );
			$meta_layout->addPosts( $prefix . 'custom_banner', array( 'post_type' => 'banner' ), array(
				'class' => 'no-fancy',
				'name'  => __( 'Custom Banner', 'offtheshelf' ),
				'desc'  => __( 'If a banner is selected, it will be displayed instead of the default banner selected for the active profile.', 'offtheshelf' )
			) );
			$meta_layout->addCheckbox( $prefix . 'hide_header', array(
				'name'    => __( 'Hide Header', 'offtheshelf' ),
				'caption' => __( 'Remove the header section from this page', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the header containing logo, site title, tagline, menu and social icons, will be hidden on this page.', 'offtheshelf' )
			) );
			$meta_layout->addCheckbox( $prefix . 'hide_footer_widgets', array(
				'name'    => __( 'Hide Footer Widgets', 'offtheshelf' ),
				'caption' => __( 'Remove footer widgets section from this page', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the footer widgets section will not be displayed on this particular page.', 'offtheshelf' )
			) );
			$meta_layout->addCheckbox( $prefix . 'design_show_banner', array(
				'name'    => __( 'Display Sub Header', 'offtheshelf' ),
				'caption' => __( 'Display sub header underneath header and banner', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, a narrow sub header will be displayed above the content.', 'offtheshelf' )
			) );
			$meta_layout->Finish();


			/*
			 * Meta Box: Layout Options
			 */
			$config      = array(
				'id'             => 'offtheshelf_layout',
				'title'          => __( 'Layout and Design', 'offtheshelf' ),
				'pages'          => array( 'post' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_layout_post = new SR_Meta_Box( $config );
			$meta_layout_post->addPosts( $prefix . 'custom_banner', array( 'post_type' => 'banner' ), array(
				'class' => 'no-fancy',
				'name'  => __( 'Custom Banner', 'offtheshelf' ),
				'desc'  => __( 'If a banner is selected, it will be displayed instead of the default banner selected for the active profile.', 'offtheshelf' )
			) );
			$meta_layout_post->Finish();


			/*
			 * Meta Box: Product Layout Options
			 */
			if ( function_exists( 'is_woocommerce' ) ) {
				$config          = array(
					'id'             => 'offtheshelf_layout',
					'title'          => __( 'Layout and Design', 'offtheshelf' ),
					'pages'          => array( 'product' ),
					'context'        => 'normal',
					'priority'       => 'default',
					'fields'         => array(),
					'local_images'   => false,
					'use_with_theme' => get_template_directory_uri() . '/lib/admin'
				);
				$meta_layout_woo = new SR_Meta_Box( $config );
				$meta_layout_woo->addPosts( $prefix . 'custom_banner', array( 'post_type' => 'banner' ), array(
					'class' => 'no-fancy',
					'name'  => __( 'Custom Banner', 'offtheshelf' ),
					'desc'  => __( 'If a banner is selected, it will be displayed instead of the default banner selected for the active profile.', 'offtheshelf' )
				) );
				$meta_layout_woo->addCheckbox( $prefix . 'hide_header', array(
					'name'    => __( 'Hide Header', 'offtheshelf' ),
					'caption' => __( 'Remove the header section from this page', 'offtheshelf' ),
					'std'     => false,
					'class'   => 'no-fancy',
					'desc'    => __( 'If this option is checked, the header containing logo, site title, tagline, menu and social icons, will be hidden on this page.', 'offtheshelf' )
				) );
				$meta_layout_woo->addCheckbox( $prefix . 'hide_footer_widgets', array(
					'name'    => __( 'Hide Footer Widgets', 'offtheshelf' ),
					'caption' => __( 'Remove footer widgets section from this page', 'offtheshelf' ),
					'std'     => false,
					'class'   => 'no-fancy',
					'desc'    => __( 'If this option is checked, the footer widgets section will not be displayed on this particular page.', 'offtheshelf' )
				) );
				$meta_layout_woo->Finish();
			}

			/*
			 * Meta Box: Advanced
 			*/
			$config             = array(
				'id'             => 'offtheshelf_page_advanced',
				'title'          => __( 'Advanced', 'offtheshelf' ),
				'pages'          => array( 'page', 'post' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_page_advanced = new SR_Meta_Box( $config );

			if ( function_exists ( 'offtheshelf_shortcode_option' ) ) {
				$meta_page_advanced->addTextarea( $prefix . 'advanced_page_shortcodes', array(
					'name'           => __( 'Customization Shortcodes', 'offtheshelf' ),
					'label_location' => 'top',
					'desc'           => __( 'Use advanced customization shortcodes to modify theme options and replace sections.', 'offtheshelf' ),
					'rows'           => '10'
				) );
			}

			$meta_page_advanced->addTextarea( $prefix . 'advanced_page_custom_css', array(
				'name'           => __( 'Custom CSS', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'Custom CSS code to be added to the page header.', 'offtheshelf' ),
				'rows'           => '10'
			) );
			$meta_page_advanced->addTextarea( $prefix . 'advanced_page_custom_scripts', array(
				'name'           => __( 'Custom Scripts', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'Custom scripts to be added to the page header.', 'offtheshelf' ),
				'rows'           => '10'
			) );
			$meta_page_advanced->Finish();

			/*
			 * Meta Box: Development Options
 			*/
			if ( offtheshelf_option( 'support_options_dev_mode' ) ) {
				$config                = array(
					'id'             => 'offtheshelf_page_development',
					'title'          => __( 'Development', 'offtheshelf' ),
					'pages'          => array( 'page' ),
					'context'        => 'normal',
					'priority'       => 'high',
					'fields'         => array(),
					'local_images'   => false,
					'use_with_theme' => get_template_directory_uri() . '/lib/admin'
				);
				$meta_page_development = new SR_Meta_Box( $config );
				$meta_page_development->addTextarea( $prefix . 'development_package_description', array(
					'name'           => __( 'Template Description', 'offtheshelf' ),
					'label_location' => 'top',
					'desc'           => __( 'This description will be used for exported template packages.', 'offtheshelf' ),
					'rows'           => '5'
				) );
				$meta_page_development->addImage( $prefix . 'development_package_preview', array(
					'name' => __( 'Template Preview', 'offtheshelf' ),
					'desc' => __( 'This image will be used as a template preview.', 'offtheshelf' )
				) );
				$meta_page_development->addText( $prefix . 'development_package_group', array(
					'name' => __( 'Group ID', 'offtheshelf' ),
					'size' => 65
				) );
				$meta_page_development->addText( $prefix . 'development_package_min_version', array(
					'name' => __( 'Minimum Req. Version', 'offtheshelf' ),
					'size' => 65
				) );
				$meta_page_development->addText( $prefix . 'development_package_sort_order', array(
					'name' => __( 'Sort Order', 'offtheshelf' ),
					'size' => 65
				) );
				$meta_page_development->Finish();
			}


			/*
			 * Meta Box: Layout
			 */
			$config               = array(
				'id'             => 'offtheshelf_layout_template',
				'title'          => __( 'Template', 'offtheshelf' ),
				'pages'          => array( 'page', 'post' ),
				'context'        => 'side',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_layout_template = new SR_Meta_Box( $config );
			$meta_layout_template->addSelect( $prefix . 'template_layout', array(
				false           => __( 'No Sidebar', 'offtheshelf' ),
				'sidebar-left'  => __( 'Sidebar Left', 'offtheshelf' ),
				'sidebar-right' => __( 'Sidebar Right', 'offtheshelf' )
			), array(
				'name'           => __( 'Sidebar', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'Select a page template.', 'offtheshelf' ),
				'std'            => false
			) );
			$meta_layout_template->Finish();


			/*
			 * Meta Box: Profile
			 */
			if ( defined ('OFFTHESHELF_FEATURE_PACK') ) {
				$config       = array(
					'id'             => 'offtheshelf_profile',
					'title'          => __( 'Settings Profile', 'offtheshelf' ),
					'pages'          => array( 'page', 'post' ),
					'context'        => 'side',
					'priority'       => 'default',
					'fields'         => array(),
					'local_images'   => false,
					'use_with_theme' => get_template_directory_uri() . '/lib/admin'
				);
				$meta_profile = new SR_Meta_Box( $config );
				$meta_profile->addPosts( $prefix . 'profile',
					array( 'post_type' => 'profile' ),
					array(
						'class'          => 'no-fancy',
						'name'           => __( 'Profile', 'offtheshelf' ),
						'label_location' => 'top',
						'desc'           => __( 'Select a settings profile to be applied to this page. If none is selected, the default profile will be used.', 'offtheshelf' )
					) );
				$meta_profile->Finish();
			}

			/*
			 * Meta Box: Design
			 */
			$config      = array(
				'id'             => 'offtheshelf_profile_design',
				'title'          => __( 'Layout and Design', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_design = new SR_Meta_Box( $config );

			//$meta_design->addCheckbox( $prefix . 'design_boxed', 		array( 'name' => __( 'Boxed Design', 'offtheshelf' ), 'caption' => __( 'Display page content in a fixed width wrapper', 'offtheshelf' ), 'std' => false,  'class' => 'no-fancy', 'desc' => __( 'If this option is checked, the site will use a boxed design, with an additional wrapper around the content.', 'offtheshelf' ),  'group-selector' => true ) );

			$meta_design->addSelect( $prefix . 'content_layout', array(
				'default'    => __( 'Default', 'offtheshelf' ),
				'boxed'      => __( 'Boxed', 'offtheshelf' ),
				'full-width' => __( 'Full Width', 'offtheshelf' )
			), array(
				'name'           => __( 'Layout', 'offtheshelf' ),
				'std'            => 'default',
				'class'          => 'no-fancy',
				'group-selector' => true
			) );


			$meta_design->addSelect( $prefix . 'body_background_mode', array(
				'solid'       => __( 'Solid Color', 'offtheshelf' ),
				'image-fixed' => __( 'Image (fixed)', 'offtheshelf' ),
				'image-tile'  => __( 'Image (tile)', 'offtheshelf' )
			), array(
				'name'           => __( 'Background Mode', 'offtheshelf' ),
				'std'            => 'solid',
				'class'          => 'no-fancy',
				'group-selector' => true
			) );

			$meta_design->addColor( $prefix . 'color_body_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_design->addColor( $prefix . 'color_body_background_boxed_wrapper', array(
				'name'        => __( 'Content Background Color', 'offtheshelf' ),
				'std'         => '#f5f5f5',
				'is-group'    => $prefix . 'content_layout',
				'group-value' => array( 'boxed' )
			) );

			$meta_design->addImage( $prefix . 'body_background_image', array(
				'name'        => __( 'Background Image', 'offtheshelf' ),
				'is-group'    => $prefix . 'body_background_mode',
				'group-value' => array(
					'image-fixed',
					'image-tile'
				)
			) );

			$meta_design->addColor( $prefix . 'color_body_link', array(
				'name' => __( 'Link Color', 'offtheshelf' ),
				'std'  => '#000000'
			) );
			$meta_design->addColor( $prefix . 'color_body_link_hover', array(
				'name' => __( 'Link Hover Color', 'offtheshelf' ),
				'std'  => '#000000'
			) );

			// Get available button styles from options
			$styles      = array();
			$styles['0'] = __( 'None', 'offtheshelf' );
			$styles_temp = offtheshelf_option( 'global_button_styles' );
			$std_style   = '';
			if ( is_array( $styles_temp ) && count( $styles_temp ) > 0 ) {
				foreach ( $styles_temp as $style ) {
					if ( $style['name'] == '' ) {
						$name = $style['uid'];
					} else {
						$name = $style['name'];
					}
					$styles[ $style['uid'] ] = $name;
				}
			}
			$meta_design->addSelect( $prefix . 'default_button_style',
				$styles,
				array(
					'name'  => __( 'Default Button Style', 'offtheshelf' ),
					'std'   => '0',
					'class' => 'no-fancy',
					'desc'  => __( 'Select the default style used for all buttons for which no specific style can be selected, e.g. form submit buttons.', 'offtheshelf' ),
				)
			);

			if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
				$meta_design->addCheckbox( 'mobile_animations', array(
								'name'    => __( 'Mobile Animations', 'offtheshelf' ),
								'caption' => __( 'Support row and widget animations for mobile devices', 'offtheshelf' ),
								'std'     => false,
								'class'   => 'no-fancy',
								'desc'    => __( 'If this option is checked, row and widget animations added in the page builder will also be used on mobile devices.', 'offtheshelf' )

						)
				);
			}

			$meta_design->Finish();


			/*
			 * Meta Box: Fonts
			 */
			$config          = array(
				'id'             => 'offtheshelf_profile_fonts',
				'title'          => __( 'Typography', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_typography = new SR_Meta_Box( $config );

			$meta_typography->addParagraph( $prefix . 'toolbar_info', array('value' => __( 'Typography settings are applied to all pages using this profile. Please note that banners have additional individual settings. Button styles also have their own typography settings.', 'offtheshelf' )));

			$meta_typography->addTypography(
				$prefix . 'font_body',
				array(
					'name' => __( 'Body', 'offtheshelf' ),
					'desc' => __( 'This font is used for all text for which no other font is defined, such as plain text paragraphs.', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_logo',
				array(
					'name' => __( 'Logo', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_logo_tagline',
				array(
					'name' => __( 'Logo Tagline', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_page_title',
				array(
					'name' => __( 'Page Title', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_widget_title',
				array(
					'name' => __( 'Widget Title', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_quote',
				array(
					'name' => __( 'Quotes', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h1',
				array(
					'name' => __( 'H1', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h2',
				array(
					'name' => __( 'H2', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h3',
				array(
					'name' => __( 'H3', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h4',
				array(
					'name' => __( 'H4', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h5',
				array(
					'name' => __( 'H5', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->addTypography(
				$prefix . 'font_h6',
				array(
					'name' => __( 'H6', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'helvetica',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_typography->Finish();


			/*
			 * Meta Box: Social Icons
			 */
			$config      = array(
				'id'             => 'offtheshelf_profile_social',
				'title'          => __( 'Social Media Profiles', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_social = new SR_Meta_Box( $config );

			$meta_social->addParagraph( $prefix . 'toolbar_info', array('value' => __( 'These are the social media profiles displayed in header, toolbar and the social icons widget.', 'offtheshelf' )));

			$social_fields   = array();
			$social_fields[] = $meta_social->addSelect( 'preset', array(
				''           => __( 'None', 'offtheshelf' ),
				'facebook'   => __( 'Facebook', 'offtheshelf' ),
				'twitter'    => __( 'Twitter', 'offtheshelf' ),
				'googleplus' => __( 'Google+', 'offtheshelf' ),
				'youtube'    => __( 'YouTube', 'offtheshelf' ),
				'linkedin'   => __( 'LinkedIn', 'offtheshelf' ),
				'instagram'  => __( 'Instagram', 'offtheshelf' ),
				'pinterest'  => __( 'Pinterest', 'offtheshelf' ),
				'flickr'     => __( 'Flickr', 'offtheshelf' ),
				'tumblr'     => __( 'Tumblr', 'offtheshelf' ),
				'foursquare' => __( 'Foursquare', 'offtheshelf' ),
				'vimeo'      => __( 'Vimeo', 'offtheshelf' ),
				'lastfm'     => __( 'last.fm', 'offtheshelf' ),
				'soundcloud' => __( 'Soundcloud', 'offtheshelf' ),
				'yelp'       => __( 'Yelp', 'offtheshelf' ),
				'slideshare' => __( 'Slideshare', 'offtheshelf' ),
				'dribbble'   => __( 'Dribbble', 'offtheshelf' ),
				'behance'    => __( 'Behance', 'offtheshelf' ),
				'github'     => __( 'GitHub', 'offtheshelf' ),
				'reddit'     => __( 'Reddit', 'offtheshelf' ),
				'weibo'      => __( 'Weibo', 'offtheshelf' ),
				'deviantart' => __( 'DeviantArt', 'offtheshelf' ),
				'skype'      => __( 'Skype', 'offtheshelf' ),
				'spotify'    => __( 'Spotify', 'offtheshelf' ),
				'xing'       => __( 'Xing', 'offtheshelf' ),
				'vine'       => __( 'Vine', 'offtheshelf' ),
				'digg'       => __( 'Digg', 'offtheshelf' ),
			), array(
				'name'  => __( 'Preset', 'offtheshelf' ),
				'std'   => 'solid',
				'class' => 'social-service-select'
			), true );
			$social_fields[] = $meta_social->addText( 'title', array(
				'name' => __( 'Title', 'offtheshelf' ),
				'size' => 65
			), true );
			$social_fields[] = $meta_social->addText( 'link', array(
				'name' => __( 'Link URL', 'offtheshelf' ),
				'size' => 65
			), true );
			$social_fields[] = $meta_social->addIcon( 'icon', array(
				'name' => __( 'Icon', 'offtheshelf' ),
				'std'  => ''
			), true );
			$social_fields[] = $meta_social->addColor( 'color_background', array(
				'name' => __( 'Background', 'offtheshelf' ),
				'std'  => '#828282'
			), true );
			$social_fields[] = $meta_social->addCheckbox( 'show_in_toolbar', array(
				'name'    => __( 'Toolbar', 'offtheshelf' ),
				'caption' => __( 'Activate this service in the toolbar', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, this profile link will be displayed in the site toolbar.', 'offtheshelf' )
			), true );
			$social_fields[] = $meta_social->addCheckbox( 'show_in_header', array(
				'name'    => __( 'Header', 'offtheshelf' ),
				'caption' => __( 'Activate this service in the header', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, this profile link will be displayed in the site header.', 'offtheshelf' )
			), true );
			$social_fields[] = $meta_social->addCheckbox( 'show_in_widget', array(
				'name'    => __( 'Widgets', 'offtheshelf' ),
				'caption' => __( 'Activate this service in social widgets', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, this profile link will be displayed in widgets.', 'offtheshelf' )
			), true );

			$meta_social->addRepeaterBlock(
				'social_media_profiles',
				array(
					'sortable'       => true,
					'inline'         => false,
					'name'           => __( 'Profiles', 'offtheshelf' ),
					'fields'         => $social_fields,
					'desc'           => __( 'Add, edit and re-order social media profiles.', 'offtheshelf' ),
					'label_location' => 'none',
					'title'          => 'title'
				)
			);

			$meta_social->Finish();

			/*
			 * Meta Box: Twitter Account
			 */
			$config       = array(
				'id'             => 'offtheshelf_profile_twitter',
				'title'          => __( 'Twitter Account', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_twitter = new SR_Meta_Box( $config );

			$meta_twitter->addParagraph( 'twitter_intro', array( 'value' => sprintf( __( 'You need to <a href="%1$s" target="_blank">register your website</a> as an application with Twitter in order to use the Twitter API.', 'offtheshelf' ), esc_url( 'https://apps.twitter.com/' ) ) ) );
			$meta_twitter->addText( $prefix . 'twitter_user', array(
				'name' => __( 'Twitter User', 'offtheshelf' ),
				'size' => 65
			) );
			$meta_twitter->addText( $prefix . 'twitter_consumer_key', array(
				'name' => __( 'Consumer Key', 'offtheshelf' ),
				'size' => 65
			) );
			$meta_twitter->addText( $prefix . 'twitter_consumer_secret', array(
				'name' => __( 'Consumer Secret', 'offtheshelf' ),
				'size' => 65
			) );
			$meta_twitter->addText( $prefix . 'twitter_access_token', array(
				'name' => __( 'Access Token', 'offtheshelf' ),
				'size' => 65
			) );
			$meta_twitter->addText( $prefix . 'twitter_access_token_secret', array(
				'name' => __( 'Access Token Secret', 'offtheshelf' ),
				'size' => 65
			) );
			$meta_twitter->Finish();


			/*
			 * Meta Box: Header
			 */
			$config      = array(
				'id'             => 'offtheshelf_profile_header',
				'title'          => __( 'Header', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_header = new SR_Meta_Box( $config );

			$meta_header->addParagraph( $prefix . 'header_info', array('value' => __( 'The header is the layout element at the very top that contains logo, site title, tagline, main menu, social icons etc.', 'offtheshelf' )));

			$meta_header->addCheckbox( $prefix . 'header_menu_transparent', array(
				'name'    => __( 'Transparent', 'offtheshelf' ),
				'caption' => __( 'Display header items as transparent on banner', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the menu bar will be transparent on top of the banner until scrolling reaches content.', 'offtheshelf' )
			) );
			$meta_header->addCheckbox( $prefix . 'header_menu_sticky', array(
				'name'    => __( 'Sticky', 'offtheshelf' ),
				'caption' => __( 'Make header elements \'stick\' to the top of the page', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the menu will be fixed to the top.', 'offtheshelf' )
			) );
			$meta_header->addCheckbox( $prefix . 'header_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the header in full width', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the header will stretch from the outer left to the outer right edge of the window.', 'offtheshelf' )
			) );
			$meta_header->addImage( $prefix . 'header_logo_image', array( 'name' => __( 'Logo Image', 'offtheshelf' ) ) );

			if ( ! function_exists( 'has_site_icon' ) ) {
				$meta_header->addImage( $prefix . 'favicon', array(
					'name' => __( 'Fav Icon', 'offtheshelf' ),
					'desc' => __( 'This is the small icon displayed in the browser tab.', 'offtheshelf' )
				) );
			}

			$meta_header->addCheckbox( $prefix . 'header_title_hide', array(
				'name'    => __( 'Hide Site Title', 'offtheshelf' ),
				'caption' => __( 'Do not display site title in header', 'offtheshelf' )
			) );
			$meta_header->addCheckbox( $prefix . 'header_tagline_hide', array(
				'name'    => __( 'Hide Site Tagline', 'offtheshelf' ),
				'caption' => __( 'Do not display site tagline header', 'offtheshelf' )
			) );
			$meta_header->addText( $prefix . 'header_link', array(
				'name'  => __( 'Custom Link', 'offtheshelf' ),
				'desc'  => __( 'A custom URL to link site title and logo to.', 'offtheshelf' ),
				'class' => 'widefat'
			) );
			$meta_header->addText( $prefix . 'header_title', array(
				'name'  => __( 'Custom Site Title', 'offtheshelf' ),
				'desc'  => __( 'A custom title to use instead of the site title set in WordPress.', 'offtheshelf' ),
				'class' => 'widefat'
			) );
			$meta_header->addText( $prefix . 'header_tagline', array(
				'name'  => __( 'Custom Tagline', 'offtheshelf' ),
				'desc'  => __( 'A custom tagline to use instead of the tagline set in WordPress.', 'offtheshelf' ),
				'class' => 'widefat'
			) );
			$meta_header->addSelect( $prefix . 'header_menu_alignment', array(
				'left'  => __( 'Left', 'offtheshelf' ),
				'center'=> __( 'Center', 'offtheshelf' ),
				'right' => __( 'Right', 'offtheshelf' )
			), array(
				'name'           => __( 'Menu Alignment', 'offtheshelf' ),
				'desc'           => __( 'Select where the menu should be positioned.', 'offtheshelf' ),
				'std'            => 'left',
				'class'          => 'no-fancy'
			) );
			$meta_header->addTaxonomy( $prefix . 'header_menu', array(
				'taxonomy' => 'nav_menu',
				'type'     => 'selectbox'
			), array(
				'name'  => __( 'Custom Menu', 'offtheshelf' ),
				'class' => 'no-fancy',
				'none'  => __( 'Default Menu', 'offtheshelf' ),
				'desc'  => __( 'The selected menu will be displayed as a flat toolbar navigation, so only the first level will be displayed. You must also set a default for all profiles via Appearance &#8594; Menus, otherwise WordPress will see this menu as empty and this option will not be applied.', 'offtheshelf' )
			) );
			$meta_header->addCheckbox( $prefix . 'header_menu_hide', array(
				'name'    => __( 'Hide Menu', 'offtheshelf' ),
				'caption' => __( 'Do not display the header menu', 'offtheshelf' )
			) );
			$meta_header->addCheckbox( $prefix . 'search_bar_hide', array(
				'name'    => __( 'Hide Search Bar', 'offtheshelf' ),
				'caption' => __( 'Do not display search icon in the header', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the search icon and search bar will be hidden.', 'offtheshelf' )
			) );

			if (class_exists('SitePress')) {
				$meta_header->addCheckbox( $prefix . 'language_switcher_hide', array(
						'name'    => __( 'Hide Language Switcher', 'offtheshelf' ),
						'caption' => __( 'Do not display language switcher in header.', 'offtheshelf' ),
						'std'     => false,
						'class'   => 'no-fancy',
						'desc'    => __( 'If this option is checked, the language switcher will be hidden from the header.', 'offtheshelf' )
				) );
			}

			$meta_header->addColor( $prefix . 'header_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_header->addColor( $prefix . 'header_text', array(
				'name' => __( 'Menu Link Color', 'offtheshelf' ),
				'std'  => '#000000',
				'desc' => __( 'This colour is used for menu items.', 'offtheshelf' )
			) );
			$meta_header->addColor( $prefix . 'menu_link_hover', array(
				'name' => __( 'Menu Link Hover Color', 'offtheshelf' ),
				'desc' => __( 'This colour is used for menu items in the hover state.', 'offtheshelf' ),
				'std'  => '#000000'
			) );

			$meta_header->addParagraph( $prefix . 'menu_links_info', array('value' => __( 'Please note that the theme uses the banner text color setting instead of the header link color settings in case the header is displayed transparently on top of the banner.', 'offtheshelf' ),  'no-border' => true));



			$meta_header->Finish();

			/*
			 * Meta Box: Sub Header
			 */
			$config          = array(
				'id'             => 'offtheshelf_profile_sub_header',
				'title'          => __( 'Sub Header', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);

			$meta_sub_header = new SR_Meta_Box( $config );

			$meta_sub_header->addParagraph( $prefix . 'sub_header_info', array('value' => __( 'The sub header is a navigational aid that is displayed underneath the header and banner elements and contains the breadcrumb. It is displayed by default on all blog and supported e-commerce plug-in pages.', 'offtheshelf' )));

			$meta_sub_header->addCheckbox( $prefix . 'header_sub_banner_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the sub header in full width', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the sub header will stretch from the outer left to the outer right edge of the window.', 'offtheshelf' )
			) );
			$meta_sub_header->addColor( $prefix . 'header_sub_banner_color_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_sub_header->addColor( $prefix . 'header_sub_banner_color_text', array(
				'name' => __( 'Text Color', 'offtheshelf' ),
				'std'  => '#000000'
			) );
			$meta_sub_header->Finish();

			/*
			 * Meta Box: Toolbar
			 */
			$config            = array(
				'id'             => 'offtheshelf_profile_multipurpose',
				'title'          => __( 'Toolbar', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_multipurpose = new SR_Meta_Box( $config );

			$meta_multipurpose->addParagraph( $prefix . 'toolbar_info', array('value' => __( 'The toolbar is a narrow bar that is optionally displayed above the header. It can contain a one-dimensional menu or any custom text.', 'offtheshelf' )));

			$meta_multipurpose->addCheckbox( $prefix . 'header_multipurpose', array(
				'name'    => __( 'Display Toolbar', 'offtheshelf' ),
				'caption' => __( 'Display toolbar above header', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the toolbar will be displayed above the header. The toolbar can contain free form text or an additional one-level menu.', 'offtheshelf' )
			) );
			$meta_multipurpose->addCheckbox( $prefix . 'header_multipurpose_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the toolbar in full width', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the toolbar will stretch from the outer left to the outer right edge of the window.', 'offtheshelf' )
			) );
			$meta_multipurpose->addSelect( $prefix . 'header_multipurpose_mode', array(
				'content' => __( 'Custom Content', 'offtheshelf' ),
				'menu'    => __( 'Custom Menu', 'offtheshelf' )
			), array(
				'name'           => __( 'Mode', 'offtheshelf' ),
				'desc'           => __( 'Select what you would like to display in the toolbar.', 'offtheshelf' ),
				'std'            => 'content',
				'class'          => 'no-fancy',
				'group-selector' => true
			) );
			$meta_multipurpose->addWysiwyg( $prefix . 'header_multipurpose_custom', array(
				'name'        => __( 'Custom Content', 'offtheshelf' ),
				'is-group'    => $prefix . 'header_multipurpose_mode',
				'group-value' => array( 'content' ),
				'settings'    => array(
					'textarea_rows' => 3,
					'teeny'         => true,
					'media_buttons' => false
				)
			) );
			$meta_multipurpose->addTaxonomy( $prefix . 'header_multipurpose_menu', array(
				'taxonomy' => 'nav_menu',
				'type'     => 'selectbox'
			), array(
				'name'        => __( 'Custom Menu', 'offtheshelf' ),
				'none'        => __( 'Default Menu', 'offtheshelf' ),
				'desc'        => __( 'The selected menu will be displayed as a flat toolbar navigation, so only the first level will be displayed. You must also set a default for all profiles via Appearance &#8594; Menus, otherwise WordPress will see this menu as empty and this option will not be applied.', 'offtheshelf' ),
				'is-group'    => $prefix . 'header_multipurpose_mode',
				'class' => 'no-fancy',
				'group-value' => array( 'menu' )
			) );
			$meta_multipurpose->addColor( $prefix . 'header_multipurpose_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_multipurpose->addColor( $prefix . 'header_multipurpose_text', array(
				'name' => __( 'Text Color', 'offtheshelf' ),
				'std'  => '#000000',
				'desc' => __( 'This colour is used for the actual text, as well as for links.', 'offtheshelf' )
			) );
			$meta_multipurpose->Finish();


			/*
			 * Meta Box: Footer
			 */
			$config      = array(
				'id'             => 'offtheshelf_profile_footer',
				'title'          => __( 'Footer', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);

			$meta_footer = new SR_Meta_Box( $config );

			$meta_footer->addParagraph( $prefix . 'footer_info', array('value' => __( 'The footer is the last element rendered at the very bottom of the page. It can contain custom text and/or a custom one-dimensional menu.', 'offtheshelf' )));

			$meta_footer->addWysiwyg( $prefix . 'footer_copyright', array(
				'name'     => __( 'Footer Notice', 'offtheshelf' ),
				'desc' => __ ('This element is part of the footer and usually contains a copyright notice, disclaimer text etc.'),
				'settings' => array(
					'textarea_rows' => 3,
					'teeny'         => true,
					'media_buttons' => false
				)
			) );
			$meta_footer->addCheckbox( $prefix . 'footer_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the footer in full width', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the footer will stretch from the outer left to the outer right edge of the window.', 'offtheshelf' )
			) );
			$meta_footer->addTaxonomy( $prefix . 'footer_menu', array(
				'taxonomy' => 'nav_menu',
				'type'     => 'selectbox'
			), array(
				'name'  => __( 'Custom Menu', 'offtheshelf' ),
				'desc'  => __( 'The selected menu will be displayed as a flat toolbar navigation, so only the first level will be displayed. You must also set a default for all profiles via Appearance &#8594; Menus, otherwise WordPress will see this menu as empty and this option will not be applied.', 'offtheshelf' ),
				'class' => 'no-fancy',
				'none'  => __( 'Default Menu', 'offtheshelf' )
			) );
			$meta_footer->addCheckbox( $prefix . 'footer_menu_hide', array(
				'name'    => __( 'Hide Menu', 'offtheshelf' ),
				'caption' => __( 'Do not display the footer menu', 'offtheshelf' )
			) );
			$meta_footer->addColor( $prefix . 'footer_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_footer->addColor( $prefix . 'footer_text', array(
				'name' => __( 'Text Color', 'offtheshelf' ),
				'std'  => '#000000',
				'desc' => __( 'This colour is used for the actual text, as well as for links.', 'offtheshelf' )
			) );
			$meta_footer->Finish();

			/*
			 * Meta Box: Sub Footer
			 */
			$config          = array(
				'id'             => 'offtheshelf_profile_subfooter',
				'title'          => __( 'Sub Footer', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);

			$meta_sub_footer = new SR_Meta_Box( $config );

			$meta_sub_footer->addParagraph( $prefix . 'subfooter_info', array('value' => __( 'The sub footer is a widgetized area displayed right above the footer. It is positioned at the bottom of the page.', 'offtheshelf' )));

			$meta_sub_footer->addCheckbox( $prefix . 'subfooter_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the sub footer in full width', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the sub footer will stretch from the outer left to the outer right edge of the window.', 'offtheshelf' )
			) );
			$meta_sub_footer->addColor( $prefix . 'subfooter_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_sub_footer->addColor( $prefix . 'subfooter_text', array(
				'name' => __( 'Text Color', 'offtheshelf' ),
				'std'  => '#000000',
				'desc' => __( 'This colour is used for the actual text, as well as for links.', 'offtheshelf' )
			) );
			$meta_sub_footer->Finish();


			/*
			 * Meta Box (Banner): Background
			 */
			$config                 = array(
				'id'             => 'offtheshelf_banner_background',
				'title'          => __( 'Background', 'offtheshelf' ),
				'pages'          => array( 'banner' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_banner_background = new SR_Meta_Box( $config );
			$meta_banner_background->addSelect( $prefix . 'background_mode', array(
				'solid'          => __( 'Solid Color', 'offtheshelf' ),
				'gradient'       => __( 'Gradient', 'offtheshelf' ),
				'image-fixed'    => __( 'Image (fixed)', 'offtheshelf' ),
				'image-cover'    => __( 'Image (cover)', 'offtheshelf' ),
				'image-centered' => __( 'Image (original size, centered)', 'offtheshelf' ),
				'image-parallax' => __( 'Image (parallax)', 'offtheshelf' ),
				'image-tile'     => __( 'Image (tile)', 'offtheshelf' ),
			), array(
				'name'           => __( 'Mode', 'offtheshelf' ),
				'std'            => 'solid',
				'class'          => 'no-fancy',
				'group-selector' => true
			) );
			$meta_banner_background->addColor( $prefix . 'color_1', array(
				'name' => __( 'Color 1', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_banner_background->addColor( $prefix . 'color_2', array(
				'name'        => __( 'Color 2', 'offtheshelf' ),
				'std'         => '#ffffff',
				'is-group'    => $prefix . 'background_mode',
				'group-value' => array( 'gradient' )
			) );
			$meta_banner_background->addImage( $prefix . 'background_image', array(
				'name'        => __( 'Image', 'offtheshelf' ),
				'is-group'    => $prefix . 'background_mode',
				'group-value' => array(
					'image-fixed',
					'image-cover',
					'image-centered',
					'image-tile',
					'image-parallax'
				)
			) );
			$meta_banner_background->Finish();


			/*
 			* Meta Box (Banner): Content
 			*/
			$config = array(
				'id'             => 'offtheshelf_banner_content',
				'title'          => __( 'Content', 'offtheshelf' ),
				'pages'          => array( 'banner' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);

			$meta_banner_content = new SR_Meta_Box( $config );

			// slider options
			$is_slider_plugin       = false;
			$banner_content_options = array(
				'content' => __( 'Banner Content', 'offtheshelf' ),
				'custom'  => __( 'Custom Code', 'offtheshelf' )
			);


			$is_metaslider = false;
			$is_revolution = false;

			if ( class_exists( 'MetaSliderPlugin' ) ) {
				$is_metaslider = true;
			}
			if ( class_exists( 'RevSlider' ) ) {
				$is_revolution = true;
			}

			if ( $is_metaslider ) {
				$banner_content_options['metaslider'] = __( 'Meta Slider', 'offtheshelf' );
			}

			if ( $is_revolution ) {
				$banner_content_options['revslider'] = __( 'Revolution Slider', 'offtheshelf' );
			}

			$meta_banner_content->addSelect( $prefix . 'banner_content_mode', $banner_content_options, array(
				'name'           => __( 'Content', 'offtheshelf' ),
				'std'            => 'content',
				'class'          => 'no-fancy',
				'group-selector' => true
			) );

			$meta_banner_content->addTextarea( $prefix . 'banner_content', array(
				'rows'           => 8,
				'name'           => __( 'Custom Code', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'This field\'s content will replace the entire banner.', 'offtheshelf' ),
				'is-group'       => $prefix . 'banner_content_mode',
				'group-value'    => array( 'custom' )
			) );


			if ( $is_metaslider ) {
				$meta_banner_content->addPosts( $prefix . 'metaslider', array( 'post_type' => 'ml-slider' ), array(
					'class'       => 'no-fancy',
					'name'        => __( 'Meta Slider', 'offtheshelf' ),
					'desc'        => __( 'Select which slider you would like to use in this banner.', 'offtheshelf' ),
					'is-group'    => $prefix . 'banner_content_mode',
					'group-value' => array( 'metaslider' )
				) );
			}

			if ( $is_revolution ) {
				try {
					$slider     = new RevSlider();
					$arrSliders = $slider->getArrSlidersShort();
					$meta_banner_content->addSelect( $prefix . 'revslider', $arrSliders, array(
						'class'       => 'no-fancy',
						'name'        => __( 'Revolution Slider', 'offtheshelf' ),
						'desc'        => __( 'Select which slider you would like to use in this banner.', 'offtheshelf' ),
						'is-group'    => $prefix . 'banner_content_mode',
						'group-value' => array( 'revslider' )
					) );
				} catch ( Exception $e ) {
				}
			}

			$meta_banner_content->addTypography(
				$prefix . 'font_banner_title',
				array(
					'name' => __( 'Title (H1)', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'verdana',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_banner_content->addTypography(
				$prefix . 'font_banner_sub_title',
				array(
					'name' => __( 'Sub Title (H2)', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'verdana',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);

			$meta_banner_content->addTypography( // was: text_color = text color
				$prefix . 'font_banner_text',
				array(
					'name' => __( 'Text', 'offtheshelf' ),
					'std'  => array(
						'face'   => 'verdana',
						'weight' => 'regular',
						'size'   => '13px',
						'color'  => '#000000'
					)
				)
			);


			$meta_banner_content->addCheckbox( $prefix . 'banner_full_width', array(
				'name'    => __( 'Full Width', 'offtheshelf' ),
				'caption' => __( 'Render the banner in full width, for use with sliders or other third party plug-ins', 'offtheshelf' ),
				'std'     => false,
				'class'   => 'no-fancy',
				'desc'    => __( 'If this option is checked, the banner will use 100% of the available window width.', 'offtheshelf' )
			) );
			$meta_banner_content->Finish();


			/*
			 * Meta Box: Advanced
			 */
			$config        = array(
				'id'             => 'offtheshelf_profile_advanced',
				'title'          => __( 'Advanced', 'offtheshelf' ),
				'pages'          => array( 'profile' ),
				'context'        => 'normal',
				'priority'       => 'default',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_advanced = new SR_Meta_Box( $config );

			if ( function_exists ( 'offtheshelf_shortcode_option' ) ) {
				$meta_advanced->addTextarea( $prefix . 'advanced_shortcodes', array(
					'name'           => __( 'Customization Shortcodes', 'offtheshelf' ),
					'label_location' => 'top',
					'desc'           => __( 'Use advanced customization shortcodes to modify theme options and replace sections.', 'offtheshelf' ),
					'rows'           => '10'
				) );
			}

			$meta_advanced->addTextarea( $prefix . 'advanced_profile_custom_css', array(
				'name'           => __( 'Custom CSS', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'Custom CSS code to be added to the page header.', 'offtheshelf' ),
				'rows'           => '10'
			) );
			$meta_advanced->addTextarea( $prefix . 'advanced_profile_custom_scripts', array(
				'name'           => __( 'Custom Scripts', 'offtheshelf' ),
				'label_location' => 'top',
				'desc'           => __( 'Custom scripts to be added to the page header.', 'offtheshelf' ),
				'rows'           => '10'
			) );
			$meta_advanced->Finish();


			/*
			 * Meta Box: Modal Windows - Options
 			*/
			$config             = array(
				'id'             => 'offtheshelf_page_modal',
				'title'          => __( 'Options', 'offtheshelf' ),
				'pages'          => array( 'modal' ),
				'context'        => 'normal',
				'priority'       => 'high',
				'fields'         => array(),
				'local_images'   => false,
				'use_with_theme' => get_template_directory_uri() . '/lib/admin'
			);
			$meta_modal_options = new SR_Meta_Box( $config );
			$meta_modal_options->addSelect( $prefix . 'modal_render_mode', array(
				'content'     => __( 'Modal Content (w/ Basic Content Filters)', 'offtheshelf' ),
				'raw'         => __( 'Modal Content (Raw HTML/Text)', 'offtheshelf' ),
				'oembed'      => __( 'Modal Content (oEmbed URL)', 'offtheshelf' ),
				'pagebuilder' => __( 'Page Builder (Experimental)', 'offtheshelf' ),
			), array( 'name' => __( 'Content', 'offtheshelf' ), 'std' => 'content', 'class' => 'no-fancy' ) );
			$meta_modal_options->addColor( $prefix . 'modal_background', array(
				'name' => __( 'Background Color', 'offtheshelf' ),
				'std'  => '#ffffff'
			) );
			$meta_modal_options->addColor( $prefix . 'modal_text', array(
				'name' => __( 'Text Color', 'offtheshelf' ),
				'std'  => '#000000'
			) );
			//$meta_modal_options->addTextarea( $prefix . 'modal_custom_css', array( 'name' => __( 'Custom CSS', 'offtheshelf' ), 'label_location' => 'top', 'desc' => __( 'Custom CSS to be applied to this modal window.', 'offtheshelf' ), 'rows' => '10' ) );
			$meta_modal_options->Finish();
		}


		/* *******************************************************************************
		 * Theme Options Panel
		   *******************************************************************************/

		/**
		 * Set up main theme options page
		 */
		$config = array(
			'menu'           => 'theme',
			//sub page to settings page
			'page_title'     => __( 'Theme Options', 'offtheshelf' ),
			//The name of this page
			'icon_url'       => 'div',
			'capability'     => 'edit_theme_options',
			// The capability needed to view the page
			'option_group'   => 'offtheshelf_options',
			//the name of the option to create in the database
			'id'             => 'offtheshelf_admin_page',
			// meta box id, unique per page
			'fields'         => array(),
			// list of fields (can be added by field arrays)
			'local_images'   => false,
			// Use local or hosted images (meta box images for add/remove)
			'use_with_theme' => get_template_directory_uri() . '/lib/admin',
			//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'google_fonts'   => true
		);


		$options_panel = new SR_Admin_Page( $config );
		$options_panel->OpenTabs_container( '' );

		$global_tabs = array();

		$global_tabs['general'] = __( 'General', 'offtheshelf' );

		$global_tabs['blog']    = __( 'Blog', 'offtheshelf' );
		$global_tabs['mailing'] = __( 'Forms', 'offtheshelf' );

		if ( function_exists( 'is_woocommerce' ) ) {
			$global_tabs['woocommerce'] = __( 'WooCommerce', 'offtheshelf' );
		}


		if ( function_exists( 'siteorigin_panels_render' ) ) {
			$global_tabs['pagebuilder'] = __( 'Page Builder', 'offtheshelf' );
		}

		$global_tabs['advanced'] = __( 'Advanced', 'offtheshelf' );

		$global_tabs['export'] = __( 'Export', 'offtheshelf' );


		if ( ! offtheshelf_hide_support_links() ) {
			$global_tabs['about'] = __( 'Support', 'offtheshelf' );
		}


		$options_panel->TabsListing( array(
			'links' => $global_tabs
		) );


		/*
		 * About
		 */
		if ( ! offtheshelf_hide_support_links() ) {

			$options_panel->OpenTab( 'about' );
			$options_panel->Title( __( "About Off the Shelf", 'offtheshelf' ) );


			$options_panel->Subtitle( __( "Theme", 'offtheshelf' ) );

			$options_panel->addParagraph( sprintf( __( 'Off the Shelf is a multi-purpose online marketing and lead generation theme by <a href="%1$s" target="_blank">ShapingRain.com</a>.', 'offtheshelf' ), esc_url( 'http://www.shapingrain.com' ) ) );

			if ( is_child_theme() ) {
				$options_panel->addTextLabel( 'theme_version', array(
					'name'  => __( "Installed Version", 'offtheshelf' ),
					'value' => OFFTHESHELF_THEME_VERSION . __( " (Parent Theme)", 'offtheshelf' )
				) );
			} else {
				$options_panel->addTextLabel( 'theme_version', array(
					'name'  => __( "Installed Version", 'offtheshelf' ),
					'value' => OFFTHESHELF_THEME_VERSION
				) );
			}


			$options_panel->Subtitle( __( "License", 'offtheshelf' ) );
			$options_panel->addText( 'license_key', array(
					'name' => __( 'ShapingRain License Key', 'offtheshelf' ),
					'desc' => __( 'This is the ShapingRain License Key as obtained from ShapingRain.com. It does not equal the Envato Item Purchase Code.', 'offtheshelf' ),
					'std'  => ''
			) );

			$options_panel->addButton( 'license_key_register', array(
					'caption' => __( "Verify new license key", 'offtheshelf' ),
					'href'    => admin_url('themes.php?page=offtheshelf-register&from=setup')
			) );


			$options_panel->Subtitle( esc_html__( "Customer Support", 'offtheshelf' ) );
			$options_panel->addParagraph( sprintf( offtheshelf_esc_html( __( 'With your purchase of Off the Shelf you have access to free premium support <a href="%1$s" target="_blank">via email</a>. We do not provide support via the comments section on themeforest.', 'offtheshelf' ) ), esc_url( 'https://shapingrain.zendesk.com/hc/en-us/requests/new'  ) ) );
			$options_panel->addCheckbox( 'support_options_debugging', array(
					'name'           => esc_html__( 'Allow Option Changes', 'offtheshelf' ),
					'caption'        => esc_html__( 'Allow overwriting of theme options via debugging GET variables', 'offtheshelf' ),
					'desc'           => esc_html__( 'If this option is checked, the theme will allow users to allow GET variables in the browser\'s address bar to overwrite theme options. Use with care and disable when not used.', 'offtheshelf' ),
					'class'          => 'no-toggle',
					'std'            => false,
					'group-selector' => true
			) );
			$options_panel->addTextarea( 'support_options_debugging_allowed_parameters', array(
					'name'        => esc_html__( 'Allowed Parameters', 'offtheshelf' ),
					'desc'        => esc_html__( 'Only options listed here, one per line, can be overwritten using GET variables', 'offtheshelf' ),
					'std'         => '',
					'is-group'    => 'support_options_debugging',
					'group-value' => array( 'checked' )
			) );
			$options_panel->addText( 'support_options_debugging_token', array(
					'name'        => esc_html__( 'Support Access Token', 'offtheshelf' ),
					'desc'        => esc_html__( 'You must provide this token to support, if requested, to enable them to overwrite options using GET variables', 'offtheshelf' ),
					'std'         => offtheshelf_generate_random_string(),
					'is-group'    => 'support_options_debugging',
					'group-value' => array( 'checked' )
			) );
			$options_panel->addCheckbox( 'support_options_dev_mode', array(
					'name'    => esc_html__( 'Development Mode', 'offtheshelf' ),
					'caption' => esc_html__( 'Enable development mode', 'offtheshelf' ),
					'desc'    => esc_html__( 'Enable additional options for developers.', 'offtheshelf' ),
					'class'   => 'no-toggle',
					'std'     => false
			) );

			$options_panel->CloseTab();
		}


		/*
		 * General Settings
 		*/
		$options_panel->OpenTab( 'general' );

		$options_panel->Title( esc_html__( "General Settings", 'offtheshelf' ) );

		$options_panel->Subtitle( esc_html__( "Layout and Design", 'offtheshelf' ) );

		if ( defined ('OFFTHESHELF_FEATURE_PACK') ) {
			$options_panel->addPosts( 'default_profile', array( 'post_type' => 'profile' ), array(
				'name'  => esc_html__( 'Default Profile', 'offtheshelf' ),
				'desc'  => esc_html__( 'A profile is a set of setings, e.g. colours, background images, social profiles etc. that can be applied to the entire site or specific pages. This settings profile will be used when no profile is selected for a particular page, as well as for the blog and all pages generated by third-party plug-ins.', 'offtheshelf' ),
				'class' => 'no-fancy',
				'none'  => false
			) );
			$options_panel->addPosts( 'default_banner', array( 'post_type' => 'banner' ), array(
				'class' => 'no-fancy',
				'name'  => esc_html__( 'Default Banner', 'offtheshelf' ),
				'desc'  => esc_html__( 'If a banner is selected, that banner will be used for all pages for which no individual banner has been selected.', 'offtheshelf' )
			) );
		}

		// button styles
		$repeater_fields = array();

		$repeater_fields[] = $options_panel->addText( 'name', array(
			'name'  => esc_html__( 'Name', 'offtheshelf' ),
			'class' => 'widefat at-block-title-input'
		), true );
		$repeater_fields[] = $options_panel->addUid( 'uid', array( 'name' => esc_html__( 'Unique ID', 'offtheshelf' ) ), true );
		$repeater_fields[] = $options_panel->addTypography(
			'font',
			array(
				'name' => esc_html__( 'Font', 'offtheshelf' ),
				'std'  => array(
					'face'   => 'helvetica',
					'weight' => 'regular',
					'size'   => '13px',
					'color'  => false
				)
			),
			true
		);
		$repeater_fields[] = $options_panel->addCheckbox( 'force_fonts', array(
			'name'    => esc_html__( 'Apply fonts to default', 'offtheshelf' ),
			'caption' => esc_html__( 'Enforce font styles to be used for default button style.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => 0
		), true );
		$repeater_fields[] = $options_panel->addCheckbox( 'shadow', array(
			'name'    => esc_html__( 'Shadow', 'offtheshelf' ),
			'caption' => esc_html__( 'Add drop shadow to buttons.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => 0
		), true );
		$repeater_fields[] = $options_panel->addCheckbox( 'border', array(
			'name'    => esc_html__( 'Border', 'offtheshelf' ),
			'caption' => esc_html__( 'Add a border around the button.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => 0
		), true );

		$repeater_fields[] = $options_panel->addText(
			'radius',
			array(
				'name'       => esc_html__( 'Rounded Corners', 'offtheshelf' ),
				'std'        => '5',
				'class'      => 'no-fancy',
				'validate'   => array(
					'numeric' => array(
						'param'   => '',
						'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
					)
				),
				'field_type' => 'number',
				'text_after' => 'px',
			),
			true
		);

		// button default state
		$repeater_fields[] = $options_panel->addSection( esc_html__( 'Default State', 'offtheshelf' ), array(), true );

		$repeater_fields[] = $options_panel->addSelect( 'default_background_mode', array(
			'solid'       => esc_html__( 'Solid Color', 'offtheshelf' ),
			'gradient'    => esc_html__( 'Gradient', 'offtheshelf' ),
			'transparent' => esc_html__( 'Transparent', 'offtheshelf' )
		), array(
			'name'           => esc_html__( 'Background Mode (Default)', 'offtheshelf' ),
			'std'            => 'solid',
			'class'          => 'no-fancy',
			'group-selector' => true
		), true );

		$repeater_fields[] = $options_panel->addColor( 'default_color_1', array(
			'name' => esc_html__( 'Color 1', 'offtheshelf' ),
			'std'  => '#ffffff'
		), true );
		$repeater_fields[] = $options_panel->addColor( 'default_color_2', array(
			'name'        => esc_html__( 'Color 2', 'offtheshelf' ),
			'std'         => '#ffffff',
			'is-group'    => 'default_background_mode',
			'group-value' => array( 'gradient' )
		), true );

		$repeater_fields[] = $options_panel->addColor( 'default_color_text', array(
			'name' => esc_html__( 'Text Color', 'offtheshelf' ),
			'std'  => '#ffffff'
		), true );

		// button hover state
		$repeater_fields[] = $options_panel->addSection( esc_html__( 'Hover State', 'offtheshelf' ), array(), true );

		$repeater_fields[] = $options_panel->addSelect( 'hover_background_mode', array(
			'solid'       => esc_html__( 'Solid Color', 'offtheshelf' ),
			'gradient'    => esc_html__( 'Gradient', 'offtheshelf' ),
			'transparent' => esc_html__( 'Transparent', 'offtheshelf' )
		), array(
			'name'           => esc_html__( 'Background Mode (Default)', 'offtheshelf' ),
			'std'            => 'solid',
			'class'          => 'no-fancy',
			'group-selector' => true
		), true );

		$repeater_fields[] = $options_panel->addColor( 'hover_color_1', array(
			'name' => esc_html__( 'Color 1', 'offtheshelf' ),
			'std'  => '#ffffff'
		), true );
		$repeater_fields[] = $options_panel->addColor( 'hover_color_2', array(
			'name'        => esc_html__( 'Color 2', 'offtheshelf' ),
			'std'         => '#ffffff',
			'is-group'    => 'hover_background_mode',
			'group-value' => array( 'gradient' )
		), true );

		$repeater_fields[] = $options_panel->addColor( 'hover_color_text', array(
			'name' => esc_html__( 'Text Color', 'offtheshelf' ),
			'std'  => '#ffffff'
		), true );


		$options_panel->addRepeaterBlock(
			'global_button_styles',
			array(
				'sortable'       => true,
				'inline'         => false,
				'name'           => esc_html__( 'Button Styles', 'offtheshelf' ),
				'fields'         => $repeater_fields,
				'desc'           => esc_html__( 'Add, edit and re-order button styles.', 'offtheshelf' ),
				'label_location' => 'none'
			)
		);


		/*
		 * Embedded Media Responsiveness
		 */
		$options_panel->Subtitle( esc_html__( "Embedded Media Responsiveness", 'offtheshelf' ) );
		$options_panel->addCheckbox( 'content_responsive_images', array(
			'name'    => esc_html__( 'Content Section', 'offtheshelf' ),
			'caption' => esc_html__( 'Remove width and height attributes from all images in content section', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, the theme will remove all static width and height attributes from thumbnails, featured images, gallery images etc., for responsiveness.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );
		$options_panel->addCheckbox( 'content_responsive_videos', array(
			'name'    => esc_html__( 'Embedded Media', 'offtheshelf' ),
			'caption' => esc_html__( 'Remove width and height attributes from supported embedded media', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, the theme will remove all static width and height attributes from media embeds, for responsiveness.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );

		/*
		 * Theme Features
		 */
		$options_panel->Subtitle( esc_html__( "Theme Features", 'offtheshelf' ) );
		$options_panel->addCheckbox( 'content_page_comments', array(
			'name'    => esc_html__( 'Page Comments', 'offtheshelf' ),
			'caption' => esc_html__( 'Enable comments for pages', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, a comment form will be displayed underneath pages, if comments are active for that page.', 'offtheshelf' ),
			'std'     => false
		) );


		/*
		 * Web Fonts
		 */
		$options_panel->Subtitle( esc_html__( "Web Fonts", 'offtheshelf' ) );

		$subsets = array(
			'latin'        => esc_html__( 'Latin', 'offtheshelf' ),
			'latin-ext'    => esc_html__( 'Latin (Extended)', 'offtheshelf' ),
			'menu'         => esc_html__( 'Menu', 'offtheshelf' ),
			'greek'        => esc_html__( 'Greek', 'offtheshelf' ),
			'greek-ext'    => esc_html__( 'Greek (Extended)', 'offtheshelf' ),
			'cyrillic'     => esc_html__( 'Cyrillic', 'offtheshelf' ),
			'cyrillic-ext' => esc_html__( 'Cyrillic (Extended)', 'offtheshelf' ),
			'vietnamese'   => esc_html__( 'Vietnamese', 'offtheshelf' ),
			'arabic'       => esc_html__( 'Arabic', 'offtheshelf' ),
			'khmer'        => esc_html__( 'Khmer', 'offtheshelf' ),
			'lao'          => esc_html__( 'Lao', 'offtheshelf' ),
			'tamil'        => esc_html__( 'Tamil', 'offtheshelf' ),
			'bengali'      => esc_html__( 'Bengali', 'offtheshelf' ),
			'hindi'        => esc_html__( 'Hindi', 'offtheshelf' ),
			'korean'       => esc_html__( 'Korean', 'offtheshelf' )
		);
		$options_panel->addCheckboxList( 'web_fonts_subsets',
			$subsets,
			array(
				'name'  => 'Google Web Fonts Subsets',
				'std'   => array( 'latin' ),
				'class' => 'no-fancy',
				'desc'  => esc_html__( 'Select which subsets should be loaded. Subsets are only applied when the selected fonts support the selection.', 'offtheshelf' )
			)
		);


		$repeater_fields = array();

		$repeater_fields[] = $options_panel->addText( 'name', array(
			'name'  => esc_html__( 'Display Name', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This name will be displayed in the font selection interface. It serves no other function.', 'offtheshelf' )
		), true );
		$repeater_fields[] = $options_panel->addText( 'face_name', array(
			'name'  => esc_html__( 'Font Face Name', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This name will be used in the font-face CSS attribute to identify the font.', 'offtheshelf' )
		), true );
		$repeater_fields[] = $options_panel->addText( 'face_fallback', array(
			'name'  => esc_html__( 'Font Face Fallback', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'Comma-separated and escaped list of fallback fonts to be used.', 'offtheshelf' ),
			'std'   => 'Helvetica, sans-serif'
		), true );
		$repeater_fields[] = $options_panel->addText( 'url_eot', array(
			'name'  => esc_html__( 'EOT URL', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This is the URL pointing to the .eot (Open Type) file.', 'offtheshelf' )
		), true );
		$repeater_fields[] = $options_panel->addText( 'url_woff', array(
			'name'  => esc_html__( 'WOFF  URL', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This is the URL pointing to the .woff (Web Open Font Format) file.', 'offtheshelf' )
		), true );
		$repeater_fields[] = $options_panel->addText( 'url_ttf', array(
			'name'  => esc_html__( 'TTF  URL', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This is the URL pointing to the .ttf (True Type Font) file.', 'offtheshelf' )
		), true );
		$repeater_fields[] = $options_panel->addText( 'url_svg', array(
			'name'  => esc_html__( 'SVG  URL', 'offtheshelf' ),
			'class' => 'widefat',
			'desc'  => esc_html__( 'This is the URL pointing to the .svg (Scalable Vector Graphics Font) file.', 'offtheshelf' )
		), true );

		$options_panel->addRepeaterBlock( 'web_fonts_custom', array(
			'sortable' => true,
			'inline'   => false,
			'name'     => esc_html__( 'Custom Web Fonts', 'offtheshelf' ),
			'fields'   => $repeater_fields,
			'desc'     => esc_html__( 'This feature enables you to use compatible web font files from external sources. The fonts database needs to be refreshed after each change.', 'offtheshelf' )
		) );

		$options_panel->addButton( 'web_fonts_refresh', array(
			'name'    => esc_html__( "Update Database", 'offtheshelf' ),
			'caption' => esc_html__( "Refresh Web Fonts Database", 'offtheshelf' ),
			'desc'    => esc_html__( "Retrieve and process new web fonts and write changes to the database. If new fonts are added, this will make them available to the theme.", 'offtheshelf' )
		) );

		$options_panel->CloseTab();

		/*
		 * Blog Settings
		 */

		$options_panel->OpenTab( 'blog' );

		$options_panel->Title( esc_html__( "Blog Settings", 'offtheshelf' ) );


		if ( defined ('OFFTHESHELF_FEATURE_PACK') ) {
			$options_panel->Subtitle( esc_html__( "General", 'offtheshelf' ) );

			$options_panel->addPosts( 'default_profile_blog', array( 'post_type' => 'profile' ), array(
				'name'  => esc_html__( 'Blog Default Profile', 'offtheshelf' ),
				'desc'  => esc_html__( 'This settings profile will be used for the blog, including all archives. If no profile is selected, the site\'s default profile will be used.', 'offtheshelf' ),
				'class' => 'no-fancy',
				'none'  => false
			) );
			$options_panel->addPosts( 'default_banner_blog', array( 'post_type' => 'banner' ), array(
				'name'  => esc_html__( 'Blog Default Banner', 'offtheshelf' ),
				'desc'  => esc_html__( 'This overrides the default profile\'s banner setting and displays the selected banner on every blog page by default. If no selection is made, the profile\'s banner will be used instead, if set.', 'offtheshelf' ),
				'class' => 'no-fancy',
				'none'  => false
			) );
		}

		$options_panel->Subtitle( esc_html__( "Layout", 'offtheshelf' ) );

		$blog_layout_list = array(
			'minimal'  => array(
				'label' => esc_html__( 'List (Minimal)', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_minimal.png'
			),
			'medium'   => array(
				'label' => esc_html__( 'List (Medium)', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_list_medium.png'
			),
			'list'     => array(
				'label' => esc_html__( 'List (Large)', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_list_default.png'
			),
			'grid'     => array(
				'label' => esc_html__( 'Grid', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_grid.png'
			),
			'masonry'  => array(
				'label' => esc_html__( 'Masonry', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_masonry.png'
			),
			'timeline' => array(
				'label' => esc_html__( 'Timeline', 'offtheshelf' ),
				'image' => SR_ADMIN_URL . '/images/icons/blog-layouts/layout_timeline.png'
			)
		);

		$timeline_group_display_options = array(
			'day'   => esc_html__( 'Day', 'offtheshelf' ),
			'month' => esc_html__( 'Month', 'offtheshelf' ),
			'year'  => esc_html__( 'Year', 'offtheshelf' )
		);

		$options_panel->addSelect( 'blog_layout',
			$blog_layout_list,
			array(
				'name'           => 'Blog Layout',
				'std'            => 'list',
				'image-picker'   => true,
				'desc'           => esc_html__( 'This layout is used for the blog index page.', 'offtheshelf' ),
				'group-selector' => true
			)
		);

		$options_panel->addSelect( 'blog_timeline_group_by',
			$timeline_group_display_options,
			array(
				'name'        => 'Group Posts By',
				'std'         => '3',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Select whether you would like posts to be grouped by day or month.', 'offtheshelf' ),
				'is-group'    => 'blog_layout',
				'group-value' => array( 'timeline' )
			)
		);

		$options_panel->addSelect( 'blog_grid_columns',
			array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			array(
				'name'        => 'Columns per Row',
				'std'         => '3',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Amount of columns per row for blog index pages.', 'offtheshelf' ),
				'is-group'    => 'blog_layout',
				'group-value' => array( 'grid', 'masonry' )
			)
		);

		$options_panel->addSelect( 'blog_archive_layout',
			$blog_layout_list,
			array(
				'name'           => 'Archive Layout',
				'std'            => 'list',
				'image-picker'   => true,
				'desc'           => esc_html__( 'This layout is used for all archives, e.g. category, tag and author archives.', 'offtheshelf' ),
				'group-selector' => true
			)
		);

		$options_panel->addSelect( 'blog_archive_timeline_group_by',
			$timeline_group_display_options,
			array(
				'name'        => 'Group Posts By',
				'std'         => '3',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Select whether you would like posts to be grouped by day or month.', 'offtheshelf' ),
				'is-group'    => 'blog_archive_layout',
				'group-value' => array( 'timeline' )
			)
		);

		$options_panel->addSelect( 'blog_archive_grid_columns',
			array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			array(
				'name'        => 'Columns per Row',
				'std'         => '3',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Amount of columns per row for all archives.', 'offtheshelf' ),
				'is-group'    => 'blog_archive_layout',
				'group-value' => array( 'grid', 'masonry' )
			)
		);

		$options_panel->Subtitle( esc_html__( "Custom Headlines", 'offtheshelf' ) );

		$options_panel->addText( 'blog_headline', array(
			'name' => esc_html__( 'Blog Headline', 'offtheshelf' ),
			'desc' => esc_html__( 'This headline is displayed on all blog index pages (posts page or front page, if set to display the blog).', 'offtheshelf' ),
			'std'  => ''
		) );
		$options_panel->addText( 'blog_archive_headline', array(
			'name' => esc_html__( 'Archive Headline (Prefix)', 'offtheshelf' ),
			'desc' => esc_html__( 'This headline is displayed on all blog archives.', 'offtheshelf' ),
			'std'  => ''
		) );

		$options_panel->Subtitle( esc_html__( "Content", 'offtheshelf' ) );

		$display_mode_options = array(
			'excerpt' => esc_html__( 'Excerpt', 'offtheshelf' ),
			'full'    => esc_html__( 'Full Post', 'offtheshelf' ),
		);

		$options_panel->addSelect(
			'blog_content_mode_index',
			$display_mode_options,
			array(
				'name'        => 'List View (Index Pages)',
				'std'         => 'excerpt',
				'desc'        => esc_html__( 'This sets the display mode applied to posts displayed on index pages, such as a blog set as the front page, or a static posts page.', 'offtheshelf' ),
				'is-group'    => 'blog_layout',
				'group-value' => array( 'minimal', 'list', 'medium' )
			) );

		$options_panel->addSelect(
			'blog_content_mode_archive',
			$display_mode_options,
			array(
				'name'        => 'List View (Archives)',
				'std'         => 'excerpt',
				'desc'        => esc_html__( 'This sets the display mode applied to posts displayed on archive pages, such as category or tag archives.', 'offtheshelf' ),
				'is-group'    => 'blog_archive_layout',
				'group-value' => array( 'minimal', 'list', 'medium' )
			) );

		$options_panel->addText(
			'blog_excerpt_length',
			array(
				'name'       => esc_html__( 'Excerpt Length', 'offtheshelf' ),
				'std'        => '25',
				'validate'   => array(
					'numeric' => array(
						'param'   => '',
						'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
					)
				),
				'desc'       => esc_html__( 'This defines the length of excerpts as displayed on blog index and archive pages, in words.', 'offtheshelf' ),
				'text_after' => esc_html__( 'words', 'offtheshelf' ),
				'field_type' => 'number'
			)
		);

		$options_panel->addCheckbox( 'blog_related_posts', array(
			'name'    => esc_html__( 'Related Posts', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, related posts will be displayed underneath single page comments.', 'offtheshelf' ),
			'caption' => esc_html__( 'Display related posts', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );


		$options_panel->Subtitle( esc_html__( "Sidebars", 'offtheshelf' ) );

		$options_panel->addCheckbox( 'blog_sidebar_front', array(
			'name'    => esc_html__( 'Index Page', 'offtheshelf' ),
			'caption' => esc_html__( 'Display sidebar on index page', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, a sidebar will be displayed on post index pages, that is a blog set as the front page, or a static posts page.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );
		$options_panel->addCheckbox( 'blog_sidebar_archives', array(
			'name'    => esc_html__( 'Archive Pages', 'offtheshelf' ),
			'caption' => esc_html__( 'Display sidebar on archive pages', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, a sidebar will be displayed on post archive pages, e.g. category and tag archives.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );
		$options_panel->addCheckbox( 'blog_sidebar_posts', array(
			'name'    => esc_html__( 'Single Post Pages', 'offtheshelf' ),
			'caption' => esc_html__( 'Display sidebar on single post pages', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, a sidebar will be displayed on single post pages.', 'offtheshelf' ),
			'class'   => 'no-toggle',
			'std'     => true
		) );

		$options_panel->addSelect( 'blog_sidebar_position',
			array(
				'left'  => esc_html__( 'left', 'offtheshelf' ),
				'right' => esc_html__( 'right', 'offtheshelf' )
			),
			array(
				'name'  => 'Sidebar Position',
				'std'   => 'right',
				'class' => 'no-fancy',
				'desc'  => esc_html__( 'Select where you would like the sidebar to be displayed.', 'offtheshelf' )
			)
		);

		$options_panel->Subtitle( esc_html__( "Navigation", 'offtheshelf' ) );

		$nav_types = array(
			false      => esc_html__( 'None (only first page)', 'offtheshelf' ),
			'numeric'  => esc_html__( 'Numeric (1...10)', 'offtheshelf' ),
			'nextprev' => esc_html__( 'Older posts/newer posts', 'offtheshelf' )
		);


		$options_panel->addSelect( 'blog_posts_navigation',
			$nav_types,
			array(
				'name'    => 'Blog',
				'caption' => 'Posts navigation on blog',
				'std'     => 'nextprev',
				'class'   => 'no-fancy',
				'desc'    => esc_html__( 'Define which posts navigation type you would like to use for blog index pages.', 'offtheshelf' )
			)
		);

		$options_panel->addSelect( 'archive_posts_navigation',
			$nav_types,
			array(
				'name'    => 'Archives',
				'caption' => 'Posts navigation on archive pages',
				'std'     => 'nextprev',
				'class'   => 'no-fancy',
				'desc'    => esc_html__( 'Define which posts navigation type you would like to use for blog archive pages, such as the category and author archives.', 'offtheshelf' )
			)
		);

		$options_panel->Subtitle( esc_html__( "Social Sharing", 'offtheshelf' ) );

		$options_panel->addCheckbox( 'blog_share_enabled', array(
			'name'           => esc_html__( 'Blog Posts', 'offtheshelf' ),
			'caption'        => esc_html__( 'Enable social sharing icons for blog posts', 'offtheshelf' ),
			'class'          => 'no-toggle',
			'std'            => true,
			'group-selector' => true
		) );

		$share_options = array(
			'facebook'    => esc_html__( 'Facebook', 'offtheshelf' ),
			'twitter'     => esc_html__( 'Twitter', 'offtheshelf' ),
			'googleplus'  => esc_html__( 'Google+', 'offtheshelf' ),
			'tumblr'      => esc_html__( 'Tumblr', 'offtheshelf' ),
			'pinterest'   => esc_html__( 'Pinterest', 'offtheshelf' ),
			'linkedin'    => esc_html__( 'LinkedIn', 'offtheshelf' ),
			'reddit'      => esc_html__( 'reddit', 'offtheshelf' ),
			'stumbleupon' => esc_html__( 'StumbleUpon', 'offtheshelf' ),
			'vk'          => esc_html__( 'VK', 'offtheshelf' ),
		);

		$share_options = apply_filters( 'offtheshelf_share_icons', $share_options );

		$style_types = array(
			'transparent' => esc_html__( 'Transparent', 'offtheshelf' ),
			'white'       => esc_html__( 'White', 'offtheshelf' ),
			'black'       => esc_html__( 'Black', 'offtheshelf' ),
			'color'       => esc_html__( 'Solid Color', 'offtheshelf' )
		);
		$options_panel->addSelect( 'blog_share_style',
			$style_types,
			array(
				'name'        => 'Style',
				'caption'     => 'Icon style',
				'std'         => 'transparent',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Select which style you would like to use for the sharing icons. This setting can be overwritten by widget settings.', 'offtheshelf' ),
				'is-group'    => 'blog_share_enabled',
				'group-value' => array( 'checked' )
			)
		);

		$sizes = array(
			'1' => esc_html__( 'Tiny', 'offtheshelf' ),
			'2' => esc_html__( 'Small', 'offtheshelf' ),
			'3' => esc_html__( 'Medium', 'offtheshelf' ),
			'4' => esc_html__( 'Large', 'offtheshelf' )
		);
		$options_panel->addSelect( 'blog_share_size',
			$sizes,
			array(
				'name'        => 'Size',
				'caption'     => 'Icon size',
				'std'         => '1',
				'class'       => 'no-fancy',
				'desc'        => esc_html__( 'Select a size for the sharing icons. This setting can be overwritten by widget settings.', 'offtheshelf' ),
				'is-group'    => 'blog_share_enabled',
				'group-value' => array( 'checked' )
			)
		);


		$options_panel->addCheckboxList( 'blog_share_options',
			$share_options,
			array(
				'name'        => 'Display icons for these share-enabled services',
				'std'         => array( 'facebook', 'googleplus', 'twitter' ),
				'class'       => 'no-fancy',
				'is-group'    => 'blog_share_enabled',
				'group-value' => array( 'checked' ),
				'desc'        => esc_html__( 'Select which icons you would like to display. These icons will be added to the end of your blog posts if social sharing icons are enabled. Please note that not all social networks have an option to share posts.', 'offtheshelf' ),
				'sortable'    => true
			)
		);

		$options_panel->addText( 'blog_share_custom',
			array(
				'name'        => esc_html__( 'Custom Shortcode', 'offtheshelf' ),
				'desc'        => esc_html__( 'If not empty, the content of this field will be parsed for shortcodes and the output added after your post content instead of the built-in social sharing icons.', 'offtheshelf' ),
				'std'         => '',
				'is-group'    => 'blog_share_enabled',
				'group-value' => array( 'checked' ),
			)
		);

		$options_panel->CloseTab();

		/*
		 * Mailing List Services
		 */
		$options_panel->OpenTab( 'mailing' );
		$options_panel->Title( esc_html__( "Mailing Lists and Forms", 'offtheshelf' ) );

		$options_panel->Subtitle( esc_html__( "Embed Codes", 'offtheshelf' ) );

		$options_panel->addParagraph( offtheshelf_esc_html( __( 'This section allows you to enter third party HTML embed/integration code to be used globally with the OtS Opt-In widget. This enables the integration of popular third party mailing list services like MailChimp and AWeber.<br />Contact Form 7 and Gravity Forms are also supported, for contact forms, and they come with their own native and custom widgets.', 'offtheshelf' ) ) );

		$options_panel->addNonce( 'clean_form', array() );

		$repeater_fields = array();

		$repeater_fields[] = $options_panel->addText( 'form_name', array(
			'name'  => esc_html__( 'Name', 'offtheshelf' ),
			'desc'  => esc_html__( 'This name helps you identify your forms.', 'offtheshelf' ),
			'class' => 'widefat'
		), true );
		$repeater_fields[] = $options_panel->addTextarea( 'form_code', array(
			'name'  => esc_html__( 'HTML Embed Code', 'offtheshelf' ),
			'desc'  => esc_html__( 'This field contains plain HTML, just the form tag and the form fields, no additional scripts, styling, labels, wrappers etc.; the Clean Form Code button sanitizes the form input and removes unnecessary mark-up from the raw embed code.', 'offtheshelf' ),
			'class' => 'widefat',
			'form'  => true,
			'code'  => true
		), true );
		$repeater_fields[] = $options_panel->addUid( 'form_uid', array( 'name' => esc_html__( 'Unique ID', 'offtheshelf' ) ), true );

		$options_panel->addRepeaterBlock( 'forms', array(
			'sortable' => false,
			'inline'   => false,
			'name'     => esc_html__( 'Forms', 'offtheshelf' ),
			'fields'   => $repeater_fields,
			'desc'     => esc_html__( 'Create as many forms as you need. Forms can be used in sidebar widgets or within the page builder they can be contact or sign-up forms.', 'offtheshelf' )
		) );


		$options_panel->CloseTab();


		/*
		 * WooCommerce Settings
		 */

		if ( function_exists( 'is_woocommerce' ) ) {
			$options_panel->OpenTab( 'woocommerce' );
			$options_panel->Title( esc_html__( "WooCommerce Settings", 'offtheshelf' ) );

			$options_panel->Subtitle( esc_html__( "General", 'offtheshelf' ) );

			if ( defined ('OFFTHESHELF_FEATURE_PACK') ) {
				$options_panel->addPosts( 'default_profile_woocommerce', array( 'post_type' => 'profile' ), array(
					'name'  => esc_html__( 'WC Default Profile', 'offtheshelf' ),
					'desc'  => esc_html__( 'This settings profile will be used for all WooCommerce pages. If no profile is selected, the site\'s default profile will be used.', 'offtheshelf' ),
					'class' => 'no-fancy',
					'none'  => false
				) );
				$options_panel->addPosts( 'default_banner_woocommerce', array( 'post_type' => 'banner' ), array(
					'name'  => esc_html__( 'WC Default Banner', 'offtheshelf' ),
					'desc'  => esc_html__( 'This overrides the default profile\'s banner setting and displays the selected banner on every WooCommerce page by default. If no selection is made, the profile\'s banner will be used instead, if set.', 'offtheshelf' ),
					'class' => 'no-fancy',
					'none'  => false
				) );
			}

			$options_panel->addCheckbox( 'enable_woocommerce_header_cart', array(
				'name'    => esc_html__( 'Shopping Cart', 'offtheshelf' ),
				'caption' => esc_html__( 'Enable WooCommerce shopping cart in header', 'offtheshelf' ),
				'desc'    => esc_html__( 'If this option is checked, a shopping cart icon with a shopping cart widget will be placed in the header.', 'offtheshelf' ),
				'std'     => true
			) );

			$options_panel->Subtitle( esc_html__( "Layout", 'offtheshelf' ) );

			$options_panel->addSelect( 'woocommerce_grid_columns',
				array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				array(
					'name'  => 'Columns per Row',
					'std'   => '3',
					'class' => 'no-fancy',
					'desc'  => esc_html__( 'Amount of columns to display per row.', 'offtheshelf' )
				)
			);

			$options_panel->addText(
				'woocommerce_products_per_page',
				array(
					'name'       => esc_html__( 'Products per Page', 'offtheshelf' ),
					'std'        => '12',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'This defines how many products are displayed per page. This option applies to all product lists, on index and archive pages, in search results and related products.', 'offtheshelf' ),
					'field_type' => 'number'
				)
			);

			$options_panel->Subtitle( esc_html__( "Sidebar", 'offtheshelf' ) );

			$options_panel->addSelect( 'woocommerce_sidebar_position',
				array(
					false           => esc_html__( 'No Sidebar', 'offtheshelf' ),
					'sidebar-left'  => esc_html__( 'Left', 'offtheshelf' ),
					'sidebar-right' => esc_html__( 'Right', 'offtheshelf' )
				),
				array(
					'name'  => 'Sidebar position',
					'std'   => 'sidebar-right',
					'class' => 'no-fancy',
					'desc'  => esc_html__( 'Select whether and where you would like the sidebar to be displayed.', 'offtheshelf' )
				)
			);

			$options_panel->addCheckbox( 'enable_woocommerce_sidebars', array(
				'name'    => esc_html__( 'Specific Sidebars', 'offtheshelf' ),
				'caption' => esc_html__( 'Enable WooCommerce-specific sidebars', 'offtheshelf' ),
				'desc'    => esc_html__( 'If this option is checked, theme default sidebars will be replaced with WooCommerce-specific sidebars.', 'offtheshelf' ),
				'class'   => 'no-toggle',
				'std'     => true
			) );
			$options_panel->CloseTab();

		}


		/*
		 * Import and Export Settings
		 */

		$options_panel->OpenTab( 'export' );
		$options_panel->Title( esc_html__( "Import and Export", 'offtheshelf' ) );
		$options_panel->addImportExport();
		$options_panel->CloseTab();
		$options_panel->CloseTab();

		/*
		 * Page Builder
		 */
		if ( function_exists( 'siteorigin_panels_render' ) ) {
			$options_panel->OpenTab( 'pagebuilder' );
			$options_panel->Title( esc_html__( "Page Builder", 'offtheshelf' ) );

			$options_panel->addParagraph( sprintf( offtheshelf_esc_html( __( 'Off the Shelf uses the <a href="%1$s" target="_blank">SiteOrigin Page Builder plug-in</a> as its page builder. It comes with its own <a href="%2$s" target="_blank">documentation</a>.', 'offtheshelf' ) ), esc_url( 'https://siteorigin.com/page-builder/' ), esc_url( 'https://siteorigin.com/page-builder/documentation/' ) ) );

			$options_panel->Subtitle( esc_html__( "General Settings", 'offtheshelf' ) );
			$options_panel->addCheckbox( 'pagebuilder_copy_content', array(
				'name'    => esc_html__( 'Copy Content', 'offtheshelf' ),
				'caption' => esc_html__( 'Copy page builder content into default editor', 'offtheshelf' ),
				'desc'    => esc_html__( 'If this option is checked, rendered content will be copied into the default content editor, for plug-ins to be able to pick up that content for analysis.', 'offtheshelf' ),
				'std'     => true
			) );
			$options_panel->addCheckbox( 'pagebuilder_bundled_widgets', array(
				'name'    => esc_html__( 'Bundled Widgets', 'offtheshelf' ),
				'caption' => esc_html__( 'Enable bundled widgets', 'offtheshelf' ),
				'desc'    => esc_html__( 'If this option is checked, the default widgets that ship with the page builder will be available.', 'offtheshelf' ),
				'std'     => true
			) );
			$options_panel->addCheckbox( 'pagebuilder_inline_css', array(
				'name'    => esc_html__( 'Inline CSS', 'offtheshelf' ),
				'caption' => esc_html__( 'Generate inline CSS code', 'offtheshelf' ),
				'std'     => true
			) );

			$options_panel->Subtitle( esc_html__( "Layout and Design", 'offtheshelf' ) );
			$options_panel->addText(
				'pagebuilder_mobile_width',
				array(
					'name'       => esc_html__( 'Mobile Width', 'offtheshelf' ),
					'std'        => '780',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Mobile content width', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);
			$options_panel->addCheckbox( 'pagebuilder_tablet_layout', array(
				'name'    => esc_html__( 'Use Tablet Layout', 'offtheshelf' ),
				'caption' => esc_html__( 'Collapses the layout differently on tablet devices, using the tablet width set below.', 'offtheshelf' ),
				'std'     => true
			) );
			$options_panel->addText(
				'pagebuilder_tablet_width',
				array(
					'name'       => esc_html__( 'Tablet Width', 'offtheshelf' ),
					'std'        => '1024',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Mobile content width (tablet only)', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);
			$options_panel->addText(
				'pagebuilder_row_bottom_margin',
				array(
					'name'       => esc_html__( 'Row Bottom Margin', 'offtheshelf' ),
					'std'        => '0',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Fixed bottom margin for every row', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);
			$options_panel->addText(
				'pagebuilder_cell_side_margins',
				array(
					'name'       => esc_html__( 'Cell Side Margins', 'offtheshelf' ),
					'std'        => '30',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Margin to be added to the sides of each cell', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);

			$options_panel->Subtitle( esc_html__( "Row Defaults", 'offtheshelf' ) );

			$options_panel->addText(
				'pagebuilder_row_margin_bottom',
				array(
					'name'       => esc_html__( 'Margin (Bottom)', 'offtheshelf' ),
					'std'        => '0',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Default bottom margin if none is set for the row.', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);


			$options_panel->addText(
				'pagebuilder_row_padding_top',
				array(
					'name'       => esc_html__( 'Padding (Top)', 'offtheshelf' ),
					'std'        => '45',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Default padding at the top of each row. Used if no value is set in the page builder\'s row options.', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);

			$options_panel->addText(
				'pagebuilder_row_padding_bottom',
				array(
					'name'       => esc_html__( 'Padding (Bottom)', 'offtheshelf' ),
					'std'        => '45',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Default padding at the bottom of each row. Used if no value is set in the page builder\'s row options.', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);

			$options_panel->addText(
				'pagebuilder_row_padding_left',
				array(
					'name'       => esc_html__( 'Padding (Left)', 'offtheshelf' ),
					'std'        => '0',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Default padding at the left of each row. Used if no value is set in the page builder\'s row options.', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);

			$options_panel->addText(
				'pagebuilder_row_padding_right',
				array(
					'name'       => esc_html__( 'Padding (Right)', 'offtheshelf' ),
					'std'        => '0',
					'validate'   => array(
						'numeric' => array(
							'param'   => '',
							'message' => esc_html__( "must be a numeric value", 'offtheshelf' )
						)
					),
					'desc'       => esc_html__( 'Default padding at the right of each row. Used if no value is set in the page builder\'s row options.', 'offtheshelf' ),
					'text_after' => 'px',
					'field_type' => 'number'
				)
			);


			$options_panel->Subtitle( esc_html__( "Post Types", 'offtheshelf' ) );

			$options_panel->addPostTypes( 'pagebuilder_post_types',
				array(),
				array(
					'name'  => 'Supported Post Types',
					'std'   => array( 'post', 'page', 'banner', 'modal' ),
					'class' => 'no-fancy',
					'desc'  => esc_html__( 'Select the post types for which the page builder should be available. Note that some features designed for posts and pages may not or only partially work with custom post types.', 'offtheshelf' )
				)
			);


			$options_panel->CloseTab();
		}

		/*
		 * Advanced
		 */

		$options_panel->OpenTab( 'advanced' );

		$options_panel->Title( esc_html__( "Advanced Settings", 'offtheshelf' ) );

		$options_panel->Subtitle( esc_html__( "Global Custom Code", 'offtheshelf' ) );
		$options_panel->addParagraph( esc_html__( "Code added to this section is always applied. It can be overwritten by profiles or individual pages.", 'offtheshelf' ) );
		$options_panel->addTextarea( 'advanced_global_css', array(
			'name' => esc_html__( 'Custom CSS', 'offtheshelf' ),
			'desc' => esc_html__( 'This custom CSS will be added to the theme\'s header.', 'offtheshelf' ),
			'std'  => ''
		) );
		$options_panel->addTextarea( 'advanced_global_scripts_header', array(
			'name' => esc_html__( 'Custom Scripts (Header)', 'offtheshelf' ),
			'desc' => esc_html__( 'Custom scripts entered here will be added to the theme\'s header.', 'offtheshelf' ),
			'std'  => ''
		) );
		$options_panel->addTextarea( 'advanced_global_scripts_footer', array(
			'name' => esc_html__( 'Custom Scripts (Footer)', 'offtheshelf' ),
			'desc' => esc_html__( 'Custom scripts entered here will be added to the theme\'s footer.', 'offtheshelf' ),
			'std'  => ''
		) );

		if ( function_exists ( 'offtheshelf_shortcode_option' ) ) {
			$options_panel->addTextarea( 'advanced_global_shortcodes', array(
				'name' => esc_html__( 'Customization Shortcodes', 'offtheshelf' ),
				'desc' => esc_html__( 'Shortcodes will be executed prior to the templates being rendered. You can use this option to change settings, modify template output or to remove theme features dynamically.', 'offtheshelf' ),
				'std'  => ''
			) );

			$options_panel->addCheckbox( 'advanced_global_parse_custom_blocks', array(
				'name'    => esc_html__( 'Parse for custom blocks', 'offtheshelf' ),
				'caption' => esc_html__( 'Parse customization shortcodes block', 'offtheshelf' ),
				'desc'    => esc_html__( 'If this option is checked, the theme will parse for and execute custom blocks in this order: defined by shortcode, defined by custom PHP function through plug-in or child theme, defined by custom template.', 'offtheshelf' ),
				'class'   => 'no-toggle',
				'std'     => true
			) );
		}

		$options_panel->Subtitle( esc_html__( "Performance Settings", 'offtheshelf' ) );

		$options_panel->addHidden( 'advanced_css_handling',
			array(
				'inline' => esc_html__( 'Output to page header', 'offtheshelf' ),
				//'external_css' 	=> esc_html__( 'External CSS file', 'offtheshelf' )
			),
			array(
				'name'  => 'Dynamic CSS Handling',
				'std'   => 'inline',
				'class' => 'no-fancy',
				'desc'  => esc_html__( 'Select how you would like dynamically generated CSS code to be handled.', 'offtheshelf' )
			)
		);

		$options_panel->addCheckbox( 'advanced_css_minify', array(
			'name'    => esc_html__( 'Minify CSS', 'offtheshelf' ),
			'caption' => esc_html__( 'Minify generated dynamic CSS code.', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, the theme will compress or minify all generated CSS code before it is sent to the browser.', 'offtheshelf' ),
			'std'     => true
		) );

		$options_panel->addCheckbox( 'advanced_no_animations', array(
			'name'    => esc_html__( 'Disable animations', 'offtheshelf' ),
			'caption' => esc_html__( 'Disable animations for rows and widgets.', 'offtheshelf' ),
			'desc'    => esc_html__( 'If this option is checked, the tbeme will not load resources for animations and disable the animation feature globally.', 'offtheshelf' ),
			'std'     => false
		) );


		$options_panel->CloseTab();


		// Taxonomy Meta Fields
		$config        = array(
			'id'             => 'offthehelf_category',
			// meta box id, unique per meta box
			'title'          => 'Off the Shelf',
			// meta box title
			'pages'          => array( 'category', 'product_cat' ),
			// taxonomy name, accept categories, post_tag and custom taxonomies
			'context'        => 'normal',
			// where the meta box appear: normal (default), advanced, side; optional
			'fields'         => array(),
			// list of meta fields (can be added by field arrays)
			'local_images'   => true,
			// Use local or hosted images (meta box images for add/remove)
			'use_with_theme' => get_template_directory_uri() . '/lib/admin'
		);
		$category_meta = new SR_Tax_Meta( $config );
		$category_meta->addPosts( $prefix . 'category_banner', array( 'args' => array( 'post_type' => 'banner' ) ), array(
			'name' => esc_html__( 'Custom Category Banner', 'offtheshelf' ),
			'desc' => esc_html__( 'If a banner is selected, it will be displayed for this category\'s archive pages.', 'offtheshelf' )
		) );
		$category_meta->Finish();


	}
}


function offtheshelf_change_default_editor_title( $title ) {
	$screen = get_current_screen();
	if ( 'profile' == $screen->post_type ) {
		$title = esc_html__( 'Enter profile name here', 'offtheshelf' );
	} elseif ( 'banner' == $screen->post_type ) {
		$title = esc_html__( 'Enter banner title here', 'offtheshelf' );
	}
}

add_filter( 'enter_title_here', 'offtheshelf_change_default_editor_title' );


/*
 * Add menu to Admin Bar (Toolbar as of WP 3.3)
 */
function offtheshelf_custom_adminbar_menu( $meta = true ) {
	global $wp_admin_bar;
	if ( ! is_user_logged_in() ) {
		return;
	}
	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}

	if ( offtheshelf_option_global( 'skipped_setup' ) || offtheshelf_option_global( 'finished_setup' ) ) {
		// We have skipped or previously completed the setup
	} else {
		$wp_admin_bar->add_menu( array(
				'id'     => 'offtheshelf_finish_setup',
				'href'   => admin_url( 'themes.php?page=offtheshelf-welcome' ),
				'title'  => esc_html__( 'Finish Theme Setup', 'offtheshelf' ),
				'parent' => 'top-secondary',
				'meta'   => array(
					'class' => 'finish-theme-setup'
				)
			)
		);
	}

	if ( ! offtheshelf_hide_theme_options_toolbar() ) {
		$wp_admin_bar->add_menu( array(
						'id'    => 'offtheshelf_menu',
						'href'  => admin_url( 'themes.php?page=offtheshelf_admin_page' ),
						'title' => esc_html__( 'Theme Options', 'offtheshelf' )
				)
		);

		$wp_admin_bar->add_menu( array(
						'parent' => 'offtheshelf_menu',
						'id'     => 'custom_links',
						'title'  => esc_html__( 'Off The Shelf Options', 'offtheshelf' ),
						'href'   => admin_url( 'themes.php?page=offtheshelf_admin_page' ),
						'meta'   => array()
				)
		);

		do_action( "offtheshelf_admin_menu_after_options" );

		$wp_admin_bar->add_menu( array(
						'parent' => 'offtheshelf-external',
						'id'     => 'offtheshelf_about',
						'title'  => esc_html__( 'About Off the Shelf', 'offtheshelf' ),
						'href'   => 'http://www.shapingrain.com/products/offtheshelf-for-wordpress/',
						'meta'   => array()
				)
		);

		$wp_admin_bar->add_menu( array(
						'parent' => 'offtheshelf-external',
						'id'     => 'shapingrain_link',
						'title'  => esc_html__( 'ShapingRain.com', 'offtheshelf' ),
						'href'   => 'http://www.shapingrain.com/',
						'meta'   => array( 'target' => '_blank' )
				)
		);

		$wp_admin_bar->add_menu( array(
						'parent' => 'offtheshelf-external',
						'id'     => 'shapingrain_support',
						'title'  => esc_html__( 'Customer Support', 'offtheshelf' ),
						'href'   => 'http://www.shapingrain.com/support/',
						'meta'   => array( 'target' => '_blank' )
				)
		);

		do_action( "offtheshelf_admin_menu_after_support" );

		$wp_admin_bar->add_group( array(
				'parent' => 'offtheshelf_menu',
				'id'     => 'offtheshelf-external',
				'meta'   => array(
						'class' => 'ab-sub-secondary',
				),
		) );
	}

}

add_action( 'admin_bar_menu', 'offtheshelf_custom_adminbar_menu', 15 );

function offtheshelf_custom_menu_css() {
	$custom_menu_css = '<style type="text/css">
	<!--/*--><![CDATA[/*><!--*/
	li#wp-admin-bar-offtheshelf_finish_setup a:before {
		content: \'\f109\';
		color: #ffffff;
	}
	li#wp-admin-bar-offtheshelf_finish_setup {
		background: #3ca14c!important;
	}
	li#wp-admin-bar-offtheshelf_finish_setup a {
		color: #ffffff;
		font-weight: bold;
	}
	#adminmenu li#menu-posts-profile div.wp-menu-image:before {
		content: \'\f157\';
	}
	#adminmenu li#menu-posts-banner div.wp-menu-image:before {
		content: \'\f136\';
	}
    #wp-admin-bar-offtheshelf_menu > .ab-item:before {
		content: "\f111";
        top: 2px;
    }

	/*]]>*/-->
    </style>';
	echo $custom_menu_css;
}

if ( is_user_logged_in() && ( is_super_admin() || ! is_admin_bar_showing() ) ) {
	add_action( 'wp_head', 'offtheshelf_custom_menu_css' );
}
add_action( 'admin_head', 'offtheshelf_custom_menu_css' );


function offtheshelf_custom_admin_css() {

	global $post_type;
	$additional_css = '';
	if ( isset( $post_type ) && $post_type == 'profile' ) {
		$additional_css = '#edit-slug-box,#view-post-btn,#post-preview,.updated p a, #misc-publishing-actions,#minor-publishing-actions{display: none;}';
	}

	echo '<style>
	<!--/*--><![CDATA[/*><!--*/
        #TB_window {
        	z-index:9999999;
        }
		' . $additional_css . '
	/*]]>*/-->
	</style>';
}

add_action( 'admin_head', 'offtheshelf_custom_admin_css' );


/*
 * Set defaults from within profile editor
 */
function offtheshelf_add_profile_default_metabox() {
	add_meta_box( OFFTHESHELF_OPTIONS_PREFIX . 'profile_defaults', esc_html__( 'Default Profile', 'offtheshelf' ), 'offtheshelf_profile_default_metabox', 'profile', 'side', 'default' );
}

add_action( 'add_meta_boxes', 'offtheshelf_add_profile_default_metabox' );

function offtheshelf_profile_default_metabox() {
	global $post;

	echo '<input type="hidden" name="profile_defaults_nonce" id="profile_defaults_nonce" value="' .
	     wp_create_nonce( 'edit_profile' ) . '" />';

	$default             = offtheshelf_option( 'default_profile' );
	$default_blog        = offtheshelf_option( 'default_profile_blog' );
	$default_woocommerce = offtheshelf_option( 'default_profile_woocommerce' );

	$id = intval( $post->ID );

	echo '<table class="form-table"><tbody>';

	if ( $id == $default ) {
		$readonly_default = ' disabled="disabled"';
	} else {
		$readonly_default = '';
	}

	echo '<tr><td class="at-field at-field-last">';
	echo '<input type="checkbox" class="rw-checkbox no-fancy" name="sr_ots_is_default_site" id="sr_ots_is_default_site" value="1" ' . checked( $id, $default, false ) . $readonly_default . '>';
	echo '<label for="sr_ots_is_default_site"><span class="at-checkbox-label">' . esc_html__( 'Site Default', 'offtheshelf' ) . '</span></label>';
	echo '</td></tr>';

	echo '<tr><td class="at-field at-field-last">';
	echo '<input type="checkbox" class="rw-checkbox no-fancy" name="sr_ots_is_default_blog" id="sr_ots_is_default_blog" value="1" ' . checked( $id, $default_blog, false ) . '>';
	echo '<label for="sr_ots_is_default_blog"><span class="at-checkbox-label">' . esc_html__( 'Blog Default', 'offtheshelf' ) . '</span></label>';
	echo '</td></tr>';

	if ( function_exists( 'is_woocommerce' ) ) {
		echo '<tr><td class="at-field at-field-last">';
		echo '<input type="checkbox" class="rw-checkbox no-fancy" name="sr_ots_is_default_woocommerce" id="sr_ots_is_default_woocommerce" value="1" ' . checked( $id, $default_woocommerce, false ) . '>';
		echo '<label for="sr_ots_is_default_woocommerce"><span class="at-checkbox-label">' . esc_html__( 'WooCommerce Default', 'offtheshelf' ) . '</span></label>';
		echo '</td></tr>';
	}

	echo '</tbody></table>';

}


function offtheshelf_set_profile_defaults( $post_id, $post ) {
	if ( $post->post_type != 'profile' ) {
		return $post->ID;
	}
	if ( ! isset ( $_POST['profile_defaults_nonce'] ) ) {
		return $post->ID;
	}

	if ( $post->post_type != 'profile' ) {
		return $post->ID;
	}

	if ( ! wp_verify_nonce( $_POST['profile_defaults_nonce'], 'edit_profile' ) ) {
		return $post->ID;
	}

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	$id = $post->ID; //offtheshelf_lang_id($post->ID, 'profile');

	// retrieve settings from post submission
	if ( ! empty( $_POST['sr_ots_is_default_site'] ) ) {
		$set_site_default = $_POST['sr_ots_is_default_site'];
	} else {
		$set_site_default = 0;
	}

	if ( ! empty( $_POST['sr_ots_is_default_blog'] ) ) {
		$set_blog_default = $_POST['sr_ots_is_default_blog'];
	} else {
		$set_blog_default = 0;
	}

	if ( ! empty( $_POST['sr_ots_is_default_woocommerce'] ) ) {
		$set_woocommerce_default = $_POST['sr_ots_is_default_woocommerce'];
	} else {
		$set_woocommerce_default = 0;
	}

	// retrieve current defaults
	$default             = offtheshelf_option( 'default_profile' );
	$default_blog        = offtheshelf_option( 'default_profile_blog' );
	$default_woocommerce = offtheshelf_option( 'default_profile_woocommerce' );

	// site default
	if ( $set_site_default == 1 && $default != $id ) {
		offtheshelf_save_options( array( 'default_profile' => $id ) );
	}

	// blog default
	if ( $set_blog_default == 1 && $default_blog != $id ) {
		offtheshelf_save_options( array( 'default_profile_blog' => $id ) );
	}

	if ( $set_blog_default == 0 && $default_blog == $id ) {
		offtheshelf_save_options( array( 'default_profile_blog' => 0 ) );
	}

	// woocommerce default
	if ( $set_woocommerce_default == 1 && $default_woocommerce != $id ) {
		offtheshelf_save_options( array( 'default_profile_woocommerce' => $id ) );
	}

	if ( $set_woocommerce_default == 0 && $default_woocommerce == $id ) {
		offtheshelf_save_options( array( 'default_profile_woocommerce' => 0 ) );
	}

	return $post->ID;
}

add_action( 'save_post', 'offtheshelf_set_profile_defaults', 1, 2 );


function offtheshelf_custom_profile_statuses( $post_statuses ) {
	$scr = get_current_screen();
	if ( $scr->post_type !== 'profile' ) {
		return $post_statuses;
	}

	global $post;
	$id = intval( $post->ID );

	$default_blog        = offtheshelf_option( 'default_profile_blog' );
	$default             = offtheshelf_option( 'default_profile' );
	$default_woocommerce = offtheshelf_option( 'default_profile_woocommerce' );

	$post_statuses = array();

	if ( $default == $id ) {
		$post_statuses['default-site'] = '<span class="dashicons dashicons-star-filled"></span> ' . esc_html__( 'Site Default', 'offtheshelf' );
	}
	if ( $default_blog == $id ) {
		$post_statuses['default-blog'] = '<span class="dashicons dashicons-welcome-write-blog"></span> ' . esc_html__( 'Blog Default', 'offtheshelf' );
	}
	if ( $default_woocommerce == $id ) {
		$post_statuses['default-woocommerce'] = '<span class="dashicons dashicons-cart"></span> ' . esc_html__( 'WooCommerce Default', 'offtheshelf' );
	}

	return $post_statuses;
}

add_filter( 'display_post_states', 'offtheshelf_custom_profile_statuses' );


function offtheshelf_profiles_bulk_actions( $actions ) {
	unset( $actions['inline'] );
	unset( $actions['edit'] );

	return $actions;
}

add_filter( 'bulk_actions-edit-profile', 'offtheshelf_profiles_bulk_actions' );


add_action( 'wp_trash_post', 'offtheshelf_delete_profile' );
add_action( 'wp_delete_post', 'offtheshelf_delete_profile' );
function offtheshelf_delete_profile( $postid ) {
	if ( 'profile' != get_post_type( $postid ) ) {
		return;
	}

	$default_blog        = offtheshelf_option( 'default_profile_blog' );
	$default             = offtheshelf_option( 'default_profile' );
	$default_woocommerce = offtheshelf_option( 'default_profile_woocommerce' );

	if ( $postid == $default ) {
		wp_redirect( admin_url( 'edit.php?post_type=profile&profile_delete=site_default' ) );
		exit();
	}

	if ( $postid == $default_blog ) {
		offtheshelf_save_options( array( 'default_profile_blog' => 0 ) );
	}

	if ( $postid == $default_woocommerce ) {
		offtheshelf_save_options( array( 'default_profile_woocommerce' => 0 ) );
	}

}


function offtheshelf_admin_notices() {
	if ( ! isset( $_GET['profile_delete'] ) ) {
		return;
	}

	if ( $_GET['profile_delete'] == "site_default" ) :
		?>
		<div class="error">
			<p><?php esc_html_e( 'You cannot delete your Site Default Profile. In order to do so, create a new profile, make it your Site Default Profile and then delete the original one.', 'offtheshelf' ); ?></p>
		</div>
		<?php
	endif;
}

add_action( 'admin_init', 'offtheshelf_admin_notices' );


function offtheshelf_force_type_private( $post ) {
	if ( ! $post['post_status'] == 'trash' ) {
		if ( $post['post_type'] == 'profile' && $post['post_status'] == 'publish' ) {
			$post['post_status'] = 'private';
		}

		if ( $post['post_type'] == 'banner' ) {
			$post['post_status'] = 'publish';
		}
	}

	return $post;
}

//add_filter('wp_insert_post_data', 'offtheshelf_force_type_private');


add_filter( 'post_row_actions', 'offtheshelf_remove_row_actions', 10, 2 );
function offtheshelf_remove_row_actions( $actions, $post ) {
	global $current_screen;
	if ( $current_screen && $current_screen->post_type != 'profile' && $current_screen->post_type != 'banner' ) {
		return $actions;
	}
	unset( $actions['view'] );
	unset( $actions['inline hide-if-no-js'] );

	return $actions;
}


/*
 * Additional functions for custom content types
 */
add_action( 'admin_enqueue_scripts', 'offtheshelf_admin_pointers' );
function offtheshelf_admin_pointers() {

	$pointers = array(
		array(
			'id'       => 'page_visual_editor',
			'screen'   => 'page',
			'target'   => '#content-panels',
			'title'    => esc_html__( 'Visual Page Editor', 'offtheshelf' ),
			'content'  => esc_html__( 'We recommend that you build pages with the visual page editor. That way you can profit from the theme\'s many built-in widgets and design settings.', 'offtheshelf' ),
			'position' => array(
				'edge'  => 'top', // top, bottom, left, right
				'align' => 'left' // top, bottom, left, right, middle
			)
		),
		array(
			'id'       => 'post_visual_editor',
			'screen'   => 'banner',
			'target'   => '#content-panels',
			'title'    => esc_html__( 'Visual Banner Editor', 'offtheshelf' ),
			'content'  => esc_html__( 'We recommend that you edit your banners using the visual page editor. That way you can profit from the theme\'s many built-in widgets and design settings.', 'offtheshelf' ),
			'position' => array(
				'edge'  => 'top', // top, bottom, left, right
				'align' => 'left' // top, bottom, left, right, middle
			)
		),
		array(
			'id'       => 'select_setting',
			'screen'   => 'page',
			'target'   => '#offtheshelf_profile',
			'title'    => esc_html__( 'Select a settings profile', 'offtheshelf' ),
			'content'  => esc_html__( 'Each page can use a different settings profile. That way you can make each page look different, with unique colours, fonts and settings.', 'offtheshelf' ),
			'position' => array(
				'edge'  => 'bottom', // top, bottom, left, right
				'align' => 'left' // top, bottom, left, right, middle
			)
		),
		array(
			'id'       => 'modal_editor',
			'screen'   => 'modal',
			'target'   => '#wp-content-editor-container',
			'title'    => esc_html__( 'Edit Modal Window Content', 'offtheshelf' ),
			'content'  => esc_html__( 'This is where you add the content to be displayed inside the modal window. The content is parsed for shortcodes and may contain media.', 'offtheshelf' ),
			'position' => array(
				'edge'  => 'top', // top, bottom, left, right
				'align' => 'middle' // top, bottom, left, right, middle
			)
		),
		array(
			'id'       => 'sr_settings',
			'screen'   => 'appearance_page_offtheshelf_admin_page',
			'target'   => '.current',
			'title'    => __( 'Global Theme Settings', 'offtheshelf' ),
			'content'  => offtheshelf_esc_html( __( 'This screen contains <strong>global theme settings</strong> that apply to the theme as a whole. They control the blog, theme extensions like third party integrations and some advanced settings.', 'offtheshelf' ) ),
			'position' => array(
				'edge'  => 'left', // top, bottom, left, right
				'align' => 'right' // top, bottom, left, right, middle
			)
		),
		array(
			'id'       => 'sr_profiles',
			'screen'   => 'appearance_page_offtheshelf_admin_page',
			'target'   => '#sr-profiles',
			'title'    => __( 'Profiles', 'offtheshelf' ),
			'content'  => offtheshelf_esc_html( __( 'Edit <strong>profiles</strong> to control visual aspects of the theme, like fonts, colors and background images. By default there is only one design profile, but you can create as many as you like and assign separate profiles to different pages. That way you can create pages with completely unique designs without affecting the overall look and feel of the rest of your site.', 'offtheshelf' ) ),
			'position' => array(
				'edge'  => 'top', // top, bottom, left, right
				'align' => 'left' // top, bottom, left, right, middle
			)
		),

	);
	new SR_Admin_Pointer( $pointers );
}


?>