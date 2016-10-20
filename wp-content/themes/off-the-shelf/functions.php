<?php
/**
 *
 * Off the Shelf for WordPress - Main Theme Functions and Definitions
 * ShapingRain.com - http://www.shapingrain.com
 *
 * @license GPLv2
 *
 * @package offtheshelf
 */

/*
 * Global Constants
 */
if ( ! defined( 'OFFTHESHELF_WIDGETS_DIR' ) ) {
	define( 'OFFTHESHELF_WIDGETS_DIR', get_template_directory() . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR );
}

if ( ! defined( 'OFFTHESHELF_ENABLE_UPDATES' ) ) {
	define( 'OFFTHESHELF_ENABLE_UPDATES', true );
}

if ( ! defined( 'OFFTHESHELF_DEBUG' ) ) {
	define( 'OFFTHESHELF_DEBUG', false );
}

if ( ! defined( 'OFFTHESHELF_THEME_VERSION' ) ) {
	if ( is_child_theme() ) {
		$style_parent_theme = wp_get_theme( get_template() );
		$version = $style_parent_theme->get( 'Version' );
	} else {
		$style_parent_theme = wp_get_theme();
		$version = $style_parent_theme->get( 'Version' );
	}
	define( 'OFFTHESHELF_THEME_VERSION', $version );
}

if ( ! defined( 'SR_PAGEBUILDER_DIR' ) ) {
	define( 'SR_PAGEBUILDER_DIR', get_template_directory() . DIRECTORY_SEPARATOR . 'panels' . DIRECTORY_SEPARATOR );
}

if ( ! defined( 'SR_ADMIN_URL' ) ) {
	define( 'SR_ADMIN_URL', get_template_directory_uri() . '/lib/admin' );
}

if ( ! defined( 'SR_SUPPORT_URL' ) ) {
	define( 'SR_SUPPORT_URL', 'http://www.shapingrain.com/support' );
}

if ( ! defined( 'SR_REGISTER_URL' ) ) {
	define( 'SR_REGISTER_URL', 'https://ssl.shapingrain.com/register' );
}

if ( ! defined( 'SR_SUPPORT_SUBMIT_URL' ) ) {
	define( 'SR_SUPPORT_SUBMIT_URL', 'https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-' );
}

if ( ! defined( 'SR_OPTIN_API_URL' ) ) {
	define( 'SR_OPTIN_API_URL', 'http://forms.shapingrain.com/' );
}

if ( ! defined( 'SR_UPDATE_URL' ) ) {
	define( 'SR_UPDATE_URL', 'https://da1hbqae6ojvl.cloudfront.net/' );
}

if ( ! defined( 'OFFTHESHELF_OPTIONS_PREFIX' ) ) {
	define( 'OFFTHESHELF_OPTIONS_PREFIX', 'sr_ots_' );
}

/*
 * Initialize theme options
 */
$offtheshelf_options        = get_option( 'offtheshelf_options' ); // theme options
$offtheshelf_options_global = get_option( 'offtheshelf_options_global' ); // setup state


/*
 * Global Variables for use in functions
 */
global $offtheshelf_sidebars; /* holds a cached and pre-processed version of active sidebars */
global $offtheshelf_widgets_row_count; /* widget counts to automatically re-size widgetized areas */
global $offtheshelf_widgets_count; /*internal counters for handling custom widgetized areas */
global $offtheshelf_widgets_type_count;
global $offtheshelf_custom_widgets; /* all widgets and their class names for use in page builder */
global $offtheshelf_last_widget_id; /* simple counter */

global $offtheshelf_this_page_options; /* if page or post, this contains individual options (temporary cache) */

global $offtheshelf_this_page_modals; /* modal window content to be added to this page */
global $offtheshelf_custom_blocks; /* custom content blocks */
global $offtheshelf_button_styles; /* custom button styles */

/*
 * Include Third Party Helper Classes
 */
require_once( get_template_directory() . '/lib/admin/admin-page-class.php' ); /* admin page class */
require_once( get_template_directory() . '/lib/admin/meta-box-class.php' ); /* meta box class */
require_once( get_template_directory() . '/lib/admin/tax-meta-class.php' ); /* taxonomy meta box class */
require_once( get_template_directory() . '/lib/admin/admin-columns.php' ); /* taxonomy meta class */
require_once( get_template_directory() . '/lib/widget-class.php' ); /* widget helper class */
require_once( get_template_directory() . '/lib/image-helper-class.php' ); /* image manipulation features */
require_once( get_template_directory() . '/lib/cssmin.class.php' ); /* CSS minify class */
require_once( get_template_directory() . '/lib/wp-admin-pointers.php' ); /* admin UI pointers */
if (!class_exists('Base2n')) {
	require_once get_template_directory() . '/lib/base2n.php';
}
if ( ! class_exists( 'Twitter_API_WordPress' ) ) {
	require_once get_template_directory() . '/lib/twitter-api-wordpress.php';
}

/*
 * Include Theme Classes
 */
require_once( get_template_directory() . '/inc/null.php' ); /* dummy functions to replace plug-ins */
require_once( get_template_directory() . '/inc/typography.php' ); /* additional back-end enhancements */
require_once( get_template_directory() . '/inc/admin_extras.php' ); /* additional back-end enhancements */
require_once( get_template_directory() . '/inc/admin.php' ); /* admin panel and custom post type initialization */
require_once( get_template_directory() . '/inc/panels.php' ); /* visual editor integration */
require_once( get_template_directory() . '/inc/onepage.php' ); /* one page menu functions */

/*
 * Initial Setup
 */
require_once( get_template_directory() . '/inc/setup.php' ); /* initial setup routines */

/*
 * Required and recommended plug-ins
 */
require_once( get_template_directory() . '/lib/class-tgm-plugin-activation.php' ); /* load activation class */
require_once( get_template_directory() . '/inc/plugins.php' ); /* initialize update class */

/*
 * Update check
 */
if ( is_admin() && OFFTHESHELF_ENABLE_UPDATES == true ) {
	require_once( get_template_directory() . '/lib/theme-update-checker.php' ); /* load update checker class */
	require_once( get_template_directory() . '/inc/updates.php' ); /* initialize update checks */
}

/*
 * Third party application integration
 */
if ( function_exists( 'is_woocommerce' ) ) {
	require_once( get_template_directory() . '/inc/woocommerce.php' ); /* WooCommerce Plugin */
}

/*
 * Load and initialize built-in widgets
 */

