<?php
/*
 * Installation and Initial Setup
 */

add_action( 'admin_head', 'offtheshelf_setup_admin_head' );
add_action( 'admin_menu', 'offtheshelf_setup_pages');
function offtheshelf_setup_pages() {
	$welcome_page_title = esc_html__( 'Off The Shelf for WordPress Setup', 'offtheshelf' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-setup', 'offtheshelf_setup_page' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-setup-upload', 'offtheshelf_upload_page' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-welcome', 'offtheshelf_welcome_page' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-finish', 'offtheshelf_finish_page' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-plugins', 'offtheshelf_plugin_page' );
	$setup = add_theme_page( $welcome_page_title, $welcome_page_title, 'manage_options', 'offtheshelf-register', 'offtheshelf_register_page' );
}

function offtheshelf_setup_admin_head() {
	remove_submenu_page( 'themes.php', 'offtheshelf-setup' );
	remove_submenu_page( 'themes.php', 'offtheshelf-setup-upload' );
	remove_submenu_page( 'themes.php', 'offtheshelf-welcome' );
	remove_submenu_page( 'themes.php', 'offtheshelf-finish' );
	remove_submenu_page( 'themes.php', 'offtheshelf-plugins' );
	remove_submenu_page( 'themes.php', 'offtheshelf-register' );
}

function offtheshelf_plugins_active() {
	// SiteOrigin Page Builder
	if ( ! function_exists( 'siteorigin_panels_render')) {
		return false;
	}

	// Off the Shelf Core Feature Pack
	if ( ! defined ('OFFTHESHELF_FEATURE_PACK') ) {
		return false;
	}

	return true;
}

function offtheshelf_welcome_page() {
	if ( ! offtheshelf_plugins_active() ) {
		offtheshelf_plugin_page();
		return;
	}

	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );
	?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Welcome to Off the Shelf for WordPress', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Before you can use your site with Off the Shelf, we need to set up a few things.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-header">
			<ul>
				<li class="setup-active"><?php esc_html_e('Welcome', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Select Template', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Finish', 'offtheshelf'); ?></li>
			</ul>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Get assistance!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
		<div id="setup-welcome">
			<div id="setup-theme">
				<h3><?php esc_html_e('Installation & Getting Started', 'offtheshelf'); ?></h3>
				<p>
					<?php esc_html_e('Thank you for installing Off the Shelf for WordPress. The theme has been successfully activated, but before you can use it, we need to set up some defaults to make the theme look just the way you want it. This will only take seconds.', 'offtheshelf'); ?>
				</p>
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup', 'from' => 'welcome'), admin_url('themes.php') ) );?>" class="button button-primary button-hero" id="start-setup"><?php esc_html_e( "Start setup", 'offtheshelf' ); ?></a>
				<p><a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-finish', 'from' => 'welcome', 'skip' => 1), admin_url('themes.php') ) );?>" id="skip-setup"><?php esc_html_e( "Skip setup", 'offtheshelf' ); ?></a></p>
			</div>
			<?php if ( ! offtheshelf_support_message_html() ) : ?>
				<div id="theme-support">
					<h4><?php esc_html_e('Customer support is just a click away', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('If at any time you need any assistance, please contact customer support via email or live chat. Please note that we do not provide any customer support through the themeforest comments section though.', 'offtheshelf'); ?></p>
					<a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Get Support from ShapingRain.com', 'offtheshelf'); ?></a>
				</div>
				<div id="theme-registration">
					<h4><?php esc_html_e('Register for premium support and updates', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('We encourage you to register your license with shapingrain.com to enjoy:', 'offtheshelf'); ?></p>
					<ul>
						<li><?php esc_html_e('Access to premium support, 7 days a week', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Free updates for the product\'s lifetime', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Access to support resources and add-ons', 'offtheshelf'); ?></li>
					</ul>
					<a href="<?php echo esc_url( admin_url('themes.php?page=offtheshelf-register&from=setup') ); ?>" target="_blank"><?php esc_html_e('Register your license', 'offtheshelf') ;?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}


function offtheshelf_plugin_page() {
	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );
	?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Welcome to Off the Shelf for WordPress', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Before you can use your site with Off the Shelf, we need to set up a few things.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-header">
			<ul>
				<li class="setup-active"><?php esc_html_e('Welcome', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Select Template', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Finish', 'offtheshelf'); ?></li>
			</ul>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Get assistance!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
		<div id="setup-welcome">
			<div id="setup-theme">
				<h3><?php esc_html_e('Installation & Getting Started: Prerequisites', 'offtheshelf'); ?></h3>
				<p>
					<?php echo offtheshelf_esc_html( __('Thank you for installing Off the Shelf for WordPress. This theme <strong>requires the SiteOrigin Page Builder</strong> plug-in for many of its features and in order to use our starter templates and the widgets that ship with the theme.  The theme also <strong>requires core plug-ins</strong> which ship with the theme and need to be installed and activated as well before the theme can be used.', 'offtheshelf') ); ?>
				</p>
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'tgmpa-install-plugins'), admin_url('themes.php') ) );?>" class="button button-primary button-hero" id="start-setup"><?php esc_html_e( "Install required plug-ins", 'offtheshelf' ); ?></a>
			</div>
			<?php if ( ! offtheshelf_support_message_html() ) : ?>
				<div id="theme-support">
					<h4><?php esc_html_e('Customer support is just a click away', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('If at any time you need any assistance, please contact customer support via email or live chat. Please note that we do not provide any customer support through the themeforest comments section though.', 'offtheshelf'); ?></p>
					<a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Get Support from ShapingRain.com', 'offtheshelf'); ?></a>
				</div>
				<div id="theme-registration">
					<h4><?php esc_html_e('Register for premium support and updates', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('We encourage you to register your license with shapingrain.com to enjoy:', 'offtheshelf'); ?></p>
					<ul>
						<li><?php esc_html_e('Access to premium support, 7 days a week', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Free updates for the product\'s lifetime', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Access to support resources and add-ons', 'offtheshelf'); ?></li>
					</ul>
					<a href="<?php echo esc_url( admin_url('themes.php?page=offtheshelf-register&from=setup') ); ?>" target="_blank"><?php esc_html_e('Register your license', 'offtheshelf') ;?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}


function offtheshelf_register_page() {
	$message = false;
	$error = false;

	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );

	$license_key = offtheshelf_option('license_key');

	$status = '';
	delete_transient('offtheshelf_setup_register_status');

	if ( isset($_POST['action']) && $_POST['action'] == "offtheshelf-register" ) {
		if ( wp_verify_nonce($_POST['_wpnonce'], 'offtheshelf-setup-register-nonce') ) {
			if ( $_POST['license_key'] ) {
				$license_key = $_POST['license_key'];

				$import = new offtheshelf_import();
				$domain_hash = sha1(home_url());

				$verify_get = wp_remote_get(
						'https://ssl.shapingrain.com/update/version/offtheshelfwp/' . $license_key . '/' .$domain_hash . '/',
						array(
								'user-agent'  => 'OTSWP/' . $import->current_theme_version() . ';',
								'sslverify'   => false,
						)
				);

				if ( is_array ( $verify_get ) ) {
					if ( $verify_get['response']['code'] == 200 ) {
						$verify_status_return = json_decode( $verify_get['body'] );
						if ( $verify_status_return ) {
							$message = esc_html__('Your ShapingRain.com License Key has been saved and validated.', 'offtheshelf');;
							$error = false;
						} else {
							offtheshelf_save_options( array ( 'license_key' => '' ) );
							$error = $verify_get['body'];
						}
					} else {
						$error .= $verify_get['body'];
					}
				} else {
					$message = false;

					if( is_wp_error( $verify_get ) ) {
						$error_details = $verify_get->get_error_message();
					} else {
						$error_details = esc_html__('No specific error given.', 'offtheshelf');
					}

					$error = offtheshelf_esc_html( sprintf ( __('Unable to contact license key verification service or your web server is configured not to allow outgoing connections: %s. Please try again later. If the error persists, please contact customer support and provide this error message for reference.', 'offtheshelf'), $error_details ) );
				}

				if ($message || $error) {
					if ($error) {
						$message = $error;
						$type = 'error';
						$license_key = '';
					} else {
						offtheshelf_save_options( array ( 'license_key' => $license_key ) );
						$type = 'updated';
					}
					$status_message = array (
							'type' => $type,
							'message' => $message
					);
					set_transient('offtheshelf_setup_register_status', $status_message);
					$status = $type;
				}
			}
		}
	}
	?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Register your Off the Shelf License', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Get free access to theme updates and additional support resources.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-header">
			<ul>
				<li class="setup-active"><?php esc_html_e('License Key', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Finish', 'offtheshelf'); ?></li>
			</ul>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Contact customer support!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
		<div id="register-template">
			<?php
			if ( isset ($_REQUEST['status'] ) ) {
				$status = $_REQUEST['status'];
				$messages = get_transient('offtheshelf_setup_register_status');
				if ($messages) {
					echo '<div class="registration-updated message-' . $messages['type'] . '"><p>' . $messages['message'] . '</p></div>';
				}
			}
			?>
			<div id="theme-registration-info">
				<h4><?php esc_html_e('Registration is easy', 'offtheshelf'); ?></h4>
				<ol>
					<li><?php echo offtheshelf_esc_html( sprintf ( __('<a href="%s" target="_blank">Get your themeforest Item Purchase Code</a> to validate your license.', 'offtheshelf'), esc_url( SR_SUPPORT_SUBMIT_URL ) ) ); ?></li>
					<li><?php echo offtheshelf_esc_html( sprintf ( __('<a href="%s" target="_blank">Register your Item Purchase Code</a> on shapingrain.com to get a license key.', 'offtheshelf'), esc_url( SR_REGISTER_URL ) ) ); ?></li>
					<li><?php esc_html_e('Enter and save your ShapingRain.com License Key.', 'offtheshelf'); ?></li>
				</ol>
			</div>
			<div id="theme-registration-form">
				<form action="?page=offtheshelf-register&from=setup&status=updated" method="post" enctype="multipart/form-data" id="offtheshelf-setup-register-form">
					<?php wp_nonce_field( 'offtheshelf-setup-register-nonce' ); ?>
					<input type="hidden" name="action" value="offtheshelf-register">
					<div class="field field-type-text">
						<div class="at-label">
							<label for="license_key"><?php esc_html_e('ShapingRain.com License Key', 'offtheshelf'); ?></label>
						</div>
						<input type="text" class="at-text widefat" name="license_key" id="license_key" value="<?php echo esc_attr($license_key); ?>" size="30">
					</div>
					<input type="submit" value="<?php esc_html_e( "Save license key", 'offtheshelf' ); ?>" name="submit" class="button button-primary button-hero">
				</form>
			</div>
		</div>
	</div>

	<?php
}

function offtheshelf_finish_page() {
	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );

	if (!empty($_REQUEST['skip']) && $_REQUEST['skip'] == 1) {
		$profile = json_decode ( offtheshelf_file_read_contents( get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'profile.json' ), true);
		$new_profile = array(
				'post_type'         => 'profile',
				'post_title'        => $profile['post_data']['post_title'],
				'post_name'         => $profile['post_data']['post_name'],
				'post_content'      => $profile['post_data']['post_content'],
				'comment_status'    => 'closed',
				'ping_status'       => 'closed',
				'post_status'       => 'private',
		);
		$new_profile_id = wp_insert_post( $new_profile );

		// Update meta fields that contain the actual options
		foreach ($profile['post_meta'] as $field => $content) {
			if (substr($field, 0, 1) != "_") { // insert field only if not hidden
				$content = $content[0];

				// if serialized, unserialize
				if (is_serialized( $content )) {
					$content = unserialize( $content );
				}

				update_post_meta( $new_profile_id, $field, $content );
			}
		}

		offtheshelf_save_options(
				array (
						'default_profile' => $new_profile_id,
						'default_profile_blog' => 0,
						'default_profile_woocommerce' => 0
				)
		);

		offtheshelf_save_options(
				array (
						'skipped_setup' => 1
				),
				'offtheshelf_options_global'
		);
	}

	?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Welcome to Off the Shelf for WordPress', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Congratulations! You are now ready to use the theme.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-header">
			<ul>
				<li><?php esc_html_e('Welcome', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Select Template', 'offtheshelf'); ?></li>
				<li class="setup-active"><?php esc_html_e('Finish', 'offtheshelf'); ?></li>
			</ul>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Get assistance!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
		<div id="setup-finish">
			<div id="setup-done">
				<h3><?php esc_html_e('Everything is ready to go', 'offtheshelf'); ?></h3>
				<p>
					<?php esc_html_e('The theme is now ready to be used. You can start editing contents and customizing the template. The user guide that ships with the theme is available to guide you through the user interface.', 'offtheshelf'); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/' ) ) ?>" target="_blank"><?php esc_html_e( "Explore your site", 'offtheshelf' ); ?></a>
			</div>
			<?php if ( ! offtheshelf_support_message_html() ) : ?>
				<div id="theme-support">
					<h4><?php esc_html_e('Customer support is just a click away', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('If at any time you need any assistance, please contact customer support via email or live chat. Please note that we do not provide any customer support through the themeforest comments section though.', 'offtheshelf'); ?></p>
					<a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Get Support from ShapingRain.com', 'offtheshelf'); ?></a>
				</div>
				<div id="theme-registration">
					<h4><?php esc_html_e('Register for premium support and updates', 'offtheshelf'); ?></h4>
					<p><?php esc_html_e('We encourage you to register your license with shapingrain.com to enjoy:', 'offtheshelf'); ?></p>
					<ul>
						<li><?php esc_html_e('Access to premium support, 7 days a week', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Free updates for the product\'s lifetime', 'offtheshelf'); ?></li>
						<li><?php esc_html_e('Access to support resources and add-ons', 'offtheshelf'); ?></li>
					</ul>
					<a href="<?php echo esc_url( admin_url('themes.php?page=offtheshelf-register&from=setup') ); ?>"><?php esc_html_e('Register your license', 'offtheshelf') ;?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php
}


function offtheshelf_setup_page() {
	if ( ! offtheshelf_plugins_active() ) {
		offtheshelf_plugin_page();
		return;
	}

	wp_enqueue_style( 'Admin_Page_Class', SR_ADMIN_URL . '/css/admin_page_class.css' );
	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );
	wp_enqueue_script( 'offtheshelf-image-picker', SR_ADMIN_URL . '/js/image-picker.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'offtheshelf-overlay', SR_ADMIN_URL . '/js/loading-overlay.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'offtheshelf-tether', SR_ADMIN_URL . '/js/tether.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'offtheshelf-drop', SR_ADMIN_URL . '/js/drop.min.js', array( 'jquery', 'offtheshelf-tether' ), null, true );
	wp_enqueue_script( 'offtheshelf-frosty', SR_ADMIN_URL . '/js/frosty.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'offtheshelf-setup', SR_ADMIN_URL . '/js/setup.js', array( 'jquery', 'offtheshelf-image-picker', 'offtheshelf-overlay', 'offtheshelf-tether', 'offtheshelf-drop' ), null, true );

	if ( offtheshelf_option_global( 'finished_setup' ) ) {
		$checked_make_front = '';
		$checked_make_default = '';
	} else {
		$checked_make_front = ' checked="checked"';
		$checked_make_default = ' checked="checked"';
	}

	$import = new offtheshelf_import();

	if (isset($_GET['local'])) {
		$packages = $import->get_available_templates( true );
	} else {
		$packages = $import->get_available_templates();
	}
	?>
	<?php wp_nonce_field( 'offtheshelf-setup-nonce' ); ?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Welcome to Off the Shelf for WordPress', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Before you can use your site with Off the Shelf, we need to set up a few things.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-error" class="setup-block" style="display: none;">
			<h3><?php esc_html_e('An unexpected error has occured', 'offtheshelf'); ?></h3>
			<p id="setup-error-message"></p>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?>
				<p>
					<a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" class="button button-primary button-hero" target="_blank"><?php esc_html_e( "Ask customer support for help", 'offtheshelf' ); ?></a>
				</p>
			<?php endif; ?>
		</div>
		<div id="setup-header">
			<ul>
				<li><?php esc_html_e('Welcome', 'offtheshelf'); ?></li>
				<li class="setup-active"><?php esc_html_e('Select Template', 'offtheshelf'); ?></li>
				<li><?php esc_html_e('Finish', 'offtheshelf'); ?></li>
			</ul>
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Get assistance!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
		<div id="setup-template">
			<div class="section">
				<h3><?php esc_html_e('Select your starting template', 'offtheshelf'); ?> <span class="label-desc has-tip tip-right" title="<?php  esc_attr_e('This is where you select how you would like the theme to look like. This is meant as a starting point, a design from which you can develop your own. You can always come back here and try other designs, too.', 'offtheshelf'); ?>">?</span></h3>
				<div class="select-theme-demo-template">
					<?php if ( !empty ($packages) ) : ?>
						<select name="theme-demo-template" class="at-select image-picker show-labels show-html" id="theme-demo-template">
							<?php foreach ($packages as $package) : ?>
								<option data-img-src="<?php echo $package['preview_thumbnail']; ?>" data-img-label="<?php echo esc_attr($package['title']); ?>" value="<?php echo $package['folder']; ?>"><?php echo $package['title']; ?></option>
							<?php endforeach; ?>
						</select>
					<?php else : ?>
						<p><?php esc_html_e('There are no packages in the repository to install.', 'offtheshelf'); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( !empty ($packages) ) : ?>
				<div class="section">
					<h3><?php esc_html_e('Additional Options', 'offtheshelf'); ?></h3>
					<p>
						<label for="make_front"><input name="make_front" type="checkbox" id="make_front" value="0"<?php echo $checked_make_front; ?>> <?php esc_html_e( 'Set up this template as your static front page.', 'offtheshelf' ); ?> <span class="label-desc has-tip tip-right" title="<?php  esc_attr_e('When this option is checked, the theme will import the selected template and make the newly imported page your front page. You can change your front page later in your WordPress settings.', 'offtheshelf'); ?>">?</span></label>
					</p>
					<p>
						<label for="make_default"><input name="make_default" type="checkbox" id="make_default" value="0"<?php echo $checked_make_default; ?>> <?php esc_html_e( 'Set the profile associated with this template as your site default.', 'offtheshelf' ); ?> <span class="label-desc has-tip tip-right" title="<?php  esc_attr_e('When this option is checked, the theme will make the profile associated with the selected template your site default profile. That way all pages will use the same basic design, e.g. colors, header settings etc.', 'offtheshelf'); ?>">?</span></label>
					</p>
					<?php if ( offtheshelf_option('support_options_dev_mode') ) : ?>
						<p>
							<label for="skip_images"><input name="skip_images" type="checkbox" id="skip_images" value="0"> <?php esc_html_e( 'Skip import of images associated with this template.', 'offtheshelf' ); ?> <span class="label-desc has-tip tip-right" title="<?php  esc_attr_e('If this option is checked, the template import tool will not import any images attached to the template.', 'offtheshelf'); ?>">?</span></label>
						</p>
					<?php endif; ?>
				</div>
				<div class="section">
					<p>
						<a href="javascript:void(0);" class="button button-primary button-hero" id="start-template-setup"><?php esc_html_e( "Proceed with import", 'offtheshelf' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
		</div>
		<?php if (isset($_GET['local'])) : ?>
			<div id="setup-secondary-options" class="section">
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup-upload'), admin_url('themes.php') ) );?>"><?php esc_html_e( 'Upload template package', 'offtheshelf' ); ?></a>
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup'), admin_url('themes.php') ) );?>"><?php esc_html_e( 'Use remote repository', 'offtheshelf' ); ?></a>
			</div>
		<?php else : ?>
			<div id="setup-secondary-options" class="section">
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup', 'local'=>'1'), admin_url('themes.php') ) );?>"><?php esc_html_e( 'Use local repository', 'offtheshelf' ); ?></a>
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup', 'refresh'=>'1'), admin_url('themes.php') ) );?>"><?php esc_html_e( 'Refresh repository', 'offtheshelf' ); ?></a>
				<a href="<?php echo esc_url( add_query_arg(array('page'=>'offtheshelf-setup-upload'), admin_url('themes.php') ) );?>"><?php esc_html_e( 'Upload template package', 'offtheshelf' ); ?></a>
			</div>
		<?php endif; ?>

		<ul class="setup-mini-links">
			<li><a href="#" id="setup-console-toggle"><?php esc_html_e('Show Log Console', 'offtheshelf'); ?></a></li>
		</ul>

		<div id="setup-console" style="display: none;">
			<?php printf ( esc_html__('Started: %s', 'offtheshelf'), date('M j G:i:s T Y') ); ?>
		</div>
	</div>
	<?php
}


function offtheshelf_upload_page() {
	if ( !empty ( $_FILES['package']['tmp_name'] ) ) {
		offtheshelf_upload_setup();
	} else {
		offtheshelf_upload_form();
	}
}

function offtheshelf_upload_setup() {
	$message = false;

	/* Prevent further execution if user is not logged in */
	if ( !is_user_logged_in() ) {
		$this->throw_ajax_error( esc_html__( 'You need to be logged in to upload a theme package.', 'offtheshelf' ) );
	}

	/* Prevent further execution if current user does not have permission to edit theme options */
	if ( !current_user_can('edit_theme_options' ) ) {
		$this->throw_ajax_error( esc_html__( 'The current WordPress user does not have permissions required to edit theme options.', 'offtheshelf' ) );
	}

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	if ( wp_verify_nonce($_POST['_wpnonce'], 'offtheshelf-setup-upload-nonce') ) {
		$file = $_FILES['package']['tmp_name'];
		$name = $_FILES['package']['name'];
		$path_parts = pathinfo( strtolower($name) );
		if ($path_parts['extension'] == "zip") {
			$import = new offtheshelf_import();

			WP_Filesystem();
			$unzipfile = unzip_file( $file, $import->upload_dir);
			unlink($file);

			$template_dir = trailingslashit ( $import->upload_dir ) . $path_parts['filename'];

			if ( $unzipfile && file_exists( $template_dir ) ) {
				$message = esc_html__('The package has been successfully uploaded and extracted into your repository.', 'offtheshelf');
				offtheshelf_upload_form( false, $message, true );
				return;
			} else {
				$message =  esc_html__('There was an error unzipping the file. To resolve this issue, please check your upload directory permissions and refer to all the solutions offered in the troubleshooting guide that ships with the theme. Contact customer support via support@shapingrain.com if you need any help.', 'offtheshelf');
				offtheshelf_upload_form ( true, $message, false );
				return;
			}
		}
		else {
			$message      = esc_html__( "This file is not a valid zip archive.", 'offtheshelf' );
		}
	} else {
		$message      = esc_html__( "There was a problem authenticating you while submitting the form.", 'offtheshelf' );
	}
	offtheshelf_upload_form ( true, $message );
}

function offtheshelf_upload_form( $done = false, $message = false, $success = false ) {
	wp_enqueue_style( 'offtheshelf-setup-css', SR_ADMIN_URL . '/css/setup.css' );
	?>
	<div class="wrap about-wrap" id="setup-container">
		<div class="changelog">
			<h1><?php esc_html_e( 'Welcome to Off the Shelf for WordPress', 'offtheshelf' ); ?></h1>
			<h2><?php esc_html_e( 'Before you can use your site with Off the Shelf, we need to set up a few things.', 'offtheshelf' ); ?></h2>
		</div>
		<div id="setup-upload">
			<h3><?php esc_html_e('Upload Template Package', 'offtheshelf'); ?></h3>
			<?php
			if ($message) {
				if ( $success ) {
					echo '<div class="offtheshelf-setup-error registration-updated message-updated"><p>' . $message . '</p></div>';
				} else {
					echo '<div class="offtheshelf-setup-error registration-updated message-error"><p>' . $message . '</p></div>';
				}
			}
			?>
			<?php if ( $success == false ) : ?>
				<p>
					<?php esc_html_e('Please select a template package in .zip format. Only Off the Shelf for WordPress packages are supported.', 'offtheshelf'); ?>
				</p>
				<form method="post" enctype="multipart/form-data" id="offtheshelf-setup-upload-form">
					<?php wp_nonce_field( 'offtheshelf-setup-upload-nonce' ); ?>
					<p class="package-upload">
						<input type="file" name="package">
					</p>
					<p class="package-submit">
						<input type="submit" value="<?php esc_html_e( "Upload package", 'offtheshelf' ); ?>" name="submit" class="button button-primary button-hero">
					</p>
				</form>
			<?php else : ?>
				<p>
					<a href="<?php echo esc_url( admin_url('themes.php?page=offtheshelf-setup&local=1') ); ?>" class="button button-primary button-hero"><?php esc_html_e('View local repository', 'offtheshelf') ;?></a>
				</p>
			<?php endif; ?>
		</div>
		<div class="return-to-dashboard">
			<?php if ( ! offtheshelf_hide_support_links() ) : ?><a href="<?php echo esc_url( SR_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e('Need Help? Get assistance!', 'offtheshelf'); ?></a><?php endif; ?>
		</div>
	</div>
	<?php
}

function offtheshelf_welcome() {
	if ( ! offtheshelf_option_global('setup_init_done') ) {
		// theme has never before been activated, so we need to run initial setup routine
		offtheshelf_setup_initial_setup();
		wp_redirect(admin_url("themes.php?page=offtheshelf-welcome"));
	} else {
		// we've already done the initial setup, so we are taking the user right to the finish page
		wp_redirect(admin_url("themes.php?page=offtheshelf-finish"));
	}
}
add_action('after_switch_theme', 'offtheshelf_welcome');

/*
 * Initial Setup, Options Import
 */

function offtheshelf_setup_initial_setup() {
	// import set of theme options
	offtheshelf_import_raw_options();

	// import default widgets if sidebar areas are empty
	if ( !is_active_sidebar('ots-footer-widgets') ) {
		$import = new offtheshelf_import();
		$import->import_widget_data();
	}

	// re-init some options
	offtheshelf_save_options(
			array (
					'default_profile' => 0,
					'default_profile_blog' => 0,
					'default_profile_woocommerce' => 0
			)
	);

	// mark setup as completed
	offtheshelf_save_options( array ( 'setup_init_done' => true	), 'offtheshelf_options_global' );
}

function offtheshelf_import_raw_options() {
	$options = json_decode( offtheshelf_file_read_contents( get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'options.json' ), true );
	update_option( 'offtheshelf_options', $options );
}


/*
 * Setup Functions
 */

add_action( 'wp_ajax_offtheshelf_setup_images', 'offtheshelf_setup_init' );
add_action( 'wp_ajax_offtheshelf_setup_profiles', 'offtheshelf_setup_init' );
add_action( 'wp_ajax_offtheshelf_setup_modals', 'offtheshelf_setup_init' );
add_action( 'wp_ajax_offtheshelf_setup_banners', 'offtheshelf_setup_init' );
add_action( 'wp_ajax_offtheshelf_setup_pages', 'offtheshelf_setup_init' );
add_action( 'wp_ajax_offtheshelf_setup_finalize', 'offtheshelf_setup_init' );


add_action( 'wp_ajax_offtheshelf_setup_init', 'offtheshelf_setup_init' );
function offtheshelf_setup_init() {

	/* Attempt to prevent timeouts */
	if ( ! ini_get( 'safe_mode' ) ) {
		@set_time_limit( 0 );
	}


	$log_message = '';
	if ( is_user_logged_in() && is_admin() ) {

		if (! wp_verify_nonce($_POST['_ajax_nonce'], 'offtheshelf-setup-nonce')) { /* Check authorization */
			/* output error message and exit from setup procedure */
			$newNonce = wp_create_nonce('offtheshelf-setup-nonce');
			$response['type'] = "error";
			$response['message'] = esc_html__('A security breach was detected.', 'offtheshelf');
			$response['logmessage'] = '';
			$response['run_again'] = false;
			$response['newNonce'] = $newNonce;
			$response = json_encode($response);
			echo $response;
			wp_die();
		} else {
			/* execute setup sequence and generate output */
			$import = new offtheshelf_import();

			/* change filesystem access mode */
			add_filter('filesystem_method', create_function('$a', 'return "direct";' ));

			/* Prevent further execution if current user does not have permission to edit theme options */
			if ( !current_user_can('edit_theme_options' ) ) {
				$import->throw_ajax_error( esc_html__( 'The current WordPress user does not have permissions required to edit theme options.', 'offtheshelf' ) );
			}

			$folder = $_POST['folder'];

			if ( !preg_match('/^[a-zA-Z0-9-_]+$/', $folder) ) {
				$import->throw_ajax_error( esc_html__( 'The selected folder does not look like a valid option and execution of this command has been denied for security reasons. Please contact support if you think this happened in error.', 'offtheshelf' ) );
			}

			$action = $_POST['action'];

			$type = false;

			// some checks prior to import process to start
			if ($action == 'offtheshelf_setup_init') {
				$id = $import->get_transient_id( $folder );
				delete_transient( $id );

				if ( ! wp_mkdir_p( $import->upload_dir ) ) {
					$import->throw_ajax_error( esc_html__( 'Your WordPress upload directory does not exist or cannot be written to. Please check your WordPress directory permissions and try again.', 'offtheshelf' ) );
				}

				if ( ! offtheshelf_option_global('setup_init_done') ) {
					// theme has never before been activated, so we need to run initial setup routine
					offtheshelf_setup_initial_setup();
				}
			}


			// download package file, if necessary
			if ($action == 'offtheshelf_setup_init') {
				// prepare for installation

				// download package or use local copy
				if ( file_exists( $import->upload_dir . DIRECTORY_SEPARATOR . $folder )) {
					// this folder already exists
				} else {
					$download_url = $import->repository_manifest_url . $folder . '.zip';
					// this folder does not exist, so we need to download and unzip the package
					$package_file = download_url( $download_url, 60 );

					if ( empty ( $package_file->errors ) ) { // if download successful
						WP_Filesystem();
						$unzip_package = unzip_file( $package_file, $import->upload_dir);
						unlink( $package_file );
					} // if download successful
					else {
						$errors = $package_file->get_error_messages();
						$import->throw_ajax_error( sprintf (  offtheshelf_esc_html ( __( 'Download of package file (%1$s) from repository failed: %2$s.<br />If this issue persists, consider following the user guide\'s instructions for installing a template package manually or contact customer support for assistance.', 'offtheshelf' ) ), $download_url, implode(" ", $errors ) ) );
					}
				}

				// check manifest, compare versions
				$manifest = $import->get_manifest_by_type( $folder, 'page' );
				if ( $manifest ) {
					$min_version = '1.0.0';
					if ( !empty ( $manifest['min_version'] ) )
						$min_version = $manifest['min_version'];

					if ( $import->version_compare( $import->current_theme_version(), $min_version) >= 0) {
						// everything's fine, the current theme version supports this package
					}
					else {
						$import->throw_ajax_error( esc_html__( 'The installed theme does not support this package. Please update the theme to its latest version.', 'offtheshelf' ) . ' (' . $min_version . ' >= ' . $import->current_theme_version() . ')' );
					}

				} else {
					$import->throw_ajax_error( esc_html__( 'Unable to read package manifest. Extraction of the package may have failed due to a lack of file permissions, or the package file was corrupted. Delete the package folder and try again.', 'offtheshelf' ) . ' (' . $folder . ')' );
				}

			}

			// import images first
			if ($action == 'offtheshelf_setup_images')
				$type = 'image';

			// import profiles
			if ($action == 'offtheshelf_setup_profiles')
				$type = 'profile';

			// import modals
			if ($action == 'offtheshelf_setup_modals')
				$type = 'modal';

			// import banners
			if ($action == 'offtheshelf_setup_banners')
				$type = 'banner';

			// import pages
			if ($action == 'offtheshelf_setup_pages')
				$type = 'page';

			// finalize import
			$redirect = '';
			if ($action == 'offtheshelf_setup_finalize') {
				$new_options = array();

				/*
				 * Import button styles associated with template
				 */
				if ( file_exists( $import->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'button_styles.json' ) ) {
					$new_button_styles = json_decode( offtheshelf_file_read_contents($import->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'button_styles.json'), true );
					$old_button_styles = offtheshelf_option( 'global_button_styles' );

					// only proceed if there is actually a button style to import
					$has_new_button_styles = false;
					if ( is_array ( $new_button_styles ) && count ( $new_button_styles) > 0 ) {
						if ( is_array ( $old_button_styles ) && count ( $old_button_styles ) > 0 ) {
							// button styles exist, so let's check if the ones to add already exist, and if no add them
							foreach ( $new_button_styles as $new_style_uuid => $new_button_style ) {
								if ( ! $import->array_subkey_value_match ( $old_button_styles, 'uid', $new_style_uuid ) ) {
									$old_button_styles[] = $new_button_style;
									$has_new_button_styles = true;
								}
							}
						}
						else {
							// no button styles defined, so just add the new styles
							$old_button_styles = array();
							foreach ( $new_button_styles as $new_button_style ) {
								$old_button_styles[] = $new_button_style;
								$has_new_button_styles = true;
							}
						}

						if ( $has_new_button_styles ) {
							$new_options['global_button_styles'] = $old_button_styles;
						}
					}
				}


				/*
				 * Import forms associated with template
				 */
				if ( file_exists( $import->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'forms.json' ) ) {
					$new_forms = json_decode( offtheshelf_file_read_contents($import->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'forms.json'), true );
					$old_forms = offtheshelf_option( 'forms' );

					// only proceed if there is actually a button style to import
					$has_new_forms = false;
					if ( is_array ( $new_forms ) && count ( $new_forms ) > 0 ) {
						if ( is_array ( $old_forms ) && count ( $old_forms ) > 0 ) {
							// forms exist, so let's check if the ones to add already exist, and if no add them
							foreach ( $new_forms as $new_form_uuid => $new_form ) {
								if ( ! $import->array_subkey_value_match ( $old_forms, 'form_uid', $new_form_uuid ) ) {
									$old_forms[] = $new_form;
									$has_new_forms = true;
								}
							}
						}
						else {
							// no forms defined, so just add the new styles
							$old_forms = array();
							foreach ( $new_forms as $new_form ) {
								$old_forms[] = $new_form;
								$has_new_forms = true;
							}
						}

						if ( $has_new_forms ) {
							$new_options['forms'] = $old_forms;
						}
					}
				}


				// save button styles and forms
				if ( count ( $new_options ) > 0 ) {
					offtheshelf_save_options( $new_options );
				}

				// mark setup status as finished
				offtheshelf_save_options(
						array (
								'finished_setup' => 1
						),
						'offtheshelf_options_global'
				);
				$redirect = admin_url('themes.php?page=offtheshelf-finish&from=setup');
			}

			// if something (a package component) should actually be imported now
			$run_again = false;
			if ($type) {
				$log_message = date('M j G:i:s T Y') . ": " . esc_html__('Finished step:', 'offtheshelf') . " " . ucfirst($type) . "\n";
				$result = $import->import_package ( $folder, $type );
				$log_message .= $result['message'];
				$run_again = $result['run_again'];
				$log_message = nl2br($log_message);
			}

			// prepare text response
			$newNonce = wp_create_nonce('offtheshelf-setup-nonce');
			$response['type'] = "success";
			$response['message'] = esc_html__('Initialization successful.', 'offtheshelf');
			$response['logmessage'] = $log_message;
			$response['run_again'] = $run_again;
			$response['newNonce'] = $newNonce;
			$response['redirect'] = $redirect;
			$response = json_encode($response);
			echo $response;
			wp_die();
		}
	}
}

/*
 * Import Class
 */

class offtheshelf_import {
	public $upload_dir = '';
	public $upload_url = '';

	private $image_manifest = array();

	public $image_mapping = array();
	public $modal_mapping = array();

	//public $repository_manifest_url = 'http://repository.shapingrain.com/offtheshelfwp/'; // original repository
	public $repository_manifest_url = 'http://d1kz3q8ez01zmf.cloudfront.net/offtheshelfwp/'; // faster, cloud-based repository

	private $widgets_with_images = array (
			'OffTheShelf_Image_Widget' => 'image',
			'OffTheShelf_Gallery_Widget' => 'ids', // multiple
			'OffTheShelf_Feature_Media_Widget' => 'image',
			'OffTheShelf_Icon_Block_Widget' => 'custom_icon',
			'OffTheShelf_Bio_Block_Widget' => 'avatar',
			'OffTheShelf_Testimonial_Widget' => 'avatar',
			'OffTheShelf_Slider_Widget' => 'items', // multiple
			'OffTheShelf_Portfolio_Item_Widget' => 'image'
	);

	private $widgets_with_modals = array (
			'OffTheShelf_Link_Widget' => 'modal',
			'OffTheShelf_Button_Widget' => 'modal',
			'OffTheShelf_Image_Widget' => 'modal',
			'OffTheShelf_CTA_Box_Widget' => 'modal',
			'OffTheShelf_Pricing_Block_Widget' => 'modal',
			'OffTheShelf_Split_Button_Widget' => array( 'modal_left', 'modal_right' )
	);

	private $profile_option_with_images = array (
			'sr_ots_body_background_image',
			'sr_ots_background_image',
			'sr_ots_header_logo_image'
	);

	function __construct() {
		$ots_upload_dir_tmp = wp_upload_dir();
		$ots_upload_dir = $ots_upload_dir_tmp['basedir'] . DIRECTORY_SEPARATOR . 'offtheshelf_exports';
		$ots_upload_url = $ots_upload_dir_tmp['baseurl'] . '/' . 'offtheshelf_exports';

		$this->upload_dir = $ots_upload_dir;
		$this->upload_url = $ots_upload_url;
	}

	public function get_random_string( $length = 10 ) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function array_subkey_value_match( $var, $field, $val ) {
			foreach($var as $key => $row)
			{
				if ( isset ( $row[$field] ) && $row[$field] == $val )
					return true;
			}
			return false;
	}

	public function throw_ajax_error( $message ) {
		$newNonce = wp_create_nonce('offtheshelf-setup-nonce');
		$response['type'] = "error";
		$response['message'] = $message;
		$response['logmessage'] = '';
		$response['run_again'] = false;
		$response['newNonce'] = $newNonce;
		$response = json_encode($response);
		echo $response;
		wp_die();
	}

	public function get_available_templates( $local = false ) {
		if ( isset($_GET['refresh'] ) ) {
			delete_transient( 'ots_setup_template_repo' );
		}

		if ($local) {
			$page_id = 0;
			$page_file = false;
			$packages = false;

			$weeds = array('.', '..');
			$directories = array_diff(scandir($this->upload_dir), $weeds);
			if ( ! empty ( $directories ) ) {
				foreach($directories as $dir)
				{
					if ( is_dir ( $this->upload_dir . DIRECTORY_SEPARATOR . $dir ) )
					{
						if ( file_exists($this->upload_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'manifest.json') ) { // if directory contains a package manifest
							$manifest = json_decode( offtheshelf_file_read_contents($this->upload_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'manifest.json'), true );

							if ( ! empty ($manifest ) ) {
								foreach ( $manifest as $id => $meta ) {
									if ( $meta['type'] == "page" ) {
										$page_id   = $id;
										$page_file = $meta['file'];
										break;
									}
								}
							}

							if ($page_file) {
								$page = json_decode( offtheshelf_file_read_contents( $this->upload_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $page_file ), true ) ;
								$packages[] = array (
										'folder' => $dir,
										'title' => $page['post_data']['post_title'],
										'id' => $page_id,
										'file' => $page_file,
										'local' => true,
										'preview_thumbnail' => $this->upload_url . "/" . $dir . "/preview.jpg"
								);
							}
						}
					}
				}
			}
		} else {
			$manifest = array();
			if ( ! $packages = get_transient( 'ots_setup_template_repo' ) ) { // check if local copy available
				$rnd = $this->get_random_string(5);
				$manifest_file = download_url( $this->repository_manifest_url . 'index.json?rnd=' . $rnd , 30 );
				if ( empty ( $manifest_file->errors ) ) { // if download successful
					$packages = json_decode( offtheshelf_file_read_contents( $manifest_file ), true );
					set_transient( 'ots_setup_template_repo', $packages, 14400 );
					unlink( $manifest_file );
				} // if download successfully
				else { // download was not successful
					$packages = $this->get_available_templates( true ); // try and use local directory structure
				}
			} // local copy not available
			else { // local copy is available
				// we already have a local transient copy - do nothing
			}

			// if packages are not based on directory structure, check if local directory copy exists
			if ( !empty ($packages) ) { // if we actually have packages to analyze
				$x=0;
				foreach ($packages as $package) {
					$dir = $package['folder'];
					if(is_dir($this->upload_dir . DIRECTORY_SEPARATOR . $dir)) { // directory exists locally
						$packages[$x]['local'] = true;
						$packages[$x]['preview_thumbnail'] = $this->upload_url . "/" . $dir . "/preview.jpg";

					} else { // directory does not exist, this must be downloaded first
						$packages[$x]['local'] = false;
						$packages[$x]['preview_thumbnail'] = $this->repository_manifest_url . $dir . "-preview.jpg";
					}
					$x++;
				}
			}
		} // not only local
		return $packages;
	}

	public function current_theme_version () {
		$my_theme = wp_get_theme();
		return $my_theme->get( 'Version' );
	}

	function version_compare($ver1, $ver2, $operator = null)
	{
		$p = '#(\.0+)+($|-)#';
		$ver1 = preg_replace($p, '', $ver1);
		$ver2 = preg_replace($p, '', $ver2);
		return isset($operator) ?
				version_compare($ver1, $ver2, $operator) :
				version_compare($ver1, $ver2);
	}

	public function get_manifest ( $folder ) {
		$manifest = json_decode( offtheshelf_file_read_contents($this->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'manifest.json'), true );
		return $manifest;
	}

	public function get_manifest_by_type ( $folder, $type ) {
		$manifest = json_decode( offtheshelf_file_read_contents($this->upload_dir . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'manifest.json'), true );
		if ( $manifest ) {
			foreach ( $manifest as $id => $options ) {
				if ( !empty ($options['type'] ) ) {
					if ( $type == $options{'type'} ) {
						return $options;
					}
				}
			}
			echo 'there!';
		}
		return false;
	}

	public function get_transient_id ( $folder ) {
		return "ots_setup_" . str_replace ("-", "", filter_var( $folder, FILTER_SANITIZE_NUMBER_INT ) );
	}

	private function get_temp_defaults () {
		$defaults = array(
				'new_banner_id' => 0,
				'new_profile_id' => 0,
				'new_page_id' => 0,
		);
		return $defaults;
	}

	private function get_temp( $folder ) {
		$defaults = $this->get_temp_defaults();
		$id = $this->get_transient_id( $folder );
		$db_settings = get_transient( $id );
		if ($db_settings) {
			return array_merge($defaults, $db_settings);
		} else {
			return $defaults;
		}
	}

	private function set_temp ( $folder, $new_settings ) {
		$id = $this->get_transient_id( $folder );

		$db_settings = get_transient( $id );
		$defaults = $this->get_temp_defaults();
		if ($db_settings) {
			$settings = array_merge($defaults, $db_settings);
		} else {
			$settings = $defaults;
		}

		$settings = array_merge($settings, $new_settings);

		set_transient( $id, $settings, 360 );
		return $settings;
	}

	public function import_package( $folder, $type ) {
		$ots_upload_dir     = $this->upload_dir . "/" . $folder;

		$settings = $this->get_temp( $folder ); // retrieve settings for this import

		/* New object IDs */
		$new_profile_id = $settings['new_profile_id'];
		$new_banner_id  = $settings['new_banner_id'];

		$modals = array();

		$log_message = '';
		$run_again = false;

		$manifest = $this->get_manifest( $folder );

		/*
		 * Parse Manifest
		 */
		foreach ($manifest as $id => $meta) {
			if ($meta['type'] == "page") {
				$page_id = $id;
				$page_file = $meta['file'];
			}
			elseif ($meta['type'] == "profile") {
				$profile_id = $id;
				$profile_file = $meta['file'];
			}
			elseif ($meta['type'] == "banner") {
				$banner_id = $id;
				$banner_file = $meta['file'];
			}
			elseif ($meta['type'] == "modal") {
				$modals[] = array(
						'id' => $id,
						'file' => $meta['file']
				);
			}
		}

		/* Parse Modal Window Mapping File */
		if (file_exists( $ots_upload_dir . DIRECTORY_SEPARATOR . 'modal_mapping.json' )) {
			$this->modal_mapping = json_decode ( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . 'modal_mapping.json' ), true );
		}

		/*
		 * Parse Image Manifest
		 */
		$image_manifest = json_decode ( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . 'image_manifest.json' ), true );

		$image_mapping_tmp = get_transient( "otsimg_" . md5 ( $ots_upload_dir ) );
		if ( $image_mapping_tmp ) {
			$this->image_mapping = json_decode ( $image_mapping_tmp , true );
		} else {
			$this->image_mapping = array();
		}

		/*
		 * Import all required images before importing pages, profiles and other resources
		 */
		if ( $type == "image" && count ($image_manifest) > 0 ) {

			$max_index = count ( $image_manifest ) - 1;
			$last = $_REQUEST['last'];

			$image = array_slice ( $image_manifest, $last, 1 );
			$image = $image[0];

			if ( ! array_key_exists ($image['original_id'], $this->image_mapping) ) { // process only if image has not already been imported previously
				$filename = trailingslashit ( $ots_upload_dir ) . $image['file'];
				$parent_post_id = 0;
				$filetype = wp_check_filetype( $filename, null );

				$attachment = array(
					'guid'           => $image['file'],
					'post_mime_type' => $filetype['type'],
					'post_title'     => $image['wp_meta']['title'],
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// attach image to WP uploads database
				$attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

				// generate meta data
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				$this->image_mapping[$image['original_id']] = array(
					'url' => wp_get_attachment_url( $attach_id ),
					'original_id' => $image['original_id'],
					'new_id' => $attach_id
				);
				$log_message .= esc_html__('Imported image with new ID ', 'offtheshelf') . $attach_id . "\n";
			} else {
				$log_message .= esc_html__('Skipped image with original ID ' . $image['original_id'] . ' (already exists)', 'offtheshelf' ) . "\n";
			}

			$next = $last + 1;
			if ( $next <= $max_index ) {
				$run_again = $next;
			}

			set_transient( "otsimg_" . md5 ( $ots_upload_dir ), json_encode( $this->image_mapping ), 0 );
		}


		/*
		 * Import associated profile and re-assign images
		 */
		if ($type == "profile") {
			if (isset($profile_file)) {
				$profile = json_decode ( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . $profile_file ), true );

				$new_profile = array(
						'post_type'         => 'profile',
						'post_title'        => $profile['post_data']['post_title'],
						'post_name'         => $profile['post_data']['post_name'],
						'post_content'      => $profile['post_data']['post_content'],
						'comment_status'    => 'closed',
						'ping_status'       => 'closed',
						'post_status'       => 'private',
				);

				// Insert the profile into the database
				$new_profile_id = wp_insert_post( $new_profile );
				$this->set_temp( $folder, array('new_profile_id' => $new_profile_id) );

				// Update meta fields that contain the actual options
				foreach ($profile['post_meta'] as $field => $content) {
					if (substr($field, 0, 1) != "_") { // insert field only if not hidden
						$content = $content[0];

						// if serialized, unserialize
						if (is_serialized( $content )) {
							$content = unserialize( $content );
						}

						// if this option contains an image
						if ( in_array( $field, $this->profile_option_with_images ) ) {
							$old_image_id   = $content['id'];
							$content['id']  = $this->image_mapping[$old_image_id]['new_id'];
							$content['url'] = $this->image_mapping[$old_image_id]['url'];
						}

						update_post_meta( $new_profile_id, $field, $content );
					}
				}

				if ( ! empty ( $_REQUEST['make_default'] ) && $_REQUEST['make_default'] == "true" )  {
					offtheshelf_save_options(
							array (
									'default_profile' => $new_profile_id,
							)
					);
				}

			}
		}

		/*
		 * Import modal windows
		 */
		if ($type == "modal" && !empty ($modals)) {
			foreach ($modals as $modal_data) {
				$modal_file = $modal_data['file'];
				$modal_old_id = $modal_data['id'];
				if ( isset ( $modal_file ) ) {
					$modal = json_decode( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . $modal_file ), true );

					$new_modal = array(
							'post_type'         => 'modal',
							'post_title'        => $modal['post_data']['post_title'],
							'post_name'         => $modal['post_data']['post_name'],
							'post_content'      => $modal['post_data']['post_content'],
							'comment_status'    => 'closed',
							'ping_status'       => 'closed',
							'post_status'       => 'publish',
					);

					// Insert the modal post type into the database
					$new_modal_id = wp_insert_post( $new_modal );
					$this->modal_mapping[$modal_old_id] = array(
							'original_id' => $modal_old_id,
							'new_id' => $new_modal_id
					);

					// Update meta fields that contain the actual options
					foreach ($modal['post_meta'] as $field => $content) {
						if (substr($field, 0, 1) != "_") { // insert field only if not hidden
							$content = $content[0];

							// if serialized, unserialize
							if (is_serialized( $content )) {
								$content = unserialize( $content );
							}

							if ( $field == "panels_data") { // modify panels data to replace references to images
								$content = $this->map_panels_images( $content, $this->image_mapping );
							}
							update_post_meta( $new_modal_id, $field, $content );
						}
					}
				}
			}
			offtheshelf_file_write_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . 'modal_mapping.json', json_encode( $this->modal_mapping ) );
		}



		/*
		 * Import banner
		 */
		if ($type == "banner") {
			if ( isset ( $banner_file ) ) {
				$banner = json_decode( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . $banner_file ), true );

				$new_banner = array(
						'post_type'         => 'banner',
						'post_title'        => $banner['post_data']['post_title'],
						'post_name'         => $banner['post_data']['post_name'],
						'post_content'      => $banner['post_data']['post_content'],
						'comment_status'    => 'closed',
						'ping_status'       => 'closed',
						'post_status'       => 'publish',
				);

				// Insert the banner into the database
				$new_banner_id = wp_insert_post( $new_banner );
				$this->set_temp( $folder, array('new_banner_id' => $new_banner_id) );

				// Update meta fields that contain the actual options
				foreach ($banner['post_meta'] as $field => $content) {
					if (substr($field, 0, 1) != "_") { // insert field only if not hidden
						$content = $content[0];

						// if serialized, unserialize
						if (is_serialized( $content )) {
							$content = unserialize( $content );
						}

						if ( $field == "panels_data") { // modify panels data to replace references to images and modals
							$content = $this->map_panels_images( $content, $this->image_mapping );
							$content = $this->map_panels_modals( $content, $this->modal_mapping );
						}

						if ( in_array( $field, $this->profile_option_with_images ) ) {
							$old_image_id   = $content['id'];
							$content['id']  = $this->image_mapping[$old_image_id]['new_id'];
							$content['url'] = $this->image_mapping[$old_image_id]['url'];
						}

						update_post_meta( $new_banner_id, $field, $content );
					}
				}
			}
		}


		/*
		 * Import page
		 */
		if ( $type == "page" ) {
			if ( isset ( $page_file ) ) {
				$page = json_decode ( offtheshelf_file_read_contents( $ots_upload_dir . DIRECTORY_SEPARATOR . $page_file ), true );

				$new_page = array(
						'post_type'         => 'page',
						'post_title'        => $page['post_data']['post_title'],
						'post_name'         => $page['post_data']['post_name'],
						'post_content'      => $page['post_data']['post_content'],
						'comment_status'    => 'closed',
						'ping_status'       => 'closed',
						'post_status'       => 'publish',
				);

				// Insert the page into the database
				$new_page_id = wp_insert_post( $new_page );
				$this->set_temp( $folder, array('new_page_id' => $new_page_id) );

				// Update meta fields that contain the actual options
				foreach ($page['post_meta'] as $field => $content) {
					if (substr($field, 0, 1) != "_") { // insert field only if not hidden
						$content = $content[0];

						// if serialized, unserialize
						if (is_serialized( $content )) {
							$content = unserialize( $content );
						}

						if ( $field == "panels_data") { // modify panels data to replace references to images and modals
							$content = $this->map_panels_images( $content, $this->image_mapping );
							$content = $this->map_panels_modals( $content, $this->modal_mapping );
						}

						if ( $field == "sr_ots_profile") { // assign newly imported profile
							$content = $new_profile_id;
						}

						if ( $field == "sr_ots_custom_banner") { // assign newly imported banner
							$content = $new_banner_id;
						}

						update_post_meta( $new_page_id, $field, $content );
					}
				}

				if ( ! empty ( $_REQUEST['make_front'] ) && $_REQUEST['make_front'] == "true" )  {
					update_option( 'page_on_front', $new_page_id );
					update_option( 'show_on_front', 'page' );
				}

			}
		}

		$result = array (
			'message' => $log_message,
			'run_again' => $run_again
		);

		return $result;
	}

	function map_panels_images( $content, $image_mapping )
	{

		// if there are no widgets in this one, return with original content as there are no images to process
		if ( empty($content['widgets']) )
			return $content;

		// process widgets
		foreach ($content['widgets'] as $idx => $options) {
			if ( !empty ( $options['panels_info']['class'] ) ) {
				$class = $options['panels_info']['class'];
				if ( array_key_exists( $class, $this->widgets_with_images ) ) {
					$field_to_map = $this->widgets_with_images[$class];
					$old_image_id = $options[$field_to_map];
					if ( substr_count( $old_image_id, "," ) > 0 ) {  // we have multiple IDs
						$new_image_ids = array();
						$old_image_ids = explode ( ",", $old_image_id );
						foreach ($old_image_ids as $old_image_id) {
							if ( array_key_exists($old_image_id, $image_mapping) ) {
								$new_image_ids[] = $image_mapping[$old_image_id]['new_id'];
							}
						}
						$new_image_id = implode (",", $new_image_ids);
						$content['widgets'][$idx][$field_to_map] = $new_image_id;
					} else { // we have a single ID
						if ( array_key_exists($old_image_id, $image_mapping) ) {
							$new_image_id = $image_mapping[$old_image_id]['new_id'];
							$content['widgets'][$idx][$field_to_map] = $new_image_id;
						}
					}
				}

				if ( isset ( $options['panels_info']['style']['background_image_attachment'] ) ) { // if widget style is set
					$old_image_id = $options['panels_info']['style']['background_image_attachment'];
					if ($old_image_id > 0) {
						if ( array_key_exists($old_image_id, $image_mapping) ) {
							$new_image_id = $image_mapping[ $old_image_id ]['new_id'];
							$content['widgets'][ $idx ]['panels_info']['style']['background_image_attachment'] = $new_image_id;
						}
					}
				}
			}
		}

		// process row styles
		foreach ($content['grids'] as $idx => $options) {
			if ( isset ( $options['style']['background_image_attachment'] ) ) { // if widget style is set
				$old_image_id = $options['style']['background_image_attachment'];
				if ($old_image_id > 0) {
					$new_image_id = $image_mapping[$old_image_id]['new_id'];
					$content['grids'][$idx]['style']['background_image_attachment'] = $new_image_id;
				}
			}
		}
		return $content;
	}

	function map_panels_modals( $content, $modal_mapping )
	{
		if ( empty($content['widgets']) )
			return $content;

		// process widgets
		foreach ($content['widgets'] as $idx => $options) {
			if ( !empty ( $options['panels_info']['class'] ) ) {
				$class = $options['panels_info']['class'];
				if ( array_key_exists( $class, $this->widgets_with_modals ) ) {
					$fields_to_map = $this->widgets_with_modals[$class];

					if ( !is_array( $fields_to_map ) )
						$fields_to_map = array ( $fields_to_map );

					if ( !empty ($fields_to_map ) ) {
						foreach ($fields_to_map as $field_to_map) {
							if ( !empty ( $options[$field_to_map] ) ) {
								$old_modal_id = $options[$field_to_map];
								if ( array_key_exists($old_modal_id, $modal_mapping) ) {
									$new_modal_id = $modal_mapping[$old_modal_id]['new_id'];
									$content['widgets'][$idx][$field_to_map] = $new_modal_id;
								}
							}
						}
					}
				}
			}
		}
		return $content;
	}


	/*
	 * Widget Import Features
	 * Based on "Widget Data" plug-in
	 * Original authors: Voce Communications - Kevin Langley, Sean McCafferty, Mark Parolisi
	 * http://vocecommunications.com
	 * Licensed unter GPLv3
	 */

	/**
	 * Import widgets
	 */
	public static function parse_import_data( $import_array ) {
		$sidebars_data = $import_array[0];
		$widget_data = $import_array[1];
		$current_sidebars = get_option( 'sidebars_widgets' );
		$new_widgets = array( );

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $current_sidebars[$import_sidebar] ) ) :
					$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					$new_widget_name = self::get_new_widget_name( $title, $index );
					$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] = $widget_data[$title][$index];
						$multiwidget = $new_widgets[$title]['_multiwidget'];
						unset( $new_widgets[$title]['_multiwidget'] );
						$new_widgets[$title]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[$new_index] = $widget_data[$title][$index];
						$current_multiwidget = $current_widget_data['_multiwidget'];
						$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
						$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[$title] = $current_widget_data;
					}

				endif;
			endforeach;
		endforeach;

		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );

			foreach ( $new_widgets as $title => $content ) {
				$content = apply_filters( 'widget_data_import', $content, $title );
				update_option( 'widget_' . $title, $content );
			}

			return true;
		}

		return false;
	}

	/**
	 * Parse JSON import file and load
	 */
	public static function import_widget_data( $import_file = false, $widgets_file = false ) {

		if (!$import_file) {
			$import_file = get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'widgets_data.json';
		}

		if (!$widgets_file) {
			$widgets_file = get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'widgets.json';
		}

		$json_data = json_decode( offtheshelf_file_read_contents( $import_file ), true );
		$widgets   = json_decode( offtheshelf_file_read_contents( $widgets_file ), true );

		$sidebar_data = $json_data[0];
		$widget_data = $json_data[1];

		$is_sidebars = false;
		$is_widgets  = false;

		if ( is_array( $sidebar_data ) && count ( $sidebar_data ) > 0 ) {
			foreach ( $sidebar_data as $title => $sidebar ) {
				$count = count( $sidebar );
				for ( $i = 0; $i < $count; $i++ ) {
					$widget = array( );
					$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
					$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
					if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
						unset( $sidebar_data[$title][$i] );
					}
				}
				$sidebar_data[$title] = array_values( $sidebar_data[$title] );
			}
		}

		if ( is_array( $widgets ) && count ( $widgets ) > 0 ) {
			foreach ( $widgets as $widget_title => $widget_value ) {
				foreach ( $widget_value as $widget_key => $widget_value ) {
					$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
				}
			}
		}

		if ( $is_sidebars && $is_widgets ) {
			$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
			self::parse_import_data( $sidebar_data );
		}

	}

	public static function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}

} // end of import class


