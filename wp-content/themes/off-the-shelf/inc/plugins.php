<?php
/*
 * Register plug-ins that are required by the theme
 */

add_action( 'tgmpa_register', 'offtheshelf_register_required_plugins' );

if (!function_exists('offtheshelf_register_required_plugins')) {
	function offtheshelf_register_required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// This is an example of how to include a plugin pre-packaged with a theme
			array(
				'name'     				=> 'SiteOrigin Page Builder', // The plugin name
				'slug'     				=> 'siteorigin-panels', // The plugin slug (typically the folder name)
				'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version'               => '2.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			),
			array(
				'name'               => 'Off the Shelf Core Feature Pack', // The plugin name.
				'slug'               => 'off-the-shelf-feature-pack', // The plugin slug (typically the folder name).
				'source'             => 'off-the-shelf-feature-pack.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '1.0.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			)
		);

		/**
		 * Array of configuration settings.
		 */
		$config = array(
			'default_path' => get_template_directory() . '/plugins/',
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                    // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'offtheshelf' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'offtheshelf' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'offtheshelf' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'offtheshelf' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' , 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'offtheshelf' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'offtheshelf'  ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'offtheshelf' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'offtheshelf' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'offtheshelf' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'offtheshelf' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'offtheshelf' ), // %s = dashboard link.
				'nag_type'                        => 'update-nag' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);

		tgmpa( $plugins, $config );

	}
}