$offtheshelf_custom_widgets = array( // supported in shortcodes
                                     'bio_block'       => 'OffTheShelf_Bio_Block_Widget',
                                     'blog_posts'      => 'OffTheShelf_Blog_Posts_Widget',
                                     'button'          => 'OffTheShelf_Button_Widget',
                                     'split_button'    => 'OffTheShelf_Split_Button_Widget',
                                     'countdown'       => 'OffTheShelf_Countdown_Widget',
                                     'contact'         => 'OffTheShelf_Contact_Widget',
                                     'cta_box'         => 'OffTheShelf_CTA_Box_Widget',
                                     'divider'         => 'OffTheShelf_Divider_Widget',
                                     'event'           => 'OffTheShelf_Event_Widget',
                                     'feature_image'   => 'OffTheShelf_Feature_Media_Widget',
                                     'gallery'         => 'OffTheShelf_Gallery_Widget',
                                     'gravity_forms'   => 'OffTheShelf_Gravity_Forms_Widget',
                                     'headline'        => 'OffTheShelf_Headline_Widget',
                                     'icon'            => 'OffTheShelf_Icon_Widget',
                                     'icon_block'      => 'OffTheShelf_Icon_Block_Widget',
                                     'icon_list'       => 'OffTheShelf_Icon_List_Widget',
                                     'image'           => 'OffTheShelf_Image_Widget',
                                     'portfolio_item'  => 'OffTheShelf_Portfolio_Item_Widget',
                                     'last_tweets'     => 'OffTheShelf_Last_Tweets_Widget',
                                     'link'            => 'OffTheShelf_Link_Widget',
                                     'map'             => 'OffTheShelf_Map_Widget',
                                     'optin'           => 'OffTheShelf_Optin_Widget',
                                     'payment'         => 'OffTheShelf_Payment_Icons_Widget',
                                     'pricing_block'   => 'OffTheShelf_Pricing_Block_Widget',
                                     'progress_bar'    => 'OffTheShelf_Progress_Bar_Widget',
                                     'raw'             => 'OffTheShelf_Raw_HTML_Widget',
                                     'recent_comments' => 'OffTheShelf_Recent_Comments_Widget',
                                     'recent_posts'    => 'OffTheShelf_Recent_Posts_Widget',
                                     'slider'          => 'OffTheShelf_Slider_Widget',
                                     'social_icons'    => 'OffTheShelf_Social_Icons_Widget',
                                     'social_share'    => 'OffTheShelf_Share_Widget',
                                     'testimonial'     => 'OffTheShelf_Testimonial_Widget',
                                     'video'           => 'OffTheShelf_Video_Widget'
);


if ( ! function_exists( 'offtheshelf_init_widgets' ) ) {
	function offtheshelf_init_widgets() {
		if ( $handle = opendir( OFFTHESHELF_WIDGETS_DIR ) ) {
			while ( false !== ( $entry = readdir( $handle ) ) ) {
				if ( substr_count( $entry, 'widget-' ) > 0 ) {
					require_once( OFFTHESHELF_WIDGETS_DIR . $entry );
				}
			}
			closedir( $handle );
		}
		do_action( 'offtheshelf_after_init_widgets' );
	}
}
offtheshelf_init_widgets();

/*
 * Ensure shortcodes are executed within the text widget
 */
add_filter('widget_text', 'do_shortcode');

/*
 * Check if layout mode equals parameter
 */
function offtheshelf_is_layout( $query_layout ) {
	$layout = offtheshelf_option( 'content_layout', 'default' );
	if ( $query_layout == $layout ) {
		return true;
	} else {
		return false;
	}
}

/*
 * Check if this is a blog page
 */
function offtheshelf_is_blog() {
	global $post;
	$posttype = get_post_type( $post );

	return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) && ( $posttype == 'post' ) ) ? true : false;
}

/*
 * Check if this is a WooCommerce page
 */
function offtheshelf_is_woocommerce( $body_classes = array() ) {
	$is_woocommerce = false; // we need to capture extensions etc. as well, so bult-in WC function not enough

	if ( count( $body_classes ) == 0 ) {
		$body_classes = (array) get_body_class();
	}

	if ( in_array( 'woocommerce', $body_classes ) || in_array( 'woocommerce-page', $body_classes ) ) {
		$is_woocommerce = true;
	}

	return $is_woocommerce;

}


/*
 * Load and Merge Options
 */
function offtheshelf_merge_options() {
	global $offtheshelf_options;

	$default_profile = 0;
	if ( isset ( $offtheshelf_options['default_profile'] ) ) {
		$default_profile  = $offtheshelf_options['default_profile'];
	}
	$page_custom_code = false;

	// overwrite site default profile if blog default profile is selected and blog page is being viewed
	if ( offtheshelf_is_blog() ) {
		if ( isset ( $offtheshelf_options['default_profile_blog'] ) ) {
			$default_profile_blog = $offtheshelf_options['default_profile_blog'];
		} else {
			$default_profile_blog = 0;
		}

		if ( $default_profile_blog != 0 ) {
			$default_profile                       = $default_profile_blog;
			$offtheshelf_options['the_profile_id'] = $default_profile;
		}
	}

	// overwrite site default profile if WooCommerce default profile is selected and WooCommerce page is being viewed
	if ( offtheshelf_is_woocommerce() ) {
		$default_profile_woocommerce = $offtheshelf_options['default_profile_woocommerce'];
		if ( $default_profile_woocommerce != 0 ) {
			$default_profile                       = $default_profile_woocommerce;
			$offtheshelf_options['the_profile_id'] = $default_profile;
		}
	}

	// check if individual posts or pages have a profile assigned that should be used to overwrite global settings
	if ( is_single() || is_page() || is_front_page() ) { // affects only posts and pages
		global $post;
		if ( ! empty( $post->ID ) ) {
			$m = get_post_meta( $post->ID );

			if ( isset ( $m[ OFFTHESHELF_OPTIONS_PREFIX . 'template_layout' ][0] ) ) {
				$offtheshelf_options['template_layout'] = $m[ OFFTHESHELF_OPTIONS_PREFIX . 'template_layout' ][0];
			}

			if ( isset ( $m[ OFFTHESHELF_OPTIONS_PREFIX . 'design_show_banner' ][0] ) ) {
				$offtheshelf_options['show_banner'] = $m[ OFFTHESHELF_OPTIONS_PREFIX . 'design_show_banner' ][0];
			}

			if ( isset ( $m[ OFFTHESHELF_OPTIONS_PREFIX . 'advanced_page_shortcodes' ][0] ) ) {
				$page_custom_code = $m[ OFFTHESHELF_OPTIONS_PREFIX . 'advanced_page_shortcodes' ][0];
			} else {
				$page_custom_code = false;
			}

			if ( isset ( $m[ OFFTHESHELF_OPTIONS_PREFIX . 'profile' ][0] ) ) {
				$query_profile = intval( $m[ OFFTHESHELF_OPTIONS_PREFIX . 'profile' ][0] );
				if ( $query_profile == 0 ) {
					$query_profile = $default_profile;
				} // if the selected profile is 'default', revert to the default profile
			} else {
				$query_profile = $default_profile; // selected page does not have a profile value set
			}
		} else {
			$query_profile = $default_profile;
		}
	} else { // this is not a front page, and not a single page view, so revert to default profile
		$query_profile = $default_profile;
	}

	if ( defined ('OFFTHESHELF_PROFILES') && $query_profile != 0 ) {
		$meta = get_post_meta( $query_profile ); // retrieve values from selected profile
	} else {
		$profile_temp = json_decode ( offtheshelf_file_read_contents( get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'profile.json' ), true);
		$meta = $profile_temp['post_meta'];
		$ignore_settings = array(
				'sr_ots_header_title',
				'sr_ots_header_tagline',
				'sr_ots_footer_copyright',
				'social_media_profiles'
		);
		foreach ( $ignore_settings as $ignore_key ) {
			if ( isset ( $meta[$ignore_key] ))
				unset ( $meta[$ignore_key] );
		}
		$query_profile = 0;
	}

	if ( is_array( $meta ) && count ( $meta ) > 0 ) {
		foreach ( $meta as $key => $val ) {
			if ( substr( $key, 0, 1 ) != "_" ) {
				$key                         = str_replace( OFFTHESHELF_OPTIONS_PREFIX, "", $key );
				$offtheshelf_options[ $key ] = $val[0]; // assign value from profile to general options array
			}
		}
	}

	$offtheshelf_options['the_profile_id'] = $query_profile;

	do_action( 'offtheshelf_after_options_merge' );

	/*
	 * Implement global customization shortcodes (prio 3)
 	*/
	$global_custom_code = offtheshelf_option( 'advanced_global_shortcodes', false );
	if ( $global_custom_code ) {
		do_shortcode( $global_custom_code );
	}

	/*
	 * Implement customization shortcodes for profiles (prio 2)
	 */
	$profile_custom_code = offtheshelf_option( 'advanced_shortcodes', false );
	if ( $profile_custom_code ) {
		do_shortcode( $profile_custom_code );
	}

	/*
	 * Implement customization shortcodes for pages (prio 1)
	 */
	if ( $page_custom_code ) {
		do_shortcode( $page_custom_code );
	}

	/*
	 * Debugging options (prio 0)
	 */
	do_action( 'offtheshelf_before_options_debug' );

	if ( offtheshelf_option( 'support_options_debugging' ) ) {
		$allowed_params = trim( offtheshelf_option( 'support_options_debugging_allowed_parameters', '' ) );
		if ( ! empty( $allowed_params ) ) {
			$allowed_params = explode( "\n", $allowed_params );
		}

		$get_token = "";
		$token     = offtheshelf_option( 'support_options_debugging_token' );
		if ( isset ( $_GET['support_access_token'] ) ) {
			$get_token = trim( $_GET['support_access_token'] );
		}
		if ( is_array( $_GET ) ) {
			foreach ( $_GET as $key => $val ) {
				if ( strtolower( $val ) == 'false' || $val == '0' ) {
					$val = false;
				}
				if ( ( empty( $allowed_params ) || in_array( $key, $allowed_params ) ) && ( empty( $token ) || $token == $get_token ) ) {
					$offtheshelf_options[ $key ] = htmlentities( $val, ENT_QUOTES, "UTF-8" );
				}
			}
		}
		do_action( 'offtheshelf_after_options_debug' );
	}
}