/*
 * Hook into admin page class to prevent execution of options panel if plugins are missing
 */

function offtheshelf_redirect_to_plugins() {
	if ( ! offtheshelf_plugins_active() ) {
		offtheshelf_plugin_page();
		define('ADMIN_CLASS_SKIP_PAGE', true);
		return;
	}
}
//add_action( 'admin_page_class_before_page', 'offtheshelf_redirect_to_plugins' );

/*
 * Show start setup notice until installation has been completed or skipped
 */
function offtheshelf_setup_admin_error_notice() {
	if ( offtheshelf_option_global( 'skipped_setup' ) || offtheshelf_option_global( 'finished_setup' ) ) {
		// We have skipped or previously completed the setup
	} else {
		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else {
			$page = false;
		}

		$exemptions = array('tgmpa-install-plugins', 'offtheshelf_admin_page');

		if ( substr_count( $page, 'offtheshelf-' ) == 0 && ! in_array ( $page, $exemptions ) ) {
			$class = "update-nag";
			$welcome = esc_html__('Welcome to Off the Shelf for WordPress!', 'offtheshelf');
			$message = esc_html__('The theme has been installed and activated but it has not been set up. In order to use the theme, please proceed with the setup procedure.', 'offtheshelf');
			$button = esc_html__('Proceed with theme setup', 'offtheshelf');
			echo '<div class="' . $class . '"><h2>' . $welcome . '</h2><p>' . $message . '</p><p><a href="' .  esc_url( admin_url( 'themes.php?page=offtheshelf-welcome' ) ) . '" class="button button-primary button-hero" id="start-setup">' . $button . '</a></p></div>';
		}
	}
}
add_action( 'admin_notices', 'offtheshelf_setup_admin_error_notice' );

