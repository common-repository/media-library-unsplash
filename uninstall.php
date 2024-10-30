<?php
/**
 * Delete option data
 * @since 1.0.0
 * @author tCoderBD <touhid@tcoderbd.com>
 * @package MediaLibraryUnsplash
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete options.
delete_option( 'tcbdaml_api_key' );