if ( ! is_admin() ) {
	add_action( 'wp', 'offtheshelf_merge_options' );
}


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140;
} /* pixels */


/*
 * Load Jetpack compatibility file.
 */
require_once( get_template_directory() . '/inc/jetpack.php' );

/*
 * Handle Theme Setup
 */
if ( ! function_exists( 'offtheshelf_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function offtheshelf_setup() {
		/**
		 * Custom template tags for this theme.
		 */
		require_once( get_template_directory() . '/inc/template-tags.php' );

		/*
		 * Additional Features
		 */
		require_once( get_template_directory() . '/inc/advanced.php' );

		/**
		 * Custom functions that act independently of the theme templates
		 */
		require_once( get_template_directory() . '/inc/extras.php' );

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 */
		load_theme_textdomain( 'offtheshelf', get_template_directory() . '/languages' );


		/**
		 * Add support for title tag (4.1+)
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// default post thumbnails
		add_image_size( 'ots-post-thumbnail', 900, 365, true );
		add_image_size( 'ots-post-thumbnail-medium', 600, 250, true );
		add_image_size( 'ots-post-thumbnail-small', 120, 120, true );

		// testimonial avatars
		add_image_size( 'ots-testimonial-avatar', 120, 120, true );

		// bio block avatars
		add_image_size( 'ots-bio-avatar', 600, 500, true );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'ots-primary'      => esc_html__( 'Primary Menu', 'offtheshelf' ),
			'ots-footer'       => esc_html__( 'Footer Menu', 'offtheshelf' ),
			'ots-multipurpose' => esc_html__( 'Toolbar Menu', 'offtheshelf' ),
		) );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'quote', 'link' ) ); // Post Formats
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) ); // HTML5 mark-up

		/* Not supported as features provided by theme's profiles feature */
		if (defined('CUSTOM_THEME_SUPPORT')) {
			add_theme_support( "custom-header", array() );
			add_theme_support( "custom-background", array() );
		}

		/*
		 * Check whether animations are to be used
		 */
		if ( offtheshelf_option ( 'advanced_no_animations' ) )
			define ( 'OFFTHESHELF_DISABLE_ANIMATIONS', true );

	}
endif; // offtheshelf_setup
add_action( 'after_setup_theme', 'offtheshelf_setup' );


/*
 * Modify image size titles in select boxes
 */
add_filter( 'image_size_names_choose', 'offtheshelf_custom_image_select' );
if ( ! function_exists( 'offtheshelf_custom_image_select' ) ) {
	function offtheshelf_custom_image_select( $args ) {
		global $_wp_additional_image_sizes;
		foreach ( $_wp_additional_image_sizes as $key => $value ) {
			$custom[ $key ] = ucwords( str_replace( '-', ' ', $key ) );
		}

		return array_merge( $args, $custom );
	}
}

/**
 * Register widgetized areas and update sidebar with default widgets
 */
if ( ! function_exists( 'offtheshelf_widgets_init' ) ) {
	function offtheshelf_widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Blog Sidebar', 'offtheshelf' ),
			'description'   => esc_html__( 'This sidebar is displayed on all blog pages and archives and wherever no specific sidebar is available.', 'offtheshelf' ),
			'id'            => 'ots-blog-sidebar',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widgets', 'offtheshelf' ),
			'description'   => esc_html__( 'This widget container is displayed on every page underneath the main content area.', 'offtheshelf' ),
			'id'            => 'ots-footer-widgets',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		) );

	}
}
add_action( 'widgets_init', 'offtheshelf_widgets_init' );

/*
 * Initialize and retrieve sidebar content
 */
if ( ! function_exists( 'offtheshelf_init_sidebars' ) ) {
	function offtheshelf_init_sidebars() {
		global $offtheshelf_sidebars;
		global $wp_registered_sidebars;

		$sidebars_in_wrapper = array(
			'ots-blog-sidebar'
		);

		if ( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) > 0 ) {
			foreach ( $wp_registered_sidebars as $sidebar ) {
				$id = $sidebar['id'];
				if ( is_active_sidebar( $id ) ) {
					ob_start();
					if ( in_array( $id, $sidebars_in_wrapper ) ) {
						get_sidebar();
					} else {
						$result = dynamic_sidebar( $id );
					}
					$offtheshelf_sidebars[ $id ] = ob_get_clean();
				}
			}
		}
	}
}
if ( ! is_admin() ) {
	add_action( 'wp', 'offtheshelf_init_sidebars', 11 );
}

if ( ! function_exists( 'offtheshelf_get_sidebar' ) ) {
	function offtheshelf_get_sidebar( $slug = "ots-blog-sidebar" ) {
		global $offtheshelf_sidebars;
		if ( isset( $offtheshelf_sidebars[ $slug ] ) ) {
			echo $offtheshelf_sidebars[ $slug ];
		} else {
			return false;
		}
	}
}

/*
 * Special widgetized area handling
 */
