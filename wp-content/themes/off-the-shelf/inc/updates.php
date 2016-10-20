<?php
/*
 * Update checker initialization
 */

if (!function_exists('offtheshelf_update_check')) {
	function offtheshelf_update_check() {
		$domain_hash = sha1(home_url());
		$license_key = trim(offtheshelf_option('license_key'));
		if (!isset($license_key) || $license_key == "") $license_key = "null";

		$offtheshelf_update_checker = new SRThemeUpdateChecker(
			'off-the-shelf',
			SR_UPDATE_URL . 'update/version/offtheshelfwp/'.$license_key.'/'.$domain_hash.'/' //URL of the metadata file.
		);
		$offtheshelf_update_checker->addQueryArgFilter('offtheshelf_update_check_query_args');
		$offtheshelf_update_checker->addResultFilter('offtheshelf_update_check_results');
		$offtheshelf_update_checker->addHttpRequestArgFilter('offtheshelf_update_check_http_args');
	}
}
if (!function_exists('offtheshelf_update_check_query_args')) {
	function offtheshelf_update_check_query_args($args) {

		return $args;
	}
}
if (!function_exists('offtheshelf_update_check_http_args')) {
	function offtheshelf_update_check_http_args($args) {
		$args['sslverify'] = false;
		return $args;
	}
}
if (!function_exists('offtheshelf_update_check_results')) {
	function offtheshelf_update_check_results($thupdate, $result) {
		global $offtheshelf_admin_notice;
		if (is_object($result)) $result = (array)$result;
		if(isset($result) && is_array($result) && isset($result['response']) && isset($result['response']['code']) && $result['response']['code'] == 404) {
			$offtheshelf_admin_notice = esc_html__('An error has occurred while trying to retrieve update information for Off the Shelf. Please contact support@shapingrain.com if this problem reoccurs.', 'offtheshelf');
			if (isset($result['body'])) $offtheshelf_admin_notice = trim($result['body']);
			add_action( 'admin_notices', 'offtheshelf_update_check_admin_notice' );
		}
		return $thupdate;
	}
}

function offtheshelf_update_check_admin_notice() {
	global $offtheshelf_admin_notice;
	?>
	<div class="error">
		<p><strong><?php esc_html_e('An error has occured while trying to retrieve update information for Off the Shelf. Please check the validity of your license key (or remove the license key if you do not have one) and contact support@shapingrain.com if this problem persists', 'offtheshelf'); ?></strong></p>
		<p><?php echo $offtheshelf_admin_notice; ?></p>
	</div>
<?php
}


add_action('http_request_args', 'offtheshelf_no_ssl_http_request_args', 10, 2);
if (!function_exists('offtheshelf_no_ssl_http_request_args')) {
	function offtheshelf_no_ssl_http_request_args($args, $url) {
		$args['sslverify'] = false;
		return $args;
	}
}

if (defined('OFFTHESHELF_ENABLE_UPDATES') && OFFTHESHELF_ENABLE_UPDATES == true) {
	$disable_updates = get_option('offtheshelf_global_disable_updates');
	if ($disable_updates != true) {
		add_action( 'init', 'offtheshelf_update_check' );
	}
}