if ( ! function_exists( 'offtheshelf_add_classes_to_widgets' ) ) {
	function offtheshelf_add_classes_to_widgets( $params ) {
		global $offtheshelf_widgets_row_count;  // widgets row counter (horizontal widgets)
		global $offtheshelf_widgets_count;        // store amount of widgets in widgetized area
		global $offtheshelf_widget_num;        // all other widgetized areas

		$horizontal_widgets = array(
			'ots-footer-widgets',
			'ots-woocommerce-footer'
		);

		$this_id = $params[0]['id'];

		if ( ! is_array( $offtheshelf_widgets_row_count ) ) {
			$offtheshelf_widgets_row_count[ $this_id ] = 0; // footer widgets
		}

		if ( in_array( $this_id, $horizontal_widgets ) ) {
			$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
			$widgets_total_count    = count( $arr_registered_widgets[ $this_id ] );

			if ( ! isset( $offtheshelf_widgets_row_count[ $this_id ] ) ) {
				$offtheshelf_widgets_row_count[ $this_id ] = 0;
			}

			if ( isset( $offtheshelf_widgets_count[ $this_id ] ) ) {
				// do nothing, we already have our value
			} else {
				$total_widgets                         = wp_get_sidebars_widgets();
				$offtheshelf_widgets_count[ $this_id ] = count( $total_widgets[ $this_id ] );
			}
			$widget_cols = $offtheshelf_widgets_count[ $this_id ];

			$offtheshelf_widgets_row_count[ $this_id ] ++;
			$before_widget = $params[0]['before_widget'];
			if ( $offtheshelf_widgets_row_count[ $this_id ] == 4 || $offtheshelf_widgets_row_count[ $this_id ] == $widgets_total_count ) {
				$before_widget                             = str_replace( 'class="', 'class="widget-container col-' . $widget_cols . ' last ', $before_widget );
				$params[0]['before_widget']                = $before_widget;
				$offtheshelf_widgets_row_count[ $this_id ] = 0;
			} elseif ( $offtheshelf_widgets_row_count[ $this_id ] == 1 ) {
				$before_widget              = str_replace( 'class="', 'class="widget-container col-' . $widget_cols . ' first ', $before_widget );
				$params[0]['before_widget'] = $before_widget;
			} else {
				$before_widget              = str_replace( 'class="', 'class="widget-container col-' . $widget_cols . ' ', $before_widget );
				$params[0]['before_widget'] = $before_widget;
			}
		} else {
			// implementation follows http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
			$this_id                = $params[0]['id']; // Get the id for the current sidebar we're processing
			$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets

			if ( ! $offtheshelf_widget_num ) {// If the counter array doesn't exist, create it
				$offtheshelf_widget_num = array();
			}

			if ( ! isset( $arr_registered_widgets[ $this_id ] ) || ! is_array( $arr_registered_widgets[ $this_id ] ) ) { // Check if the current sidebar has no widgets
				return $params; // No widgets in this sidebar... bail early.
			}

			if ( isset( $offtheshelf_widget_num[ $this_id ] ) ) { // See if the counter array has an entry for this sidebar
				$offtheshelf_widget_num[ $this_id ] ++;
			} else { // If not, create it starting with 1
				$offtheshelf_widget_num[ $this_id ] = 1;
			}

			$class = 'class="widget-' . $offtheshelf_widget_num[ $this_id ] . ' '; // Add a widget number class for additional styling options

			if ( $offtheshelf_widget_num[ $this_id ] == 1 ) { // If this is the first widget
				$class .= 'first ';
			} elseif ( $offtheshelf_widget_num[ $this_id ] == count( $arr_registered_widgets[ $this_id ] ) ) { // If this is the last widget
				$class .= 'last ';
			}

			$params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] ); // Insert our new classes into "before widget"

		}

		return $params;
	}
}
add_filter( 'dynamic_sidebar_params', 'offtheshelf_add_classes_to_widgets' );

/*
 * Get unique ID for widget instance
 */
if ( ! function_exists( 'offtheshelf_get_widget_uid' ) ) {
	function offtheshelf_get_widget_uid( $base_id ) {
		global $offtheshelf_options;
		global $offtheshelf_widgets_type_count;

		if ( ! isset( $offtheshelf_widgets_type_count[ $base_id ] ) ) {
			$offtheshelf_widgets_type_count[ $base_id ] = 1;
		} else {
			$offtheshelf_widgets_type_count[ $base_id ] ++;
		}

		return "widget_" . $base_id . "_" . $offtheshelf_widgets_type_count[ $base_id ];
	}
}

/*
 * Add custom styles for custom content blocks or page builder elements or widgets
 */
if ( ! function_exists( 'offtheshelf_add_custom_style' ) ) {
	function offtheshelf_add_custom_style( $base_id, $style ) {
		global $offtheshelf_options;
		if ( ! isset( $offtheshelf_options['styles'] ) ) {
			$offtheshelf_options['styles'] = array();
		}
		if ( ! isset( $offtheshelf_options['styles'][ $base_id ] ) ) {
			$offtheshelf_options['styles'][ $base_id ] = array();
		}
		$offtheshelf_options['styles'][ $base_id ][] = $style;
	}
}

/*
 * Add custom scripts for custom content blocks or page builder elements or widgets
 */
if ( ! function_exists( 'offtheshelf_add_custom_script' ) ) {
	function offtheshelf_add_custom_script( $base_id, $code ) {
		global $offtheshelf_options;
		if ( ! isset( $offtheshelf_options['scripts'] ) ) {
			$offtheshelf_options['scripts'] = array();
		}
		if ( ! isset( $offtheshelf_options['scripts'][ $base_id ] ) ) {
			$offtheshelf_options['scripts'][ $base_id ] = array();
		}
		$offtheshelf_options['scripts'][ $base_id ][] = $code;
	}
}

/*
 * Add scripts to header
 */
function offtheshelf_custom_scripts_header() {
	/*
	 * Global Scripts
	 */
	echo offtheshelf_option( 'advanced_global_scripts_header', false );

	/*
	 * Profile Scripts
	 */
	echo offtheshelf_option( 'advanced_profile_custom_scripts', false );

	/*
	 * Page or Post Scripts
	 */
	echo offtheshelf_page_option( OFFTHESHELF_OPTIONS_PREFIX . 'advanced_page_custom_scripts', false );

}

add_action( 'wp_head', 'offtheshelf_custom_scripts_header', 100 );


function offtheshelf_custom_scripts_footer() {
	echo offtheshelf_option( 'advanced_global_scripts_footer', false );
}

add_action( 'wp_footer', 'offtheshelf_custom_scripts_footer', 100 );


/*
 * Function to detect whether a widget is used within the page builder
 */
if ( ! function_exists( 'offtheshelf_is_pagebuilder' ) ) {
	function offtheshelf_is_pagebuilder( $args = array() ) {
		if ( ! isset( $args['id'] ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*
 * Function to remove width and height attributes to accommodate responsiveness requirements
 */
if ( ! function_exists( 'offtheshelf_remove_thumbnail_dimensions' ) ) {
	function offtheshelf_remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );

		return $html;
	}
}
//add_filter( 'post_thumbnail_html', 'offtheshelf_remove_thumbnail_dimensions', 10 );
//add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 ); /* uncomment to also remove attributes from regular images inserted through editor */

/*
 * Return page or post meta data by key
 */
if ( ! function_exists( 'offtheshelf_meta' ) ) {
	function offtheshelf_meta( $key ) {
		$value = get_post_meta( get_the_ID(), OFFTHESHELF_OPTIONS_PREFIX . $key, true );

		return $value;
	}
}

/*
 * Return theme option
 */
if ( ! function_exists( 'offtheshelf_option' ) ) {
	function offtheshelf_option( $key = '', $default = false, $is_serialized = false ) {
		global $offtheshelf_options;

		if ( isset( $offtheshelf_options[ $key ] ) ) {
			$content = $offtheshelf_options[ $key ];
			if ( $is_serialized ) {
				$content = unserialize( $content );
			}
			$content = apply_filters( 'offtheshelf_get_option', $content );
			$content = apply_filters( 'offtheshelf_get_option_' . $key, $content );

			return $content;
		} else {
			return $default;
		}
	}
}

if ( ! function_exists( 'offtheshelf_option_global' ) ) {
	function offtheshelf_option_global( $key = '', $default = false, $is_serialized = false ) {
		global $offtheshelf_options_global;

		if ( isset( $offtheshelf_options_global[ $key ] ) ) {
			$content = $offtheshelf_options_global[ $key ];
			if ( $is_serialized ) {
				$content = unserialize( $content );
			}

			return $content;
		} else {
			return $default;
		}
	}
}


/*
 * Set theme option temporarily
 */
if ( ! function_exists( 'offtheshelf_set_option' ) ) {
	function offtheshelf_set_option( $key = '', $val ) {
		global $offtheshelf_options;
		$exists = false;
		if ( isset( $offtheshelf_options[ $key ] ) ) {
			$exists = true;
		}
		$val                         = apply_filters( 'offtheshelf_get_option', $val );
		$val                         = apply_filters( 'offtheshelf_get_option_' . $key, $val );
		$offtheshelf_options[ $key ] = $val;
	}
}

/*
 * Generate Random String
 * http://stackoverflow.com/questions/4356289/php-random-string-generator
 */
function offtheshelf_generate_random_string( $length = 10 ) {
	$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString     = '';
	for ( $i = 0; $i < $length; $i ++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}

	return $randomString;
}


/*
 * Save theme options to database
 */
if ( ! function_exists( 'offtheshelf_save_options' ) ) {
	function offtheshelf_save_options( $options = array(), $opt_group = 'offtheshelf_options' ) {
		$offtheshelf_global_options = get_option( $opt_group );

		if ( count( $options ) > 0 ) {
			foreach ( $options as $key => $val ) {
				if ( $val == null ) {
					if ( isset ( $offtheshelf_global_options[ $key ] ) )
						unset ( $offtheshelf_global_options[ $key ] );
				} else {
					$offtheshelf_global_options[ $key ] = $val;
				}
			}
			update_option( $opt_group, $offtheshelf_global_options );
		}
	}
}

/*
 * Return filtered content
 */
if ( ! function_exists( 'offtheshelf_render_content' ) ) {
	function offtheshelf_render_content( $content, $type ) {
		if ( $type == "inline-content" || $type == '' ) {
			$content = do_shortcode( $content );
		} elseif ( $type == "page-content" || $type == '' ) {
			// do nothing
		}

		return $content;
	}
}

/*
 * Return value from custom post field
 */
if ( ! function_exists( 'offtheshelf_custom_value' ) ) {
	function offtheshelf_custom_value( $key, $options, $default = false, $serialized = false ) {
		if ( isset( $options[ $key ] ) ) {
			if ( is_array( $options[ $key ] ) ) {
				if ( count( $options[ $key ] ) == 1 ) {
					if ( $serialized ) {
						return unserialize( $options[ $key ][0] );
					} else {
						return $options[ $key ][0];
					}
				} else {
					return $options[ $key ];
				}
			} else {
				return $options[ $key ];
			}
		}

		return $default;
	}
}


if ( ! function_exists( 'offtheshelf_page_option' ) ) {
	function offtheshelf_page_option( $key, $default = false, $serialized = false ) {
		global $offtheshelf_this_page_options;
		if ( ! ( is_page() || is_single() ) ) {
			return false;
		}

		if ( ! is_array( $offtheshelf_this_page_options ) ) {
			$offtheshelf_this_page_options = get_post_custom( get_the_ID() );
		}

		return ( offtheshelf_custom_value( $key, $offtheshelf_this_page_options, $default, $serialized ) );
	}
}


/*
 * Return option from given array, or default
 */
if ( ! function_exists( 'offtheshelf_array_option' ) ) {
	function offtheshelf_array_option( $key = '', $instance, $default = false ) {
		if ( isset( $instance[ $key ] ) ) {
			$content = $instance[ $key ];

			return $content;
		} else {
			return $default;
		}
	}
}


/*
 * Display custom 'more' link
 */
if ( ! function_exists( 'offtheshelf_excerpt_more' ) ) {
	function offtheshelf_excerpt_more( $more ) {
		// return '<p><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" title="' . esc_attr ( get_the_title() ) . '" class="button-read-more">' . esc_html('Read more', 'offtheshelf') .'</a></p>';
		return '';
	}
}
add_filter( 'excerpt_more', 'offtheshelf_excerpt_more' );

if ( ! function_exists( 'offtheshelf_read_more_link' ) ) {
	function offtheshelf_read_more_link( $post_id = false ) {
		if ( ! $post_id ) $post_id = get_the_ID();
		return '<p><a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . esc_attr ( get_the_title( $post_id ) ) . '" class="button-read-more">' . esc_html__('Read more', 'offtheshelf') .'</a></p>';
	}
}




/*
 * Control custom excerpt length
 */
if ( ! function_exists( 'offtheshelf_custom_excerpt_length' ) ) {
	function offtheshelf_custom_excerpt_length( $length ) {
		$new_length = intval( offtheshelf_option( 'blog_excerpt_length' ) );

		if ( $new_length && $new_length > 1 ) {
			return $new_length;
		} else {
			return $length;
		}
	}
}
add_filter( 'excerpt_length', 'offtheshelf_custom_excerpt_length', 999 );


/*
 * Register User Contact Methods
 */
if ( ! function_exists( 'offtheshelf_user_contact_methods' ) ) {
	function offtheshelf_user_contact_methods( $user_contact_method ) {
		$user_contact_method['facebook']  = esc_html__( 'Facebook Username', 'offtheshelf' );
		$user_contact_method['twitter']   = esc_html__( 'Twitter Username', 'offtheshelf' );
		$user_contact_method['gplus']     = esc_html__( 'Google Plus', 'offtheshelf' );
		$user_contact_method['skype']     = esc_html__( 'Skype Username', 'offtheshelf' );
		$user_contact_method['linkedin']  = esc_html__( 'LinkedIn Profile URL', 'offtheshelf' );
		$user_contact_method['instagram'] = esc_html__( 'Instagram Username', 'offtheshelf' );
		$user_contact_method['pinterest'] = esc_html__( 'Pinterest Username', 'offtheshelf' );
		$user_contact_method['flickr']    = esc_html__( 'Flickr Username', 'offtheshelf' );
		$user_contact_method['tumblr']    = esc_html__( 'Tumblr Profile URL', 'offtheshelf' );
		$user_contact_method['youtube']   = esc_html__( 'YouTube Channel URL', 'offtheshelf' );
		$user_contact_method['vimeo']     = esc_html__( 'Vimeo Username', 'offtheshelf' );

		return $user_contact_method;
	}
}
add_filter( 'user_contactmethods', 'offtheshelf_user_contact_methods' );


if ( ! function_exists( 'offtheshelf_print_styles' ) ) {
	function offtheshelf_print_styles() {
		global $is_IE;
		if ( $is_IE ) :
			?>
			<!--[if lt IE 9]>
			<script>
				'article aside footer header nav section time'.replace(/\w+/g, function (n) {
					document.createElement(n)
				})
			</script>
			<![endif]-->

			<!--[if gte IE 9]>
			<style type="text/css">
				.gradient {
					filter: none !important;
				}
			</style>
			<![endif]-->

			<?php
		endif;
	}
}
add_filter( 'wp_print_styles', 'offtheshelf_print_styles' );



if ( ! function_exists( ( 'offtheshelf_enqueue_scripts' ) ) ) {
	function offtheshelf_enqueue_scripts() {
		$theme_version = OFFTHESHELF_THEME_VERSION;

		/*
		 * Styles
		 */
		wp_enqueue_style( 'offtheshelf-style', get_stylesheet_uri() );

		wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'font-awesome' );

		wp_register_style( 'offtheshelf-animate-css', get_template_directory_uri() . '/css/animate.min.css' );


		/*
		 * Scripts
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'offtheshelf-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), $theme_version );
		}

		if ( ! offtheshelf_is_layout( 'boxed' ) && offtheshelf_option( 'header_menu_sticky' ) ) {
			wp_enqueue_script( 'offtheshelf-classie', get_template_directory_uri() . '/js/classie.js', array(), $theme_version, true );
			wp_enqueue_script( 'offtheshelf-animated-header', get_template_directory_uri() . '/js/animated-header.min.js', array('offtheshelf-classie'), $theme_version, true );
		}

		wp_enqueue_script( 'offtheshelf-smartmenus', get_template_directory_uri() . '/js/jquery.smartmenus.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-swipebox', get_template_directory_uri() . '/js/jquery.swipebox.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-salvattore', get_template_directory_uri() . '/js/salvattore.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', array( 'jquery' ), $theme_version, true );

		wp_enqueue_script( 'offtheshelf-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'offtheshelf-waypoints-sticky', get_template_directory_uri() . '/js/sticky.min.js', array(
			'jquery',
			'offtheshelf-waypoints'
		), $theme_version, true );

		wp_enqueue_script( 'offtheshelf-skrollr', get_template_directory_uri() . '/js/skrollr.min.js', array( 'jquery' ), $theme_version, true );


		wp_register_script( 'offtheshelf-wow', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), $theme_version, true );

		if ( ! defined ( 'OFFTHESHELF_DISABLE_ANIMATIONS' )) {
			wp_enqueue_style( 'offtheshelf-animate-css' );
			wp_enqueue_script( 'offtheshelf-wow' );
		}

		wp_enqueue_script( 'offtheshelf-site', get_template_directory_uri() . '/js/offtheshelf.js', array(
			'jquery',
			'offtheshelf-smartmenus',
			'offtheshelf-placeholder',
			'offtheshelf-smartmenus',
			'offtheshelf-flexslider',
			'offtheshelf-swipebox',
			'offtheshelf-skrollr'
		), $theme_version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'offtheshelf_enqueue_scripts' );


if ( ! function_exists( 'offtheshelf_add_body_classes' ) ) {
	function offtheshelf_add_body_classes( $classes ) {
		if ( offtheshelf_option( 'header_menu_sticky', false ) ) {
			$classes[] = 'sticky';
		} // sticky menu
		if ( offtheshelf_is_layout( 'boxed' ) ) {
			$classes[] = 'layout-boxed';
		}  // boxed layout
		if ( offtheshelf_is_layout( 'full-width' ) ) {
			$classes[] = 'layout-full-width';
		}  // full width layout

		if ( offtheshelf_option( 'header_menu_transparent', false ) && offtheshelf_option( 'the_banner_id' ) ) {
			$classes[] = 'has-transparent-menu';
		} else {
			$classes[] = 'has-solid-menu';
		} // transparency for top menu

		if ( offtheshelf_option( 'header_menu_hide', false ) ) {
			$classes[] = 'no-menu';
		} // menu is hidden in theme options

		if ( offtheshelf_option( 'header_multipurpose' ) ) {
			$classes[] = 'has-toolbar';
		}

		if ( offtheshelf_option( 'the_banner_has_slider' ) ) {
			$classes[] = 'banner-has-slider';
		}

		if ( offtheshelf_option( 'mobile_animations' ) ) {
			$classes[] = 'has-mobile-anim';
		}

				$no_sidebar = true;
		if ( offtheshelf_is_blog() ) {
			if ( is_archive() ) {
				$classes[] = 'blog-layout-' . offtheshelf_option( 'blog_archive_layout', 'list' );
				if ( offtheshelf_option( 'blog_sidebar_archives', false ) ) {
					$classes[]  = "has-sidebar";
					$classes[]  = "sidebar-" . offtheshelf_option( 'blog_sidebar_position', 'right' );
					$no_sidebar = false;
				}
			} else {
				if ( !is_single() ) {
					$classes[] = 'blog-layout-' . offtheshelf_option( 'blog_layout', 'list' );
				}
				if ( offtheshelf_option( 'blog_sidebar_front', false ) ) {
					$classes[]  = "has-sidebar";
					$classes[]  = "sidebar-" . offtheshelf_option( 'blog_sidebar_position', 'right' );
					$no_sidebar = false;
				}
			}
		}

		if ( $no_sidebar ) {
			$classes[] = "no-sidebar";
		}

		return $classes;
	}
}
add_filter( 'body_class', 'offtheshelf_add_body_classes' );


if ( ! function_exists( 'offtheshelf_get_header_body_classes' ) ) {
	function offtheshelf_get_header_body_classes() {
		$body_classes = array();
		if ( offtheshelf_option( 'the_banner_full_width' ) ) {
			$body_classes[] = 'has-full-width-banner';
		}
		if ( $banner_id = offtheshelf_option( 'the_banner_id' ) ) {
			$body_classes[] = 'has-banner';
			$body_classes[] = 'banner-' . $banner_id;
		} else {
			$body_classes[] = 'no-banner';

			$has_sub_banner = false;
			if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_checkout_pay_page() ) ) {
				$has_sub_banner = true;
			} elseif ( offtheshelf_is_blog() ) {
				$has_sub_banner = true;
			} else {
				if ( offtheshelf_option( 'show_banner', false ) ) {
					$has_sub_banner = true;
				}
			}

			if ( ! $has_sub_banner ) {
				$body_classes[] = 'blank-header';
			}


		}
		if ( $profile_id = offtheshelf_option( 'the_profile_id' ) ) {
			$body_classes[] = 'profile-' . $profile_id;
		}

		return $body_classes;
	}
}


if ( ! function_exists( 'offtheshelf_post_classes' ) ) {
	function offtheshelf_post_classes( $classes ) {
		global $wp_query;
		$classes[] = $wp_query->current_post % 2 == 0 ? 'odd' : 'even';

		if ( ( $wp_query->current_post + 1 ) == 1 ) {
			$classes[] = 'first';
		}
		if ( ( $wp_query->current_post + 1 ) == $wp_query->post_count ) {
			$classes[] = 'last';
		}

		return $classes;
	}
}
add_filter( 'post_class', 'offtheshelf_post_classes' );

/*
 * Get all links from content
 */

function offtheshelf_is_valid_url( $url ) { return (bool) parse_url( $url ); }

if ( ! function_exists( 'offtheshelf_get_link' ) ) {
	function offtheshelf_get_link( $content ) {
		$matches = array();
		preg_match_all( "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/",
			$content, $matches );

		if ( isset( $matches[0] ) && is_array( $matches[0] ) && count( $matches[0] ) > 0 ) {
			return $matches[0][0];
		} else {
			return false;
		}

	}
}


/*
 * Make embedded video clips responsive
 */
if ( ! function_exists( 'offtheshelf_responsive_embed' ) ) {
	function offtheshelf_responsive_embed( $output, $url = null, $attr = array() ) {
		/* Based on http://websitesthatdontsuck.com/2011/12/fluid-width-oembed-videos-in-wordpress/ */
		if ( offtheshelf_option( 'content_responsive_videos', true ) ) {
			$resize                    = false;
			$services_allow_responsive = array(
				'vimeo',
				'youtube',
				'dailymotion',
				'viddler.com',
				'hulu.com',
				'blip.tv',
				'revision3.com',
				'funnyordie.com',
				'slideshare',
				'scribd.com',
			);

			foreach ( $services_allow_responsive as $provider ) {
				if ( strstr( $url, $provider ) ) {
					$resize = true;
					break;
				}
			}

			$attr_pattern       = '/(width|height)="[0-9]*"/i';
			$whitespace_pattern = '/\s+/';
			$embed              = preg_replace( $attr_pattern, "", $output );
			$embed              = preg_replace( $whitespace_pattern, ' ', $embed );
			$embed              = trim( $embed );
			$output             = '<div class="embed_container">';
			$output .= $embed;
			$output .= "</div>";
		}

		// html5 w3 validation fix
		$output = str_replace( ' frameborder="0"', '', $output );

		return $output;
	}
}
add_filter( 'embed_oembed_html', 'offtheshelf_responsive_embed', 99, 4 );
add_filter( 'video_embed_html', 'offtheshelf_responsive_embed' );
add_filter( 'oembed_result', 'offtheshelf_responsive_embed' );


/*
 * Make images responsive
 * https://gist.github.com/stuntbox/4557917
 */
if ( ! function_exists( 'offtheshelf_remove_img_dimensions' ) ) {
	function offtheshelf_remove_img_dimensions( $html ) {
		if ( offtheshelf_option( 'content_responsive_images', true ) ) {
			$html = preg_replace( '/(width|height)=["\']\d*["\']\s?/', "", $html );
		}

		return $html;
	}
}
add_filter( 'post_thumbnail_html', 'offtheshelf_remove_img_dimensions', 10 );
add_filter( 'image_send_to_editor', 'offtheshelf_remove_img_dimensions', 10 );
add_filter( 'the_content', 'offtheshelf_remove_img_dimensions', 10 );
add_filter( 'get_avatar', 'offtheshelf_remove_img_dimensions', 10 );


/*
 * Use theme's default sizes rather than WordPress' own feature to ensure that images are rendered in desired dimensions
 */
function offtheshelf_adjust_image_sizes_attr( $sizes, $size ) {
	$width = $size[1];
	$sizes = '(max-width: ' . $width . 'px) 100vw, ' . $width . 'px';
	return $sizes;
}
//add_filter( 'wp_calculate_image_sizes', 'offtheshelf_adjust_image_sizes_attr', 10 , 2 );
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );


/*
 * Remove unused admin menu items
 */
remove_action( 'admin_enqueue_scripts', 'siteorigin_panels_siteorigin_themes_tab', 11 );
remove_action( 'siteorigin_panels_after_widgets', 'siteorigin_panels_recommended_widgets' );

/*
 * Check whether live editor is used
 */
function offtheshelf_panels_is_live_editor() {
	if ( function_exists( 'siteorigin_panels_render' ) ) {
		if ( isset( $_REQUEST['siteorigin_panels_live_editor'] ) && $_REQUEST['siteorigin_panels_live_editor'] ) {
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}
}



/*
 * Dynamic CSS and Script Handling
 */

/*
 * Dynamic CSS: Inline CSS
 */

if ( ! function_exists( 'offtheshelf_get_dynamic_css' ) ) {
	function offtheshelf_get_dynamic_css( $mode ) {
		if ( is_ssl() ) {
			$protocol = "https";
		} else {
			$protocol = "http";
		}
		do_action( "offtheshelf_before_dynamic_css" );

		ob_start();
		include( get_template_directory() . DIRECTORY_SEPARATOR . 'dynamic-css.php' );
		$css = ob_get_clean();

		$css = apply_filters( 'offtheshelf_dynamic_css_inline', $css );

		if ( offtheshelf_option( 'advanced_css_minify', true ) ) {
			$compressor = new CSSmin();
			$css        = $compressor->run( $css );
		}

		return $css;
	}
}

if ( ! function_exists( 'offtheshelf_print_dynamic_css' ) ) {
	function offtheshelf_print_dynamic_css() {
		$dynamic_css_mode = 'inline';
		if ( $dynamic_css_mode == 'external_css' ) { // write external css file

		} else { // inline css
			echo '<style type="text/css">' . "\n";
			$styles = offtheshelf_get_dynamic_css( 'inline' );
			echo $styles;
			echo "\n" . '</style>' . "\n";
			echo offtheshelf_option( 'font_imports' );
		}
	}
}

if ( ! is_admin() ) {
	add_action( 'wp_head', 'offtheshelf_print_dynamic_css', 13 );
}


/*
 * Dynamic CSS Helper Functions
 */


/*
 * Convert HEX to RGBA colors
 * http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
 */
function offtheshelf_hex2rgba( $color, $opacity = false ) {
	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if ( empty( $color ) ) {
		return $default;
	}

	//Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb = array_map( 'hexdec', $hex );

	//Check if opacity is set(rgba or rgb)
	$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';

	//Return rgb(a) color string
	return $output;
}


/*
 * Get first gallery images from content
 */
if ( ! function_exists( 'offtheshelf_get_gallery' ) ) {
	function offtheshelf_get_gallery( $content ) {
		$pattern = get_shortcode_regex();
		if ( preg_match_all( '/' . $pattern . '/s', $content, $matches )
		     && array_key_exists( 2, $matches )
		     && in_array( 'gallery', $matches[2] )
		):
			$keys = array_keys( $matches[2], 'gallery' );
			foreach ( $keys as $key ):
				$atts = shortcode_parse_atts( $matches[3][ $key ] );
				if ( array_key_exists( 'ids', $atts ) ):
					$images = explode( ',', $atts['ids'] );
					if ( is_array( $images ) && count( $images ) > 0 ) {
						return $images;
					} else {
						return false;
					}
				endif;
			endforeach;
		endif;
	}
}


/*
 * Return settings for individual button style
 */
if ( ! function_exists( 'offtheshelf_get_button_style' ) ) {
	function offtheshelf_get_button_style( $uid ) {
		global $offtheshelf_button_styles;
		if ( $uid == null || $uid == '' || $uid == '0' ) {
			return false;
		}

		if ( isset( $offtheshelf_button_styles ) && is_array( $offtheshelf_button_styles ) ) {
			if ( is_array( $offtheshelf_button_styles ) && count( $offtheshelf_button_styles ) > 0 ) {
				// everything's fine, we've got the button styles
			} else {
				// there are no button styles :(
				$offtheshelf_button_styles = null;
			}
		} else {
			$styles                    = offtheshelf_option( 'global_button_styles', false );
			$offtheshelf_button_styles = array();
			if ( is_array( $styles ) && count( $styles ) > 0 ) {
				foreach ( $styles as $style ) {

					if ( ! isset( $style['shadow'] ) ) {
						$style['shadow'] = false;
					}

					$button_style['meta']                                      = array(
						'uid'    => $style['uid'],
						'shadow' => $style['shadow'],
						'radius' => $style['radius'],
						'font'   => $style['font'],
					);
					$button_style['default']                                   = array(
						'background_mode' => $style['default_background_mode'],
						'color_1'         => $style['default_color_1'],
						'color_2'         => $style['default_color_2'],
						'text'            => $style['default_color_text'],
					);
					$button_style['hover']                                     = array(
						'background_mode' => $style['hover_background_mode'],
						'color_1'         => $style['hover_color_1'],
						'color_2'         => $style['hover_color_2'],
						'text'            => $style['hover_color_text'],
					);
					$offtheshelf_button_styles[ $button_style['meta']['uid'] ] = array(
						'meta'    => $button_style['meta'],
						'default' => $button_style['default'],
						'hover'   => $button_style['hover'],
					);
				}
			} else {
				$offtheshelf_button_styles = null;
			}
		}


		if ( isset( $offtheshelf_button_styles[ $uid ] ) ) {
			return $offtheshelf_button_styles[ $uid ];
		} else {
			return false;
		}

	}
}

/*
 * White-label functions
 */
if ( ! function_exists( 'offtheshelf_hide_support_links' ) ) {
	function offtheshelf_hide_support_links() {
		if ( defined( 'OFFTHESHELF_HIDE_SUPPORT_LINKS' ) && OFFTHESHELF_HIDE_SUPPORT_LINKS == true )
			$hide_support_links = true;
		else
			$hide_support_links = false;

		$hide_support_links = apply_filters( 'offtheshelf_hide_support_links', $hide_support_links );

		return $hide_support_links;
	}
}

if ( ! function_exists( 'offtheshelf_hide_theme_options_toolbar' ) ) {
	function offtheshelf_hide_theme_options_toolbar() {
		if ( defined( 'OFFTHESHELF_HIDE_ADMIN_TOOLBAR_ITEMS' ) && OFFTHESHELF_HIDE_ADMIN_TOOLBAR_ITEMS == true )
			$hide_admin_toolbar_items = true;
		else
			$hide_admin_toolbar_items = false;

		$hide_admin_toolbar_items = apply_filters( 'offtheshelf_hide_admin_toolbar_items', $hide_admin_toolbar_items );

		return $hide_admin_toolbar_items;
	}
}

if ( ! function_exists( 'offtheshelf_support_message_html' ) ) {
	function offtheshelf_support_message_html() {
		$html = apply_filters( 'offtheshelf_support_message_html', '' );

		if ( ! empty ( $html ) )
			echo $html;
		else
			return false;
	}
}



/*
 * Admin init functions
 */
if ( ! function_exists( 'offtheshelf_add_editor_styles' ) ) {
	function offtheshelf_add_editor_styles() {
		add_editor_style( 'editor-style.css' );
	}
}
add_action( 'admin_init', 'offtheshelf_add_editor_styles' );


/*
 * Misc. Utility Functions
 */

if ( ! function_exists( 'offtheshelf_esc_html' ) ) {
	function offtheshelf_esc_html ( $contents, $allowed_html = false, $decode_entities = false ) {
		if ( $decode_entities ) $contents = html_entity_decode ($contents);
		if ( ! $allowed_html ) {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'target' => array(),
					'title' => array(),
				    'id' => array(),
					'class' => array(),
					'rel' => array()
				),
				'img' => array(
					'src' => array(),
					'title' => array(),
					'alt' => array(),
					'id' => array(),
					'class' => array(),
					'rel' => array()
				),
				'iframe' => array(
					'id' => array(),
					'class' => array(),
					'align' => array(),
					'frameborder' => array(),
					'height' => array(),
					'logdesc' => array(),
					'marginheight' => array(),
					'marginwidth' => array(),
					'name' => array(),
					'sandbox' => array(),
					'scrolling' => array(),
					'src' => array(),
					'srcdoc' => array(),
					'width' => array()
				),
				'input' => array(
					'id' => array(),
					'class' => array(),
					'accept' => array(),
					'align' => array(),
					'alt' => array(),
					'autocomplete' => array(),
					'autofocus' => array(),
					'checked' => array(),
					'disabled' => array(),
					'form' => array(),
					'formaction' => array(),
					'formenctype' => array(),
					'formmethod' => array(),
					'formnovalidate' => array(),
					'formtarget' => array(),
					'height' => array(),
					'list' => array(),
					'max' => array(),
					'maxlength' => array(),
					'min' => array(),
					'multiple' => array(),
					'name' => array(),
					'pattern' => array(),
					'placeholder' => array(),
					'readonly' => array(),
					'required' => array(),
					'size' => array(),
					'src' => array(),
					'step' => array(),
					'type' => array(),
					'value' => array(),
					'width' => array(),
					'onclick' => array()
				),
				'button' => array(
					'id' => array(),
					'class' => array(),
					'autofocus' => array(),
					'disabled' => array(),
					'form' => array(),
					'formaction' => array(),
					'formenctype' => array(),
					'formmethod' => array(),
					'formnovalidate' => array(),
					'formtarget' => array(),
					'name' => array(),
					'type' => array(),
					'value' => array(),
					'onclick' => array()
				),
				'form' => array(
					'accept' => array(),
					'accept-charset' => array(),
					'action' => array(),
					'autocomplete' => array(),
					'enctype' => array(),
					'method' => array(),
					'name' => array(),
					'novalidate' => array(),
					'target' => array()
				),
				'div' => array(
					'id' => array(),
					'class' => array()
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'code' => array(
					'title' => array(),
					'class' => array(),
					'id' => array()
				),
				'span' => array(
					'id' => array(),
					'class' => array()
				),
				'b' => array(
						'id' => array(),
						'class' => array()
				),
				'i' => array(
						'id' => array(),
						'class' => array()
				),
				'p' => array(
						'id' => array(),
						'class' => array()
				),
				'time' => array(
					'class' => array(),
					'datetime' => array()
				),
			);
		}
		return wp_kses( $contents, $allowed_html );
	}
}

if ( ! function_exists( 'offtheshelf_file_write_contents' ) ) {
	function offtheshelf_file_write_contents( $file, $contents ) {
		if (!function_exists('WP_Filesystem')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		WP_Filesystem();
		global $wp_filesystem;
		if ( ! $wp_filesystem->put_contents( $file , $contents ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'offtheshelf_file_read_contents' ) ) {
	function offtheshelf_file_read_contents( $file ) {
		if (!function_exists('WP_Filesystem')) {
			require_once(ABSPATH . 'wp-admin/includes/file.php');
		}
		WP_Filesystem();
		global $wp_filesystem;
		$contents = $wp_filesystem->get_contents( $file );

		if ( $contents ) {
			return $contents;
		} else {
			return false;
		}
	}
}



